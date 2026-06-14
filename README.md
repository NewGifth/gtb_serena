
# GTB Serena

## Présentation

GTB Serena est une application web de Gestion Technique de Bâtiment (GTB) développée dans le cadre d'un travail de fin de cycle en Informatique. Elle permet la supervision et le contrôle des équipements techniques d'un bâtiment tels que l'éclairage, la climatisation et la surveillance de la température.

## Fonctionnalités

* Authentification des utilisateurs
* Tableau de bord interactif
* Gestion de la température
* Contrôle de l'éclairage (ON/OFF)
* Contrôle de la climatisation (ON/OFF)
* Gestion des alertes automatiques
* Historique des opérations
* Intégration des données météorologiques de Goma via WeatherAPI
* Interface responsive compatible PC et Smartphone

## Technologies utilisées

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* Bootstrap 5
* XAMPP
* WeatherAPI
* ESP8266
* Arduino Nano
* DHT11

## Structure du projet

```text
gtb_serena/
├── alertes/
├── climatisation/
├── config/
├── eclairage/
├── historique/
├── temperature/
├── utilisateur/
├── dashboard.php
├── login.php
├── logout.php
├── meteo.php
└── README.md
```

## Installation

1. Installer XAMPP.
2. Copier le dossier `gtb_serena` dans le dossier `htdocs`.
3. Démarrer Apache et MySQL.
4. Créer une base de données nommée `gtb_serena`.
5. Importer le fichier SQL du projet dans phpMyAdmin.
6. Configurer la clé WeatherAPI dans le fichier `meteo.php`.
7. Accéder à l'application depuis :

```text
http://localhost/gtb_serena
```

## Objectif du projet

L'objectif principal de ce projet est de proposer une solution permettant la surveillance et le contrôle des équipements techniques d'un bâtiment à travers une interface web centralisée.

## Auteur

Précieux Kasereka

## Encadrement académique

Projet académique réalisé dans le cadre de la formation en Informatique.
