<?php

error_reporting(E_ALL);

define('ROOT_PATH', realpath('..'));

try {
    $config = include ROOT_PATH . "/config/config.php";

    require_once ROOT_PATH . "/app/Application.php";

    $app = new \App\Application($config);

    echo $app->run();

} catch (\Exception $ex) {
    \App\Common\Services\Logger::handleException($ex);
}