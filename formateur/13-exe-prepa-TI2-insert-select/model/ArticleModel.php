<?php
# fonctions en lien avec la table article

// récupération de tous nos articles par create_date DESC
function getAllArticlesOrderByDateDesc(PDO $connection): array
{
    // préparation de la requête
    $prepare = $connection->prepare("
        SELECT * FROM `article`
        ORDER BY `article`.`create_date` DESC
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

// insertion d'un article
function addArticle(PDO $con,string $surname, string $email, string $text) : bool|string
{
    // erreur vide au cas où
    $erreur = "";

    // protection supplémentaire

    $surname = trim(htmlspecialchars(strip_tags($surname),ENT_QUOTES));
    // si le nom est vide
    if(empty($surname)){
        $erreur.="Votre nom est incorrect.<br>";
        // si le nom est plus long qu'autorisé en db
    }elseif(strlen($surname)>60){
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
    if(empty($text)||strlen($text)>500){
        $erreur .= "Message incorrect<br>";
    }

    // si on a au moins 1 erreur
    if(!empty($erreur)) return $erreur;

    // pas d'erreur détectée
    $prepare = $con->prepare("
    INSERT INTO `article` (`surname`,`email`,`message`)
    VALUES (?,?,?)
    ");
    try{
        $prepare->execute([$surname,$email,$text]);
        return true;
    }catch(Exception $e){
        die($e->getMessage());
    }

}