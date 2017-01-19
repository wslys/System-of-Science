<?php

namespace App\Common\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class BaseController extends Controller
{
    protected $authed;

    // 这个方法会在每一个能找到的action前执行
//    public function beforeExecuteRoute(Dispatcher $dispatcher) {
//        return true;
//    }

    /**
     * initialize 仅仅会在事件 beforeExecuteRoute 成功执行后才会被调用。
     * 这样可以避免在初始化中的应用逻辑不会在未验证的情况下执行不了。
     */
    public function initialize() {
        $app = $this->config->app;
        $view = $this->view;
        $this->tag->setTitle($app->name);
        $view->setVar('respath', $app->respath);
        $view->setVar('libpath', $app->libpath);

        $this->authed = $this->auth->getAuthentication();

        $view->setVar('authed', $this->authed);

        $navText = $this->dispatcher->getControllerName() . "." . $this->dispatcher->getActionName();

        $view->setVar("NAV", strtolower($navText) );
    }

    // 在找到的action执行后
//    public function afterExecuteRoute($dispatcher) {
//
//    }

    protected function curUserId() {
        return $this->auth->getAuthentication()->userId;
    }

    protected function curDateTime() {
        return date("Y-m-d H:i:s");
    }

    protected function showInfo($title, $msg, $links = array()) {
        $this->view->pick("common/info");
        $this->view->setVar("title", $title);
        $this->view->setVar("msg", $msg);
        $this->view->setVar("links", $links);
    }

    protected function showError($msg, $messages = null) {
        $this->view->pick("common/error");
        $this->view->setVar("msg", $msg);
        if ($this->config->app->debug)
            $this->view->setVar("messages", $messages);
    }

    protected function toJson($result) {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        return $this->response->setJsonContent($result, JSON_UNESCAPED_UNICODE);
    }

    protected function toJson2($data, $errcode = 0, $errmsg = "OK") {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $result = array("errcode" => $errcode, "errmsg" => $errmsg);
        if ($data) $result["data"] = $data;
        return $this->response->setJsonContent($result, JSON_UNESCAPED_UNICODE);
    }
}