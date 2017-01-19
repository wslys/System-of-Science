<?php

defined('ROOT_PATH') || define('ROOT_PATH', realpath('..'));

function configuration() {
    $app = array (
        'debug'     => true,
        'id'        => 'console',
        'name'      => '某管理系统',
        'version'   => '1.0',
        'timezone'  => 'Asia/Shanghai',
        'respath'   => '/res',
        'libpath'   => '/lib',
        'admin'     => 'julian.zhao@qq.com',
        'pagesize'  => 2,
        'password'  => '1234'
    );

    $order = array (
        'maxCycles' => 48,
        'maxSheets' => 30
    );

    $db = array(
        'debug'     => true,
        'host'      => '127.0.0.1',
        'username'  => 'root',
        'password'  => '1234',
        'dbname'    => 'huayun',
        'charset'   => 'utf8',
    );

    $classpath = array (
        'App\Common\Controllers' => ROOT_PATH . '/app/common/controllers',
        'App\Common\Models'      => ROOT_PATH . '/app/common/models',
        'App\Common\Plugins'     => ROOT_PATH . '/app/common/plugins',
        'App\Common\Library'     => ROOT_PATH . '/app/common/library',
        'App\Common\Services'    => ROOT_PATH . '/app/common/services',
        'App\Home'               => ROOT_PATH . '/app/home',
        'App\Console'            => ROOT_PATH . '/app/console',
    );

    $modules = array (
        'home'      => array (
            'prefix'    => "/",
            'className' => 'App\Home\Module',
            'path'      => ROOT_PATH . '/app/home/Module.php',
            'router'    => array (
                'className' => 'App\Home\ModuleRouter',
            )
        ),
        'console'   => array (
            'prefix'    => "/console",
            'className' => 'App\Console\Module',
            'path'      => ROOT_PATH . '/app/console/Module.php',
            'router'    => array (
                'className' => 'App\Console\ModuleRouter',
                //'path'      => ROOT_PATH . '/app/console/ModuleRouter.php',
            )
        )
    );

    $auth = array (
        'hash_method'   => 'sha256',
        'hash_key'      => '6fa15e39b539a83cf57c0703a0440f6a',
        'session_key'   => 'AUTHED',
    );

    $logger = array (
        'path'      => ROOT_PATH . '/logs'
    );

    $cache = array (
        'path'      => ROOT_PATH . '/cache/',
        'lifetime'  => 7200,  //  2 hours
        //'lifetime'  => 86400, // 24 hours
    );

    $captcha = array (
        'fonts'     => ROOT_PATH . ''
    );

    $crypt = array (
        'key'       => '774c8ae6cd3c4ab705a9d01e7365920c',
    );

    $result =  array (
        'app'       => $app,
        'db'        => $db,
        'order'     => $order,
        'classpath' => $classpath,
        'modules'   => $modules,
        'auth'      => $auth,
        'logger'    => $logger,
        'cache'     => $cache,
        'captcha'   => $captcha,
        'crypt'     => $crypt
    );

    return new \Phalcon\Config($result);
}


return configuration();