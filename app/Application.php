<?php
namespace App;

use App\Common\Services\AccessDecisionManager;

class Application {

    private $di;

    private $config;

    public function __construct(\Phalcon\Config $config) {
        $this->config = $config;
        $this->di = new \Phalcon\Di\FactoryDefault();
        $this->di->setShared('config', $config);
        date_default_timezone_set($config->app->timezone);
    }

    public function run($uri = null) {
        $this->initLoader();
        $this->initServices();

        $app = new \Phalcon\Mvc\Application($this->di);

        $this->di->setShared('app', $this);

        $app->registerModules($this->config->modules->toArray());


        return $app->handle($uri)->getContent();
    }

    // 初始化程序加载
    protected function initLoader() {
        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces($this->config->classpath->toArray());

        $loader->register();
    }

    // 初始化路由
    protected function initRouter() {
        $config = $this->config;

        $this->di->setShared('router', function() use ($config) {
            $router = new \Phalcon\Mvc\Router(false);
            $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
            $router->removeExtraSlashes(true);

            $router->setDefaults(array(
                'controller' => 'index',
                'action' => 'index'
            ));

            $modules = $config->modules;
            foreach ($modules as $moduleName => $module) {
                $group = new $module->router->className(array('module' => $moduleName));
                if ($module->prefix != "/") {
                    $group->setPrefix($module->prefix);
                } else {
                    $router->setDefaultModule($moduleName);
                }
                $router->mount($group);
            }

            $router->notFound(array (
                'controller'    => 'error',
                'action'        => 'show404',
                'from'          => 'router.notFound',
            ));

            return $router;
        });
    }

    // 初始化服务
    protected function initServices() {
        $this->initLogger();

        //$this->initCrypt();

        //$this->initFlash();

        //$this->initFilter();

        $this->initModelsMetadata();

        $this->initCache();

        $this->initSession();

        //$this->initCookies();

        $this->initRouter();

        $this->initDatabase();

        $this->initCustomServices();
    }

    // 初始化定制服务
    protected function initCustomServices() {
        $config = $this->config;
        $this->di->setShared('auth', function() use ($config) {
            return new \App\Common\Services\Auth();
        });

        $this->di->setShared("accessManager", function() {
            return new AccessDecisionManager();
        });
    }

    // 模块初始化
    protected function initModelsMetadata() {
        $config = $this->config;

        if ($config->app->debug) return;

        $this->di['modelsMetadata'] = function () use ($config) {

            $metaData = new \Phalcon\Mvc\Model\Metadata\Redis(array(
                'prefix' => $config->app->id,
                'lifetime' => 86400,
                'host' => 'localhost',
                'port' => 6379,
                'persistent' => false
            ));

            return $metaData;
        };
    }

    // 初始化高速缓存( Redis )
    protected function initCache() {
        $config = $this->config;
        $this->di['cache'] = function () use ($config) {
            $froneData = new \Phalcon\Cache\Frontend\Data(array (
                'lifetime' => 86400
            ));

            $backEndOptions = array (
                'prefix'    => $config->app->id,
                'host'      => 'localhost',
                'port'      => 6379,
                //'auth'      => '',
                'persistent'=> false,
                'index'     => 0
            );
            $cache = new \Phalcon\Cache\Backend\Redis($froneData, $backEndOptions);

            return $cache;
        };
    }

    // 初始化session
    protected function initSession() {
        $config = $this->config;
        $this->di->setShared('session', function() use ($config) {
            if (!$config->app->debug) session_set_cookie_params('1200');
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });
    }

    protected function initLogger() {
        $config = $this->config;

        $this->di->setShared('logger', function() use($config) {
            $logger = new \Phalcon\Logger\Adapter\File($config->logger->path . '/' . date('Ymd') . '.log',
                array('mode' => 'a+'));
            return new \App\Common\Services\Logger($logger);
        });
    }

    // 初始化数据库
    protected function initDatabase() {
        $config = $this->config;
        $this->di->setShared('db', function() use($config) {
            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                'host'      => $config->db->host,
                'username'  => $config->db->username,
                'password'  => $config->db->password,
                'dbname'    => $config->db->dbname,
                'charset'   => $config->db->charset,
            ));

            if ($config->db->debug) {
                $eventManager = new \Phalcon\Events\Manager();
                $logger = new \Phalcon\Logger\Adapter\File($config->logger->path . '/db-' . date('Ymd') . '.log');

                $eventManager->attach('db', function ($event, $connection) use ($logger) {
                    if ($event->getType() == 'beforeQuery') {
                        $sqlVariables = $connection->getSQLVariables();
                        if (count($sqlVariables)) {
                            $logger->log($connection->getSQLStatement() . ' PARAMS:' . join(', ', $sqlVariables), \Phalcon\Logger::INFO);
                        } else {
                            $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
                        }
                    }
                });

                $connection->setEventsManager($eventManager);
            }

            return $connection;
        });
    }


    // 得到的视图引擎
    public function getViewEngines($view, $di) {
        $config = $this->config;

        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

        $voltOptions = array(
            'compileAlways'     => $config->app->debug,
            'compiledPath'      => $config->cache->path,
            'compiledSeparator' => '_',
        );
        $volt->setOptions($voltOptions);

        $compiler = $volt->getCompiler();
        $compiler->addFunction('is_a', 'is_a');
        $compiler->addFunction('number_format', 'number_format');
        $compiler->addFunction('strtotime', 'strtotime');
        $compiler->addFunction("fieldError", function ($resolvedArgs, $exprArgs) {
            return '\App\Common\Services\FormTool::fieldError(' . $resolvedArgs . ')';
        });

        return array(
            '.volt'     => $volt,
            '.phtml'    => 'Phalcon\Mvc\View\Engine\Php',
            //'.md'       => 'App\Common\Extension\Markdown',
        );
    }
}