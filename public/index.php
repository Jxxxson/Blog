<?php

use App\config\Router;

require '../vendor/autoload.php';
require '../config/dev.php';
require_once ('../config/security_headers.php');

$router = new Router();
$router->run();
