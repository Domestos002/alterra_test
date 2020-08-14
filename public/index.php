<?php

use \Core\Router;

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require_once __DIR__ . './../vendor/autoload.php';


/**
 * Autoloader
 */
spl_autoload_register(function($class) {
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if(is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('api/{table}/{action}', ['controller' => 'Api']);
$router->add('api/{table}/{action}/{id:\d+}', ['controller' => 'Api']);

/*$match = $router->match($_SERVER['QUERY_STRING']);
var_dump($router->params);die;*/

$router->dispatch($_SERVER['QUERY_STRING']);
