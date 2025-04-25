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
function addMessage(PDO $con,string $name, string $email, string $telephone, string $text) : bool
{

    // protection supplémentaire
    $name = trim(htmlspecialchars(strip_tags($name),ENT_QUOTES));
    $text = trim(htmlspecialchars(strip_tags($text),ENT_QUOTES));
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $telephone = trim(htmlspecialchars(strip_tags($telephone),ENT_QUOTES));

    if(
        empty($name) || strlen($name) > 100 ||
        empty($text) || strlen($text) > 600 ||
        $email === false || strlen($email) > 120 ||
        empty($telephone) || strlen($telephone) > 10 || ctype_digit($telephone) === false
    ){
        return false;
    }

    // pas d'erreur détectée
    $prepare = $con->prepare("
    INSERT INTO `messages` (`name`,`email`,`message`,`telephone`)
    VALUES (?,?,?,?)
    ");
    try{
        $prepare->execute([$name,$email,$text,$telephone]);
        return true;
    }catch(Exception $e){
        die($e->getMessage());
    }

}

// fonction qui prend le nombre total de `messages`

// fonction qui ne prend que les articles visibles sur cette page

// création d'une fonction qui créer la pagination

