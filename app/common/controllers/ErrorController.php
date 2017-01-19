<?php
namespace App\Common\Controllers;


class ErrorController extends BaseController
{

    public function indexAction() {

    }

    public function show401Action($module, $controller, $action) {
        $this->response->setStatusCode(401, "Unauthorized");
        if ($this->request->isAjax()) {
            $this->view->disable();
            echo "Unauthorized";
            return;
        }

        $this->view->setViewsDir(ROOT_PATH . '/app/common/views/');
        $this->view->setMainView('/errors/show401');
        $this->view->setVar("module", $module);
        $this->view->setVar("controller", $controller);
        $this->view->setVar("action", $action);
    }

    public function show404Action()
    {
        $this->response->setStatusCode(404, "Not Found");

        if ($this->request->isAjax()) {
            $this->view->disable();
            echo "Not found";
            return;
        }

        $this->view->setVar("from", $this->dispatcher->getParam('from'));
        $this->view->setVar("message", $this->dispatcher->getParam('message'));
        $this->view->setViewsDir(ROOT_PATH . '/app/common/views/');
        $this->view->setMainView('/errors/show404');
    }


    public function show500Action()
    {
        $from = $this->dispatcher->getParam('from');
        $this->view->setVar("from", $from);
        $ex = $this->dispatcher->getParam("exception");
        $this->view->setVar("params", $ex);

        $this->response->setStatusCode(500, "Server exception");

        $this->view->setViewsDir(ROOT_PATH . '/app/common/views/');
        $this->view->setMainView('/errors/show500');
    }
}

