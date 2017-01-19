<?php
namespace App\Console\Controllers;

use App\Common\Controllers\BaseController;
use App\Common\Models\Notice;
use App\Common\Models\Product;

class AngularController extends BaseController
{

    public function indexAction() {
        $this->view->setMainView('angular');
    }

}