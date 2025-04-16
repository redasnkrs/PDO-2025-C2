<?php

// création d'une fonction qui va récupérer tous nos messages
function getAllMessagesOrderByDateDesc(PDO $connection): array
{
    // préparation de la requête
    $prepare = $connection->prepare("
        SELECT * FROM `messages`
        ORDER BY `messages`.`created_at` DESC
        ");
    // essai / erreur
    try{
        // exécution de la requête
        $prepare->execute();

        // on renvoie le tableau (array) indexé contenant tous les résultats (peut être vide si pas de message).
        return $prepare->fetchAll();

    // en cas d'erreur sql
    }catch (Exception $e){
        // erreur de requête SQL
        die($e->getMessage());
    }

}

// création d'une fonction qui insert un message dans
// la table `messages` en bloquant les injections SQL
function addMessage(PDO $con,string $name, string $email, string $text) : bool|string
{
    // erreur vide au cas où
    $erreur = "";
    // protection supplémentaire

    // vérification du nombre de caractères strlen() et validité du nom
    $nameVerify = strip_tags($name); # on retire les tags
    $nameVerify = htmlspecialchars($nameVerify,ENT_QUOTES); // protection des caractères spéciaux, avec guillemet et double-guillemet
    $nameVerify = trim($nameVerify); # on retire les espaces avant/arrière du nom
    // si le nom est vide
    if(empty($nameVerify)){
        $erreur.="Votre nom est incorrect.<br>";
    // si le nom est plus long qu'autorisé en db
    }elseif(strlen($nameVerify)>100){
        $erreur.="Votre nom est trop long.<br>";
    }


    // vérification du mail
    $email = filter_var($email,FILTER_VALIDATE_EMAIL);
    // si le mail n'est pas bon
    if($email===false){
        $erreur .= "Email incorrect.<br>";
    }


    // vérification du nombre de caractères strlen() et validité du message
    $text = trim(htmlspecialchars(strip_tags($text),ENT_QUOTES));
    if(empty($text)||strlen($text)>600){
        $erreur .= "Message incorrect<br>";
    }

    // si on a au moins 1 erreur
    if(!empty($erreur)) return $erreur;

    // pas d'erreur détectée
    $prepare = $con->prepare("
    INSERT INTO `messages` (`name`,`email`,`message`)
    VALUES (?,?,?)
    ");
    try{
        $prepare->execute([$nameVerify,$email,$text]);
        return true;
    }catch(Exception $e){
        die($e->getMessage());
    }

}