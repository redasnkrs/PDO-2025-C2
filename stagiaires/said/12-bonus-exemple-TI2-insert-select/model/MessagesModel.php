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

function getNbTotalMessage(PDO $con): int
{
    // on compte le nombre de message total
    $query = $con->query("SELECT COUNT(*) as nb FROM `messages` ");
    // on renvoie l'entier stocké dans nb
    return $query->fetch()['nb'];
}

function getMessagePagination(PDO $con, int $offset, int $limit): array
{
    $prepare = $con->prepare(
        "SELECT * FROM `messages`
        ORDER BY `messages`.`created_at` DESC
        LIMIT ?,?"
    );
    try{
        $prepare->bindParam(1,$offset,PDO::PARAM_INT);
        $prepare->bindParam(2,$limit,PDO::PARAM_INT);
        $prepare->execute();
        return $prepare->fetchAll();

    }catch(Exception $e){
        die($e->getMessage());
    }
}

function pagination(int $nbtotalMessage, string $get="page", int $pageActu=1, int $perPage=5 ): string
{

    // variable de sortie
    $sortie = "";

    // si pas de page nécessaire
    if ($nbtotalMessage === 0) return "";

    // nombre de pages, division du total des messages mis à l'entier supérieur
    $nbPages = ceil($nbtotalMessage / $perPage);

    // si une seule page, pas de lien à afficher
    if ($nbPages == 1) return "";

    // nous avons plus d'une page
    $sortie .= "<p>";


    // tant qu'on a des pages
    for ($i = 1; $i <= $nbPages; $i++) {
        // si on est au premier tour de boucle
        if ($i === 1) {
            // si on est sur la première page
            if ($pageActu === 1) {
                // pas de lien
                $sortie .= "<< < 1 |";
                // si nous sommes sur la page 2
            } elseif ($pageActu === 2) {
                // tous les liens vont vers la page 1
                $sortie .= " <a href='./'><<</a> <a href='./'><</a> <a href='./'>1</a> |";
                // si nous sommes sur d'autres pages, le retour va vers la page précédente
            } else {
                $sortie .= " <a href='./'><<</a> <a href='?$get=" . ($pageActu - 1) . "'><</a> <a href='./'>1</a> |";
            }
            // nous ne sommes pas sur le premier ni dernier tour de boucle
        } elseif ($i < $nbPages) {
            // si nous sommes sur la page actuelle
            if ($i === $pageActu) {
                // pas de lien
                $sortie .= "  $i |";
            } else {
                // si nous ne sommes pas sur la page actuelle
                $sortie .= "  <a href='?$get=$i'>$i</a> |";
            }
            // si nous sommes sur le dernier tour de boucle
        } else {
            // si nous sommes sur la dernière page
            if ($pageActu >= $nbPages) {
                // pas de lien
                $sortie .= "  $nbPages > >>";
                // si nous ne sommes pas sur la dernière page
            } else {
                // tous les liens vont vers la dernière page
                $sortie .= "  <a href='?$get=$nbPages'>$nbPages</a> <a href='?$get=" . ($pageActu + 1) . "'>></a> <a href='?$get=$nbPages'>>></a>";
            }
        }
    }
        $sortie .= "</p>";
        return $sortie;

    }
