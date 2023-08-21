<?php
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "lequaiantique";

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configure PDO pour générer des exceptions en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}
?>
