<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/core/Router.php';
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Helpers.php';
require_once BASE_PATH . '/core/Render.php';

$router = new Router();
$db = new Database();
$render = new Render();

require BASE_PATH . '/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = getRequestPath();

$router->resolve($method, $path);