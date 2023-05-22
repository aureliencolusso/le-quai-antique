<?php
// Les informations de connexion à la base de données
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "lequaiantique";

// Connexion à la base de données
$connexion = mysqli_connect($host, $username, $password, $dbname);

// Vérification de la connexion
if (!$connexion) {
    die("Connexion échouée : " . mysqli_connect_error());
}
