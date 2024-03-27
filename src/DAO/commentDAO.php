<?php

namespace App\src\DAO;

use App\src\model\comment;

class commentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new comment();
        $comment->setId($row['id']);
        $comment->setPseudo($row['pseudo']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['createdAt']);
        $comment->setArticle_id($row['article_id']);
        return $comment;
    }

    public function getComments($articleId)
    {
        $sql = 'SELECT id, pseudo, content, createdAt, article_id FROM comment 
        WHERE article_id = ?';
        $result = $this->createQuery($sql, [$articleId]);
        $comments = [];
        while ($row = $result->fetch()) {
            $comments[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }


    public function addComment($articleId, $pseudo, $content)
    {
        $sql = 'INSERT INTO comment (pseudo, content, createdAt, article_id) VALUES (?, ?, NOW(), ?)';
        $this->createQuery($sql, [$pseudo, $content, $articleId]);
    }
}