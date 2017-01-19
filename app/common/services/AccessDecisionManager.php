<?php
namespace App\Common\Services;


use App\Common\Models\AclList;
use App\Common\Models\AclResource;
use App\Common\Models\AclRole;
use Phalcon\Acl;

class AccessDecisionManager extends \Phalcon\Di\Injectable {

    private $__acl = null;

    public function decide(Authentication $authed, $resource, $action) {
        $resource = strtoupper($resource);
        $action = strtoupper($action);

        //处理公共资源
        if ($this->isPublic($resource, $action))
            return true;

        if ($authed->isGuest()) return false;

        if ($authed->role < AclRole::ROLE_ADMIN) return true;

        $acl = $this->getAcl();

        $roles = $authed->roles;

        foreach ($roles as $role) {
            $allowed = $acl->isAllowed($role["code"], $resource, $action);
            if ($allowed) return true;
        }

        return false;
    }

    protected function isPublic($resource, $action) {
        //if ($this->startsWith($resource, "HOME:")) return true;

        if ($resource == "HOME:INDEX") return true;
        if ($resource == "HOME:AUTH") return true;
        if ($resource == "HOME:ERROR") return true;
        if ($resource == "CONSOLE:ERROR") return true;
        if ($resource == "CONSOLE:REGION") return true;

        //TODO console:tool
        if ($resource == "CONSOLE:TOOL") return true;
        return false;
    }

    private function startsWith($haystack, $needle){
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    private function getAcl() {
        if ($this->__acl === null) {
            if ($this->config->app->debug) {
                $this->__acl = $this->rebuildAcl();
            } else {
                $this->__acl = $this->buildAcl();
            }
        }
        return $this->__acl;
    }

    private function buildAcl() {
        $cache = $this->cache;
        $cacheKey = "_ACL_";

        $acl = $cache->get($cacheKey);
        if ($acl == null) {
            $acl = $this->rebuidAcl();
            $cache->save($cacheKey, $acl);
        }

        return $acl;
    }

    private function rebuildAcl() {
        $acl = new \Phalcon\Acl\Adapter\Memory();
        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        //定义资源

        $sql = "select r.code as resource, GROUP_CONCAT(a.code) as actions
from acl_authority a inner join acl_resource r on a.resourceId = r.id
where a.enabled = 1 and r.enabled = 1
group by r.code";

        $result = $this->db->query($sql);

        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        while ($row = $result->fetch()) {
            $resource = strtoupper($row["resource"]);
            $actions = explode(',', strtoupper($row["actions"]));
            $acl->addResource($resource, $actions);
        }


        //定义角色

        $roles = AclRole::find();

        foreach ($roles as $role) {
            $acl->addRole($role->code);
        }

        //定义权限

        $sql = "select role.`code` as role, res.`code` as resource, GROUP_CONCAT(a.`code`) as actions
from acl
inner join acl_role role on acl.roleId = role.id and role.enabled = 1
inner join acl_authority a on acl.authId = a.id and a.enabled = 1
inner join acl_resource res on res.id = a.resourceId and res.enabled = 1
group by role.`code`, res.`code`";

        $result = $this->db->query($sql);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
        while ($row = $result->fetch()) {
            $role = $row["role"];
            $resource = strtoupper($row["resource"]);
            $actions = explode(',', strtoupper($row["actions"]));
            $acl->allow($role, $resource, $actions);
        }

        return $acl;
    }
}