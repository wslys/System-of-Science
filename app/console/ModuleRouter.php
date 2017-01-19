<?php
namespace App\Console;

use Phalcon\Mvc\Router\Group as RouterGroup;

class ModuleRouter extends RouterGroup {

    public function __construct($paths = null) {
        parent::__construct($paths);
    }

    public function initialize()
    {
        $this->setPrefix('/console');

        $this->add('/:controller/:action/:params', array(
            'controller'    => 1,
            'action'        => 2,
            'params'        => 3,
        ));

        $this->add('/:controller', array(
            'controller'    => 1
        ));

        $this->add('/:controller/:int', array(
            'controller'    => 1,
            'action'        => 'select',
            'id'            => 2
        ));

        $this->add('/:controller/:int/:action', array(
            'controller'    => 1,
            'action'        => 3,
            'id'            => 2
        ));



        $this->add('[/]?', array());
    }
}