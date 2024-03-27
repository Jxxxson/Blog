<?php $this->title = "Article"; ?>
<h1>Mon blog</h1>
<p>Terminé</p>
<div>
    <h2><?= htmlspecialchars($article->getTitle()); ?></h2>
    <p><?= htmlspecialchars($article->getContent()); ?></p>
    <p><?= htmlspecialchars($article->getAuthor()); ?></p>
    <p>Créé le : <?= htmlspecialchars($article->getCreatedAt()); ?></p>

    <div>

        <h3>Commentaires</h3>
        <?php foreach ($comments as $comment): ?>
            <p>
                Pseudo : <?= htmlspecialchars($comment->getPseudo()); ?><br>
                Contenu : <?= htmlspecialchars($comment->getContent()); ?><br>
                Date : <?= htmlspecialchars($comment->getCreatedAt()); ?><br>
            </p>
        <?php endforeach; ?>

    </div>

    <div>

        <h3>Ajouter un commentaire</h3>

        <form action="../public/index.php?route=addComment&articleId=<?= $article->getId() ?>" method="post">

        <label for="Pseudo"> Pseudo : </label><br>
            <input  id="Pseudo" type="text" name="pseudo" required/><br><br>


            <label for="comment"> Commentaire : </label><br>
            <textarea id="comment" name="content" rows="4" aria-required="true"></textarea><br><br>

            <input type="submit" value="Ajouter le commentaire"/>

        </form>
    </div>
</div>
<br>
<a href="../public/index.php">Retour à l'accueil</a>