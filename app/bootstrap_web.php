<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    (new Phalcon\Debug)->listen();
    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include general services
     */
    require APP_PATH . '/config/services.php';

    /**
     * Include web environment specific services
     */
    require APP_PATH . '/config/services_web.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new Application($di);

    /**
     * Register application modules
     */
    $application->registerModules([
        'frontend' => ['className' => 'Fluxflow\Modules\Frontend\Module'],
        'api' => ['className' => 'Fluxflow\Modules\Api\Module'],
        'ff' => ['className' => 'Fluxflow\Modules\Ff\Module'],
    ]);

    /**
     * Include routes
     */
    //$route_start_time = microtime(TRUE);
    require APP_PATH . '/config/routes.php';
    //$route_end_time = microtime(TRUE);
    //var_dump($route_end_time - $route_start_time);die;
    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
