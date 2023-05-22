<?php
include('connexion_bdd.php');
session_start();

// Vérifie si l'ID de réservation existe dans la session
if (isset($_SESSION['reservation_info']['id'])) {
    $id = $_SESSION['reservation_info']['id'];

    // Suppression de la réservation dans la base de données en utilisant l'ID de réservation
    $query = "DELETE FROM reservations WHERE id = '$id'";

    if ($connexion->query($query) === true) {
        // Suppression réussie, réinitialisation de la session reservation_info
        unset($_SESSION['reservation_info']['id']);

        // Redirection vers reserver.php avec un message de succès
        header("Location: reserver.php?message=La réservation a été supprimée avec succès !");
    } else {
        // Erreur lors de la suppression, redirigez vers reserver.php avec un message d'erreur
        header("Location: reserver.php?error=1");
    }
    exit();
}
