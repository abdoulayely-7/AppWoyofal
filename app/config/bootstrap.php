<?php
require_once '../vendor/autoload.php';
require_once 'env.php';


use app\config;
use App\Core\App;
use App\Core\Router;

App::run();


$routes = require_once '../route/route.web.php';
//require_once '../route/route.web.php';

Router::resolve($routes);