<?php

namespace App\src\controller;
class ErrorController
{
    public function errorNotFound()
    {
        require '../templates/Error_404.php';
    }

    public function errorServer()
    {
        require '../templates/Error_500.php';
    }


}