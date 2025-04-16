<?php
# public/index.php

/*
 * Contrôleur frontal
 */

# chargement des constantes de connexion en mode prod
require_once "../config.php";
# chargement du modèle (fonctions)
require_once "../model/ArticleModel.php";


# connexion à PDO


# ici notre code de traitement de la page

// si on a envoyé le formulaire avec les bons champs


// on veut récupérer tous les messages de la table `article`






# chargement de la vue
require_once "../view/homepage.view.php";

# bonne pratique
# fermeture de connexion
