<?php

require_once("config/connexion.php");

$apiKey = "bf1c0bee140b4796a82171432261406";

$url = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=Goma";

$response = file_get_contents($url);

$data = json_decode($response, true);

$tempExterieure = $data['current']['temp_c'];

/* Simulation dynamique */

$reception  = round($tempExterieure - rand(0,2),1);
$restaurant = round($tempExterieure + rand(1,3),1);
$vip        = round($tempExterieure - rand(1,3),1);
$conference = round($tempExterieure + rand(0,2),1);

/* Alertes automatiques */

$etat_reception  = ($reception >= 28) ? 'Alerte' : 'Normal';
$etat_restaurant = ($restaurant >= 28) ? 'Alerte' : 'Normal';
$etat_vip        = ($vip >= 28) ? 'Alerte' : 'Normal';
$etat_conf       = ($conference >= 28) ? 'Alerte' : 'Normal';

/* Mise à jour BD */

mysqli_query($conn,
"UPDATE temperature
SET valeur='$reception',
etat='$etat_reception'
WHERE zone='Réception'");

mysqli_query($conn,
"UPDATE temperature
SET valeur='$restaurant',
etat='$etat_restaurant'
WHERE zone='Restaurant'");

mysqli_query($conn,
"UPDATE temperature
SET valeur='$vip',
etat='$etat_vip'
WHERE zone='Salle VIP'");

mysqli_query($conn,
"UPDATE temperature
SET valeur='$conference',
etat='$etat_conf'
WHERE zone='Salle Conférence'");

/* Pour test uniquement */

echo 'Température extérieure : '.$tempExterieure.' °C';

?>