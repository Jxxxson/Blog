<?php

namespace App\src\controller;

use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
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
        $this->articleDAO = new ArticleDAO(); // Instancie un objet ArticleDAO pour interagir avec la base de données des articles
        $this->commentDAO = new CommentDAO(); // Instancie un objet CommentDAO pour interagir avec la base de données des commentaires
        $this->view = new View(); // Instancie un objet View pour la gestion des vues
        $this->errorController = new ErrorController(); // Instancie un objet ErrorController pour la gestion des erreurs
    }

    // Méthode pour afficher la page d'accueil avec la liste des articles
    public function home()
    {
        $articles = $this->articleDAO->getArticles(); // Récupère la liste des articles depuis la base de données
        return $this->view->render('home', ['articles' => $articles]); // Affiche la vue 'home' avec les données des articles
    }

    // Méthode pour afficher un article et ses commentaires
    public function article($articleId)
    {
        // Génère un jeton CSRF
        $csrfToken = $this->generateCsrfToken();

        // Récupère les informations de l'article via son identifiant
        $article = $this->articleDAO->getArticle($articleId);
        // Récupère les commentaires associés à l'article
        $comments = $this->commentDAO->getComments($articleId);
        // Affiche la vue 'single' avec les données de l'article, les commentaires et le jeton CSRF
        return $this->view->render('single', [
            'article' => $article,
            'comments' => $comments,
            'csrfToken' => $csrfToken // Jeton CSRF inclus dans le formulaire de commentaire
        ]);
    }

    // Méthode pour générer un jeton CSRF
    public function generateCsrfToken()
    {
        // Génère un jeton CSRF aléatoire
        $token = bin2hex(random_bytes(32));

        // Stocke le jeton CSRF dans la session utilisateur
        $_SESSION['csrf_token'] = $token;

        // Retourne le jeton CSRF généré
        return $token;
    }

    // Méthode pour ajouter un commentaire à un article
    public function addComment($articleId, $pseudo, $content)
    {
        // Vérifie les données du formulaire de commentaire
        if (!$this->validateCommentData($articleId, $pseudo, $content)) {
            $this->errorController->errorNotFound(); // Affiche une erreur 404 si les données du formulaire sont invalides
            return;
        }

        // Ajoute le commentaire à la base de données
        $this->commentDAO->addComment($articleId, $pseudo, $content) || !$this->validateCsrfToken();
        // Redirige vers l'article pour voir le commentaire ajouté
        header('Location: index.php?route=article&articleId=' . $articleId);
        exit;
    }

    // Méthode de validation des données du formulaire de commentaire
    private function validateCommentData($articleId, $pseudo, $content)
    {
        return !empty($pseudo) && !empty($content) && !empty($articleId) && $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Méthode de validation du jeton CSRF
    public function validateCsrfToken()
    {
        // Vérifie si le jeton CSRF est présent dans la requête POST
        if (!empty($_POST['csrfToken'])) {

            // Récupère le jeton stocké dans la session
            $storedCsrfToken = $_SESSION['csrf_token'];

            // Récupère le jeton soumis dans la requête POST
            $submittedCsrfToken = $_POST['csrfToken'];

            // Vérifie que les deux jetons sont identiques
            if ($storedCsrfToken === $submittedCsrfToken) {
                // Les jetons sont identiques
                return true;
            } else {
                // Les jetons sont différents, renvoie une erreur
                return false;
            }
        } else {
            // Le jeton CSRF est manquant dans la requête POST, ce qui peut indiquer une tentative d'attaque CSRF
            return false;
        }
    }
}
