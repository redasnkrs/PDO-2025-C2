<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Accueil | laissez-nous un message</title>
</head>
<body>
<h1>Accueil</h1>
<h2>Laissez-nous un message</h2>
<?php
$error = "";
$thanks ="";
if(isset($insert)){
    if($insert===true) {
        $thanks = "Message bien envoyé";
    }elseif($insert===false){
        $error =" Pas inséré côté serveur";
    }
}

?>
<h3 class="merci"><?=$thanks?></h3>
<h3 class="erreur"><?=$error?></h3>

<form action="" method="post">
    <label for="name">Nom</label>
    <input type="text" name="name" id="name">
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    <label for="telephone">Telephone</label>
    <input type="text" name="telephone" id="telephone">
    <label for="message">Messages</label>
    <textarea name="message" id="message" rows="10"></textarea>
    <button type="submit">Envoyer</button>
</form>

<?php
// si on a pas de message (tableau vide)
if(empty($messages)):
?>

<div class="nomessage">
    <h2>Pas de message</h2>
    <p>Veuillez consulter cette page plus tard</p>
</div>
<?php
else:
// le tableau n'est pas vide


    // on compte le nombre de message
    $countMessage = count($messages) ;
    // on va ajouter une variable pour le 's' de message
    $pluriel = $countMessage>1? "s" : "";
?>

<div class="messages">
    <h2>Il y a <?=$countMessage?> message<?=$pluriel?></h2>
    <?php
    // ici affichage de la pagination
    // tant qu'on a des messages
    foreach ($messages as $message):

    ?>
    <h4>Ecrit par <?=$message['name']?> le <?=$message['created_at']?></h4>
    <p><?=$message['message']?></p>
    <hr>
    <?php
    endforeach;

    ?>

</div>
<?php
// fin du if
endif;
// ici affichage de la pagination

var_dump($db,
        $_POST,
        $thanks,
        $error,
        $messages,

);
?>
</body>
</html>
