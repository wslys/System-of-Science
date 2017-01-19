<?php
namespace App\Common\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class NotFoundPlugin extends Plugin
{

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 */
	public function beforeException(Event $event, MvcDispatcher $dispatcher, \Exception $exception)
	{
		if ($exception instanceof DispatcherException) {
			switch ($exception->getCode()) {
				case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'error',
                        'action' => 'show404',
                        'params' => array(
                            'from' => 'NotFoundPlugin.beforeException.EXCEPTION_HANDLER_NOT_FOUND',
                            'message' => $exception->getMessage()
                        ),
                    ));
                    return false;
				case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
//                    if ($this->request->isAjax()) {
//                        $this->response->setContent("Not Found");
//                        return false;
//                    }
					$dispatcher->forward(array(
						'controller' => 'error',
						'action' => 'show404',
                        'params' => array(
                            'from' => 'NotFoundPlugin.beforeException.EXCEPTION_ACTION_NOT_FOUND',
                            'message' => $exception->getMessage()
                        ),
					));
					return false;
			}
		}

		$dispatcher->forward(array(
			'controller' => 'error',
			'action'     => 'show500',
            'params' => array(
                'from' => 'NotFoundPlugin.beforeException',
                'exception' => $exception
            ),
		));
		return false;
	}
}
