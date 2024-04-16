<?php

use App\config\Router;

require '../vendor/autoload.php';
require '../config/dev.php';

$router = new Router();
$router->run();
