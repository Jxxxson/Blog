<?php
/**
 * Created by PhpStorm.
 * User: Mireille
 * Date: 25/04/2021
 * Time: 19:15
 */

use App\config\Router;

require '../vendor/autoload.php';
require '../config/dev.php';

$router = new Router();
$router->run();
