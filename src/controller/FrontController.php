<?php

namespace App\src\controller;

use App\src\DAO\ArticleDAO;
use App\src\DAO\commentDAO;
use App\src\model\View;

class FrontController
{
    private $articleDAO;

    private $commentDAO;

    private $view;

    public function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    }

    public function home()
    {
        $articles = $this->articleDAO->getArticles();
        return $this->view->render('home', [
            'articles' => $articles
        ]);
    }

    public function article($articleId)
    {

        $csrfToken = $this->generateCsrfToken();

        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getComments($articleId);
        return $this->view->render('single', [
            'article' => $article,
            'comments' => $comments,
            'crsfToken' => $csrfToken
        ]);
    }

    // Méthode pour générer un token CSRF
    private function generateCsrfToken()
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
        // Vérifie le token CSRF
        if (!$this->validateCommentData($articleId, $pseudo, $content)) {
            $this->errorController->errorNotFound();
            return;
        }

        $this->commentDAO->addComment($articleId, $pseudo, $content);
        // Rediriger vers l'article pour voir le commentaire ajouté
        header('Location: index.php?route=article&articleId=' . $articleId);
        exit;
    }


//    // Méthode pour valider le token CSRF
//    private function validateCsrfToken()
//    {
//        return isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token'];
//    }

    // Exemple validation à améliorer
    private function validateCommentData($articleId, $pseudo, $content)
    {
        return !empty($pseudo) && !empty($content) && !empty($articleId) && $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
