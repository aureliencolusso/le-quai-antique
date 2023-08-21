<?php
session_start(); // Démarre la session

// Détruit toutes les variables de session
$_SESSION = array();

// Destruction de la session
session_destroy();

// Redirige vers la page de connexion
header("Location: login.php");
exit();
