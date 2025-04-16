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
// si on a bien envoyé un message
if(isset($thanks)):
?>
    <h4 class="thanks"><?=$thanks?></h4>
<?php
endif;
// si on a une erreur lors de l'insertion
if(isset($error)):
?>
<h4 class="error"><?=$error?></h4>
<?php
    endif; ?>
<form action="" method="post">
    <label for="name">Nom</label>
    <input type="text" name="name" id="name" required>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
    <label for="message">Message</label>
    <textarea name="message" id="message" rows="10" required></textarea>
    <button type="submit">Envoyer</button>
</form>
<hr>

<?php
// si on a pas de message (tableau vide)
if(empty($messages)):
?>

<div class="nomessage">
    <h2>Pas de message</h2>
    <p>Veuillez consulter cette page plus tard</p>
</div>
<?php
// le tableau n'est pas vide
else:
    // on compte les messages
    $nbMessage = count($messages);
    // on va ajouter une variable pour le 's' de message
    // si nécessaire pour le h2 suivant
    $pluriel = $nbMessage>1 ? "s" : "";
?>

<div class="messages">
    <h2>Il y a <?=$nbMessage?> message<?=$pluriel?></h2>
    <?php
    // tant qu'on a des messages
    foreach ($messages as $message):
    ?>
    <h3><?=$message['surname']?></h3>
    <p><?=$message['message']?></p>
    <p><?=$message['create_date']?></p>
    <hr>
    <?php
    endforeach;
    ?>

</div>
<hr>
<?php
// fin du if
endif;
var_dump($db, $_POST);
?>


</body>
</html>
