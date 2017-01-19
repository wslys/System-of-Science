<?php
namespace App\Common\Services;

use Phalcon\Di;


class Logger extends \Phalcon\Di\Injectable
{

    private $path;

    private $remoteAddr;

    private $_logger = null;

    public function __construct($logger) {
        $this->_logger = $logger;
        $this->remoteAddr = '[' . $_SERVER['REMOTE_ADDR'] . '] ';
    }

    public function debug($message) {
        $logger = $this->_logger;
        $logger->debug($this->remoteAddr . $message);
    }

    public function error($message) {
        $logger = $this->_logger;
        $logger->error($this->remoteAddr . $message);
    }

    public function notice($message) {
        $logger = $this->_logger;
        $logger->notice($this->remoteAddr . $message);
    }

    public function info($message) {
        $logger = $this->_logger;
        $logger->info($this->remoteAddr . $message);
    }

    public static function handleException(\Exception $e) {
        $config = DI::getDefault()->getShared('config');
        $errors = array(
            'error' => get_class($e) . '[' . $e->getCode() . ']: ' . $e->getMessage(),
            'info' => $e->getFile() . '[' . $e->getLine() . ']',
            'debug' => "Trace: \n" . $e->getTraceAsString() . "\n",
        );

        if ($config->app->debug) {
            var_dump($errors);
        } else {
            $di = new \Phalcon\DI\FactoryDefault();
            $view = new \Phalcon\Mvc\View\Simple();
            $view->setDI($di);
            $view->setViewsDir(ROOT_PATH . '/app/common/views/');
            $view->registerEngines($di->getShared('app')->getViewEngines($view, $di));
            echo $view->render('error', array('config' => $config));

            $di->getShared('logger')->error($errors);
        }
    }
}