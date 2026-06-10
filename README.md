# myturfnew

Application web de gestion de pronostics hippiques (turf), développée en PHP selon le pattern MVC.

## Fonctionnalités

- Inscription et connexion des membres
- Saisie des courses du jour (hippodrome, partants, arrivée)
- Suivi des pronostics par tipster
- Statistiques de gains et résultats filtrables
- Interface d'administration des comptes membres

## Structure du projet

```
turf.ttar974.re/
├── controllers/       # Logique métier (Admin, Member, Visitor, Turf)
├── models/            # Accès base de données (requêtes SQL)
├── views/             # Templates PHP (pages, formulaires, emails)
└── public/            # Assets statiques (CSS, JS, images)
ttar92110138.sql       # Script SQL de création de la base de données
```

## Installation

1. Importer `ttar92110138.sql` dans votre base de données MySQL
2. Configurer les paramètres de connexion dans `models/Main.Model.Class.php`
3. Déployer le dossier `turf.ttar974.re/` sur un serveur Apache/Nginx avec PHP

## Prérequis

- PHP 7.4+
- MySQL 5.7+
- Serveur web Apache ou Nginx
