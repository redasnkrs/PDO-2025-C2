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
<pre>
Affichage du nombre de messages :

Pas de message : Pas encore de message
1 message : Il y a 1 message
Plusieurs messages : Il y a X messages
</pre>
<hr>
<pre>
    Nos messages par date DESC

    NOM
    TEXTE
    DATE
</pre>
<?php
var_dump($_POST);
?>
<hr>
</body>
</html>
