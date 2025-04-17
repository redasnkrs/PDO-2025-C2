<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Exercice</title>
</head>
<body>
<h1>Exercice</h1>
<h2>Laissez-nous un message</h2>
<?php
// si on a inséré un article
if(isset($thanks)):
?>
<h3 class="thanks"><?=$thanks?></h3>
<?php

elseif(isset($error)):
?>
    <h4 class="error"><?=$error?></h4>
<?php
endif;
?>
<form action="" method="post">
    <label for="name">Nom</label>
    <input type="text" name="surname" id="name" required>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
    <label for="message">Message</label>
    <textarea name="message" id="message" rows="10" required></textarea>
    <button type="submit">Envoyer</button>
</form>
<hr>
<?php
// articles est un tableau vide
if(empty($articles)):
?>
<div class="nomessage">
<h3>Pas encore d'article</h3>
    <?php
// nous avons au moins un article
else:
    // on peut compter le nombre d'articles
    $countArticle = count($articles);
    // ternaire pour ajouter un s à article
    // si on en a plus d'un
    $pluriel = $countArticle>1? "s" : "";
    ?>
<div class="messages">
<h3>Nous avons <?=$countArticle?> article<?=$pluriel?></h3>
<hr>

    <?php
    // tant qu'on a des articles
    foreach($articles as $article):
    ?>
<h4><?=$article['surname']?></h4>
        <p><?=nl2br($article['message']);// retour à la ligne automatique?></p>
        <h5><?=$article['create_date']?></h5><hr>
<?php
    endforeach;
endif;
?>
</div>
<?php
#var_dump($_POST,$articles,$countArticle);
?>
<hr>
</body>
</html>
