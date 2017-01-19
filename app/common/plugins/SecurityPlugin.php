<?php
namespace App\Common\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{

    //public function beforeDispatch(Event $event, Dispatcher $dispatcher)

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        return true;
//        return $this->auth->decide($dispatcher);
    }


}
