# Préparation TI2 - Insertion et sélection

## Avec Bonus

## Web C2 2025

### Fichiers

Dupliquez `config.dev.php` en `config.php`

### Importation de données

Importez le fichier `datas/pdo_c2_prepa_ti2.sql` via `phpMyAdmin` ou un autre outil de gestion de base de données vers `MySQL`.

### Chemin

Le dossier public de l'application est `public` et le fichier d'entrée est `index.php`.

### Navigation

Dans le fichier de configuration, il existe 2 constantes pour la pagination

```php
# pour la pagination
const PAGINATION_NB = 5;
const PAGINATION_GET = "pg";
```

L'objectif est d'avoir maximum 5 articles par page, puis une pagination se met en place