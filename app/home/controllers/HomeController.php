<?php
namespace App\Home\Controllers;

use App\Common\Controllers\BaseController;

class HomeController extends BaseController
{

    public function indexAction() {
        $this->view->setMainView("home");
    }
    
}