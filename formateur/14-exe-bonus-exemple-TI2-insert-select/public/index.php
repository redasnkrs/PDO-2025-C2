<?php
# public/index.php

/*
 * Contrôleur frontal
 */

# chargement des constantes de connexion en mode prod
require_once "../config.php";
# chargement du modèle (fonctions)
require_once "../model/MessagesModel.php";

# connexion à PDO
try{
    // nouvelle instance de PDO
    $db = new PDO(DB_DSN, DB_CONNECT_USER, DB_CONNECT_PWD,
        // tableau d'options
        [
            // par défaut les résultats sont en tableau associatif
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Afficher les exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );
}catch(Exception $e){
    // arrêt du script et affichage du code erreur, et du message
    die("Code : {$e->getCode()} <br> Message : {$e->getMessage()}");
}


// si on a envoyé le formulaire avec les bons champs
if(isset(
    $_POST['name'],
    $_POST['email'],
    $_POST['telephone'],
    $_POST['message'],

)) {

    // on va tenter l'insertion, car on a protégé addMessage()
$insert = addMessage($db,
    $_POST['name'],
    $_POST['email'],
    $_POST['telephone'],
    $_POST['message'],
);

}



// on veut récupérer tous les messages de la table `messages`
# $messages = getAllMessagesOrderByDateDesc($db);

/*
 * Bonus mise en place de la pagination
 */

// on vérifie sur quelle page on est (et que c'est un string qui contient que des numériques sans "." ni "-" => ctype_digit) || !empty($_GET[PAGINATION_GET] => pour le 0 ou $_GET[PAGINATION_GET]==="0"
if(
    isset($_GET[PAGINATION_GET]) // existence
    &&ctype_digit($_GET[PAGINATION_GET]) // string ne contient que 0..9
    &&!empty($_GET[PAGINATION_GET])// pas 0
){
    // conversion de string à int pour la pagination
    $page = (int) $_GET[PAGINATION_GET];
// nous sommes sur l'accueil OU la variable n'est pas conforme
}else{
    $page = 1;
}


# on compte le nombre total de messages
$nbMessage = countMessages($db);

# on récupère la pagination
$pagination = pagination($nbMessage,PAGINATION_GET,$page,PAGINATION_NB);

# pour obtenir le $offset pour les messages on divise le nombre de message par celui par page qu'on arrondit à l'entier supérieur avec ceil()
$offset = ($page-1)*PAGINATION_NB;

# on veut récupérer les messages de la page courante
$messages = getMessagesPagination($db,$offset,PAGINATION_NB);

# chargement de la vue
require_once "../view/homepage.view.php";

# bonne pratique
# fermeture de connexion
$db = null;