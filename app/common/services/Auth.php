<?php
namespace App\Common\Services;

use App\Common\Models\User;
use App\Common\Services\Authentication;
use Phalcon\Mvc\Dispatcher;

class Auth extends \Phalcon\Di\Injectable {
    const ERR_NONE = 0;
    const ERR_USER_NOT_FOUND = 40001;
    const ERR_PASSWORD_ERROR = 40002;
    const ERR_USER_DISABLED  = 40003;
    const ERR_USER_DELETED   = 40004;
    const ERR_USER_LOCKED    = 40005;

    const MSG_USER_NOT_FOUND = "帐号错误";
    const MSG_USER_LOCKED = "由于您连续登录失败的次数过多，为了您的账户安全，请5分钟后重试";


    private $__authentication = null;


    public function __construct() {

    }

    public function getAuthentication() {
        if ($this->__authentication == null) {
            $this->__authentication = $this->authenticate();
        }
        return $this->__authentication;
    }

    protected function authenticate() {
        $config = $this->config;
        $session = $this->session;

        //如果 Session 中存在则直接返回
        $authed = $session->get($config->auth->session_key);

        if ($authed) return $authed;

        $authed = Authentication::newGuest();
        $session->set($config->auth->session_key, $authed);
        return $authed;
    }

    public function allow($resource, $action) {
        //TODO 是否需要判断 $resource 中是否已经包含module
        //确定当前的用户身份
        $authed = $this->getAuthentication();

        return $this->accessManager->decide($authed, $resource, $action);
    }

    public function decide(Dispatcher $dispatcher) {
        //获取当前要访问的资源
        $module     = $dispatcher->getModuleName();
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        //判断是否允许访问
        $allowed = $this->allow("$module:$controller", $action);

        //如果允许操作则返回
        if ($allowed) return true;

        //如果是AJAX请求则返回状态码
        if ($this->request->isAjax()) {
            $this->response->setStatusCode(401, "Unauthorized");
            return false;
        }

        $authed = $this->getAuthentication();

        //如果用户未登录，则跳转登录
        if ($authed->isGuest()) {
            $redirect_uri = $this->buildFullRequestUrl();
            $this->redirectLogin($redirect_uri);
            return false;
        }

        //如果用户已登录，则提示无权限
        $dispatcher->forward(array(
            'controller' => 'error',
            'action'     => 'show401',
            'params'     => array (
                'module'     => $module,
                'controller' => $controller,
                'action'     => $action,
            )
        ));

        return false;
    }

    private function redirectLogin($redirect_uri) {
        $uri = 'auth/signin?redirect_uri=' . urlencode($redirect_uri);
        return $this->response->redirect($uri);
    }

    public function buildFullRequestUrl() {
        $serverName = $_SERVER['SERVER_NAME'];
        $serverPort = $_SERVER['SERVER_PORT'];

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
            $url = "https://" . $serverName;
            if ($serverPort != 443) $url = $url . ":" . $serverPort;
        } else {
            $url = "http://" . $serverName;
            if ($serverPort != 80) $url = $url . ":" . $serverPort;
        }

        $url = $url . $_SERVER['REQUEST_URI'];

//        $queryString = $_SERVER["QUERY_STRING"];
//        if (isset($queryString)) {
//            $url = $url . '?' + $queryString;
//        }

        return $url;
    }

    public function getRemoteAddr() {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        return $ipAddress;
    }

    protected function onUserSigned(\App\Common\Models\User $user) {
        $user->signinErrors = 0;
        $user->signinExpire = null;

        if ($user->role > 0) {
            $user->signinTimePrev = $user->signinTime;
            $user->signinAddrPrev = $user->signinAddr;

            $user->signinTime = date("Y-m-d H:i:s");
            $user->signinAddr = $this->getRemoteAddr();
            $user->signinCount++;
        }

        $user->setDynamicUpdate(true);
        $user->setValidation(false);
        $user->update();

        $authed = new Authentication($user->id);

        //TODO passwordState = 0 ??
        $authed->username = $user->username;
        $authed->truename = $user->truename;
        $authed->phone    = $user->phone;
        $authed->role     = $user->role;
        $authed->roles    = $user->getAllRoles();

        session_regenerate_id();

        $this->session->set($this->config->auth->session_key, $authed);

        $this->__authentication = $authed;
    }

    public function hashPassword($password) {
        return md5($password);
    }

    public function signinFromForm($username, $password, $remember = false) {
        $user = User::findByUsername($username);

        //判断用户是否可登录
        if (! $user) return array( "errcode" => Auth::ERR_USER_NOT_FOUND, "errmsg" => Auth::MSG_USER_NOT_FOUND);
        if ($user->state == User::STATE_DISABLED) return array( "errcode" => Auth::ERR_USER_DISABLED, "errmsg" => Auth::MSG_USER_NOT_FOUND);
        if ($user->state == User::STATE_DELETED) return array( "errcode" => Auth::ERR_USER_DELETED, "errmsg" => Auth::MSG_USER_NOT_FOUND);

        //之前密码错误次数已经超过 5 次
        if ($user->signinErrors > 4) {
            if (time() < strtotime($user->signinExpire)) {
                //当前时间小于锁定的过期时间
                return array( "errcode" => Auth::ERR_USER_LOCKED, "errmsg" => Auth::MSG_USER_LOCKED);
            } else {
                //当前时间已经超过过期时间，可以解锁并重新登录
                $user->unlock();
            }
        }

        if ($user->password != $this->hashPassword($password)) {
            if ($user->incPasswordError(5)) {
                $errmsg = Auth::MSG_USER_LOCKED;
            } else {
                $errmsg = "密码错误，还有" . (5 - $user->signinErrors) . "次机会";
            }
            return array( "errcode" => Auth::ERR_PASSWORD_ERROR, "errmsg" => $errmsg);
        }

        $this->onUserSigned($user);

        return array("errcode" => Auth::ERR_NONE);
    }

    public function signout() {
        $authed = $this->getAuthentication();
        if ($authed->isGuest()) return;

        $this->session->destroy();
        $this->__authentication = null;
    }
}