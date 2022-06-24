<?php

error_reporting(E_ALL);

use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Url;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('BASE_URL', 'http://localhost:8080');
require_once(BASE_PATH . '/vendor/autoload.php');


class Application extends BaseApplication
{
    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    protected function registerServices()
    {

        $di = new FactoryDefault();

        // Registering mongo database services
        $di->set(
            'mongo',
            function () {
                $mongo = new \MongoDB\Client("mongodb://mongo", array("username" => 'root', "password" => "password123"));

                return $mongo->store2;
            },
            true
        );

        //registering url
        $di->set(
            'url',
            function () {
                $url = new Url();
                $url->setBaseUri('/');
                return $url;
            }
        );

        //setting up session
        $di->set(
            'session',
            function () {
                $session = new Manager();
                $files = new Stream(
                    [
                        'savePath' => '/tmp',
                    ]
                );
                $session
                    ->setAdapter($files)
                    ->start();

                return $session;
            }
        );

        $loader = new Loader();

        /**
         * We're a registering a set of directories taken from the configuration file
         */
        $loader
            ->registerDirs([__DIR__ . '/../app/library/'])
            ->registerNamespaces(
                [
                    'App\Components' => APP_PATH . '/component'
                ]
            )
            ->register();

        // Registering a router
        $di->set('router', function () {

            $router = new Router();

            $router->setDefaultModule("frontend");

            $router->add('/products/:action', [
                'module'     => 'frontend',
                'controller' => 'products',
                'action'     => 1,
            ])->setName('frontend');

            $router->add("/public/login", [
                'module'     => 'admin',
                'controller' => 'login',
                'action'     => 'index',
            ])->setName('admin-login');

            $router->add("/admin/products/:action/:params", [
                'module'     => 'admin',
                'controller' => 'products',
                'action'     => 1,
                'params'     => 2
            ])->setName('admin-product');

            $router->add("/admin", [
                'module'     => 'admin',
                'controller' => 'login',
                'action'     => 'index',
            ]);

            $router->add("/admin/signup/:action", [
                'module'     => 'admin',
                'controller' => 'signup',
                'action'     => 1,
            ])->setName('admin-signup');


            return $router;
        });

        $this->setDI($di);
    }

    public function main()
    {

        $this->registerServices();

        // Register the installed modules
        $this->registerModules([
            'frontend' => [
                'className' => 'Multiple\Frontend\Module',
                'path'      => '../app/frontend/Module.php'
            ],
            'admin'  => [
                'className' => 'Multiple\Admin\Module',
                'path'      => '../app/admin/Module.php'
            ]
        ]);

        $response = $this->handle($_SERVER['REQUEST_URI']);

        $response->send();
    }
}

$application = new Application();
$application->main();
