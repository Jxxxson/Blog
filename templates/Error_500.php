<?php
class Error_404
{
    public function display()
    {
        header("HTTP/1.0 500 Serveur problem");
        echo "<h1>Problème serveur</h1>";
    }
}