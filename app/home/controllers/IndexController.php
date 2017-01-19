<?php
namespace App\Home\Controllers;

use App\Common\Controllers\BaseController;

class IndexController extends BaseController
{

    public function indexAction() {
        $request = $this->request;

        if ($request->isPost()) {
            return $this->response->redirect("home/index");
        }
    }

}