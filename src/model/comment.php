<?php

namespace App\src\model;

use DateTime;

class comment
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $pseudo;
    /**
     * @var string
     */
    private $content;
    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var int
     */
    private $article_id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function getArticle_id()
    {
        return $this->article_id;
    }

    /**
     * @param int $article_id
     */

    public function setArticle_id($article_id)
    {
        $this->article_id = $article_id;
    }

    private $comments = array();

    public function getComments() {
        return $this->comments;
    }

    public function addComment($comment) {
        $this->comments[] = $comment;
    }
}