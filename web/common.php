<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once __DIR__ . '/../Controller/RouteController.php';

// Create Router instance
$router = new \Bramus\Router\Router();
$routeController = new \Controller\RouteController($router);
$routeController->matchRoute();

$router->run();
