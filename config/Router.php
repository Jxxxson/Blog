<?php

namespace App\config;

use App\src\controller\FrontController;
use App\src\controller\ErrorController;
use Exception;

class Router
{
    private $frontController;
    private $errorController;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
    }

    public function run()
    {
        try {
            if (isset($_GET['route'])) { // Vérifie si une route est spécifiée dans l'URL

                if ($_GET['route'] === 'article') { // Si la route est 'article'

                    if (isset($_GET['articleId'])) { // Vérifie si articleId est défini dans l'URL
                        $this->frontController->article($_GET['articleId']); // Exécute la méthode 'article' du contrôleur frontal avec l'identifiant de l'article en paramètre

                    } else {
                        $this->errorController->errorNotFound(); // Affiche une erreur 404 si articleId n'est pas défini
                    }

                } else {
                    $this->errorController->errorNotFound(); // Affiche une erreur 404 si la route n'est pas 'article'
                }

                // Pour addComment
                if ($_GET['route'] === 'addComment') { // Si la route est 'addComment'

                    if (!empty($_POST['pseudo']) && !empty($_POST['content'])) { // Vérifie si les champs pseudo et content sont remplis dans le formulaire

                        $this->frontController->addComment($_GET['articleId'], $_POST['pseudo'], $_POST['content']); // Exécute la méthode 'addComment' du contrôleur frontal avec les données du formulaire en paramètres

                    }

                }
            } else {
                $this->frontController->home(); // Si aucune route n'est spécifiée, affiche la page d'accueil en exécutant la méthode 'home' du contrôleur frontal
            }

        } catch (Exception $e) {
            $this->errorController->errorServer(); // En cas d'exception, affiche une erreur 500 en exécutant la méthode 'errorServer' du contrôleur d'erreur
        }
    }
}
