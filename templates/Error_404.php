<?php
class Error_404
{
    public function display()
    {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Page non trouvée</h1>";
    }
}