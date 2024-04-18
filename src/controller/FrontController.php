<?php

namespace App\src\controller;

use App\src\DAO\ArticleDAO;
use App\src\DAO\commentDAO;
use App\src\model\View;

//Démarre la session
session_start();

class FrontController
{
    private $articleDAO;

    private $commentDAO;

    private $view;
    private $errorController;

    public function __construct()
    {
        //Initialisation des variables
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
        $this->errorController = new ErrorController();
    }

    public function home()
    {
        $articles = $this->articleDAO->getArticles();
        return $this->view->render('home', ['articles' => $articles]);
    }

    public function article($articleId)
    {
        //Génére un jeton CSRF
        $csrfToken = $this->generateCsrfToken();

        //récupère les info de l'article via l'id de l'article
        $article = $this->articleDAO->getArticle($articleId);
        //Récupère les commentaires associès à un id d'article
        $comments = $this->commentDAO->getComments($articleId);
        //Renvoie la vue associè à la page single.php
        return $this->view->render('single', [
            'article' => $article,
            'comments' => $comments,
            //Jeton CSRF inclus dans le formulaire du commentaire
            'crsfToken' => $csrfToken
        ]);
    }

    // Méthode pour générer un token CSRF
    public function generateCsrfToken()
    {
        // Génère un jeton CSRF aléatoire
        $token = bin2hex(random_bytes(32));

        // Stocke le jeton CSRF dans la session utilisateur
        $_SESSION['csrf_token'] = $token;

        // Retourne le jeton CSRF généré
        return $token;
    }

    // Méthode addComment
    public function addComment($articleId, $pseudo, $content)
    {
        // Vérification des données du formulaire
        if (!$this->validateCommentData($articleId, $pseudo, $content)) {
            $this->errorController->errorNotFound();
            return;
        }

        //Ajout du commentaire
        $this->commentDAO->addComment($articleId, $pseudo, $content) || !$this->validateCsrfToken();
        // Rediriger vers l'article pour voir le commentaire ajouté
        header('Location: index.php?route=article&articleId=' . $articleId);
        exit;
    }


    // Exemple validation à améliorer
    private function validateCommentData($articleId, $pseudo, $content)
    {
        return !empty($pseudo) && !empty($content) && !empty($articleId) && $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function validateCsrfToken()
    {
        // Vérifie si le jeton CSRF est présent dans la requête POST
        if (!empty($_POST['csrf_token'])) {

            // Récupère le jeton stocké dans la session
            $storedCsrfToken = $_SESSION['csrf_token'];

            // Récupère le jeton soumis dans la requête POST
            $submittedCsrfToken = $_POST['csrf_token'];

            // Vérifie que les deux jetons sont identiques
            if ($storedCsrfToken === $submittedCsrfToken) {

                // Les jetons sont identiques
                return true;

            } else {
                // Les jetons sont différents, renvoyer une erreur
                return false;
            }
        } else {
            // Le jeton CSRF est manquant dans la requête POST
            // Cela peut indiquer une tentative d'attaque CSRF
            return false;
        }
    }


}
