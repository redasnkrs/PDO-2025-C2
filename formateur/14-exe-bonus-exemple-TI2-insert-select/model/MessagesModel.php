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
        $result = $prepare->fetchAll();
        // bonne pratique
        $prepare->closeCursor();
        return $result;

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

/***************
 * Pour le bonus
 ***************/

// fonction qui prend le nombre total de `messages`
function countMessages(PDO $db): int
{
    try{
        $request = $db->query("SELECT COUNT(*) as nb FROM messages ");
        $nb = $request->fetch()['nb'];
        $request->closeCursor();
        return $nb;
    }catch (Exception $e){
        die($e->getMessage());
    }
}
// fonction qui ne prend que les articles visibles sur cette page
function getMessagesPagination(PDO $con, int $offset, int $limit): array
{
    // préparation de la requête
    $prepare = $con->prepare("
        SELECT * FROM `messages`
        ORDER BY `messages`.`created_at` DESC
        LIMIT ?,?
        ");
    $prepare->bindParam(1,$offset,PDO::PARAM_INT);
    $prepare->bindParam(2,$limit,PDO::PARAM_INT);
    // essai / erreur
    try{
        // exécution de la requête
        $prepare->execute();

        // on renvoie le tableau (array) indexé contenant tous les résultats (peut être vide si pas de message).
        $result = $prepare->fetchAll();
        // bonne pratique
        $prepare->closeCursor();
        return $result;

        // en cas d'erreur sql
    }catch (Exception $e){
        // erreur de requête SQL
        die($e->getMessage());
    }
}

// création d'une fonction qui créer la pagination
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

function dateFR(string $datetime): string
{
    // temps unix en seconde de la date venant de la db
    $stringtotime = strtotime($datetime);
    // retour de la date au format
    return date("d/m/Y \à H:m:s",$stringtotime);
}
