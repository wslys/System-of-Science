<?php

namespace App\Common\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\PresenceOf;

class Product extends Model {

    public $id;

    public $name;

    public $des;

    public function getSource() {
        return 'product';
    }

    public function initialize() {
        $this->setup(array('notNullValidations'=>false));
        $this->useDynamicUpdate( true );
    }

//    // 在创建验证之前执行
//    public function beforeValidationOnCreate() {
//        $this->createTime = date('Y-m-d H:i:s');
//    }

    public function validation() {
        if ($this->validationDisabled()) return true;

        $this->validate(new PresenceOf(array(
            "field" => 'name',
            "message" => '商品名称不能为空'
        )));

        return $this->validationHasFailed() != true;
    }

}