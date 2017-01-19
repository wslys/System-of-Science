<?php
namespace App\Home;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Dispatcher as MvcDispather;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View;

use App\Common\Plugins\SecurityPlugin;
use App\Common\Plugins\NotFoundPlugin;

class Module implements ModuleDefinitionInterface {

    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'App\Home\Controllers' => __DIR__ . '/controllers',
        ));
        $loader->register();
    }

    public function registerServices(DiInterface $di) {

        $di->setShared('dispatcher', function() use($di) {
            $eventsManager = new EventsManager();

            $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin());

            $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin());

            $dispatcher = new MvcDispather();
            $dispatcher->setEventsManager($eventsManager);

            $dispatcher->setDefaultNamespace("App\Home\Controllers");

            return $dispatcher;
        });

        $di->setShared('view', function() use($di) {
            $view = new View();

            $view->setViewsDir(__DIR__ . '/views/');

            $view->registerEngines($di->getShared('app')->getViewEngines($view, $di));

            return $view;
        });
    }
}