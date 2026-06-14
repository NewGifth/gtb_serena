<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "gtb_serena";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// echo "Connexion réussie";

?>