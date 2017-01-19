<?php
namespace App\Console\Controllers;

use App\Common\Controllers\BaseController;
use App\Common\Models\Notice;
use App\Common\Models\Product;

class IndexController extends BaseController
{

    public function initialize() {
        parent::initialize();

    }

    public function indexAction() {
        
    }

    public function testAction($prs) {
        return $this->toJson2(array(1,2,3,4,$prs));
    }


}