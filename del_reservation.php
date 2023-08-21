<?php
include('connexion_bdd.php');
session_start();

// Vérifie si l'ID de réservation existe dans la session
if (isset($_SESSION['reservation_info']['id'])) {
    $id = $_SESSION['reservation_info']['id'];

    // Supprime la réservation dans la base de données en utilisant l'ID
    $query = "DELETE FROM reservations WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Si suppression réussie, réinitialise la session reservation_info
        unset($_SESSION['reservation_info']['id']);
        unset($_SESSION['reservation_info']);

        // Redirige vers reserver.php avec un message de succès
        header("Location: reserver.php?message=La réservation a été supprimée avec succès !");
    } else {
        // Si suppression échoué, redirige vers reserver.php avec un message d'erreur
        header("Location: reserver.php?error=1");
    }
    exit();
}
