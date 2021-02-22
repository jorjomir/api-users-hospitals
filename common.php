<?php

session_start();
spl_autoload_register();

require_once __DIR__ . '/vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();
$routeController = new \Controller\RouteController($router);
$routeController->matchRoute();
$router->run();
