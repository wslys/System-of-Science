<?php
namespace App\Home;

use Phalcon\Mvc\Router\Group as RouterGroup;

class ModuleRouter extends RouterGroup {

    public function __construct($paths = null) {
        parent::__construct($paths);
    }

    /**
     * initialize 由父类构造函数调用
     */
    public function initialize()
    {
        // setPaths 必须在所有 add 之前调用，目前由 Application 通过构造函数调用
        //$this->setPaths(array('module'    => 'home' ));

        $this->add('/:controller/:action/:params', array(
            'controller'    => 1,
            'action'        => 2,
            'params'        => 3,
        ));

        $this->add('/:controller', array(
            'controller'    => 1
        ));

//
//        $this->add('/:controller/:int', array(
//            'controller'    => 1,
//            'action'        => 'object',
//            'id'            => 2
//        ));
//
//        $this->add('/:controller/:int/:action', array(
//            'controller'    => 1,
//            'action'        => 3,
//            'id'            => 2
//        ));

        $this->add('/');
    }
}