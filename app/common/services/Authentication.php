<?php
namespace App\Common\Services;


class Authentication {

    const GUEST_ID = -1000;

    public $userId = self::GUEST_ID;

    public $username = "";

    public $truename = "Guest";

    public $role; // 0 - 超级管理员 -1 - 开发管理员

    public $roles;

    public $phone;

    public $xtime;

    public $xcode;

    public function __construct($userId) {
        $this->userId = $userId;
        $this->xtime = time();
        $this->xcode = $this->getXCode($this->xtime);
    }

    public function isGuest() {
        return $this->userId == self::GUEST_ID;
    }

    private function getXCode($time) {
        return sha1("X%J^J({$this->userId}{$time}X@J!J)");
    }

    public function checkXCode($time, $code) {
        return $this->getXCode($time) == $code;
    }

    public static function newGuest() {
        $res = new Authentication(self::GUEST_ID);
        $res->roles = array('ROLE_GUEST');
        return $res;
    }


}