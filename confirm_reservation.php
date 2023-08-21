<?php
include('connexion_bdd.php');
include('header.php');

// Vérifie si les informations de réservation existent dans la session, sinon redirige vers reserver.php
if (isset($_SESSION['reservation_info'])) {
    $reservationInfo = $_SESSION['reservation_info'];
} else {
    header("Location: reserver.php");
    exit();
}
?>

<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
    <div class="container my-5 py-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="card-page-title">
                    <span class="bodonimt">Réservation</span>
                </h1>
                <div class="separator"></div>
            </div>
        </div>
    </div>
</section>

<!--Contenu-->
<section class="available merriweather">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <div class="col-md-12 text-center">
                    <p><strong><?php echo htmlspecialchars($_SESSION['reservation_info']['name']); ?></strong>, votre réservation a bien été enregistrée !</p>
                </div>
                <div class="infos-user">
                    <ul class="list-unstyled">
                        <strong>Nom :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['name']); ?><br />
                        <strong>E-mail :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['email']); ?><br />
                        <strong>Téléphone :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['phone_number']); ?><br />
                        <strong>Menu :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['menu']); ?><br />
                        <strong>Convives :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['nb_guests']); ?><br />
                        <strong>Date :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['date']); ?><br />
                        <strong>Heure :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['time']); ?><br />
                        <strong>Allergies :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['allergies']); ?><br />
                        <strong>Autres informations :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['other_info']); ?><br />
                        <strong>Numéro de réservation :</strong> <?php echo htmlspecialchars($_SESSION['reservation_info']['id']); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Bouton Supprimer-->
<div class="reserv container">
    <a href="del_reservation.php"><button type="button" class="btn btn-outline-success btn-reserve">Supprimer</button></a>
</div>

<!--Bouton Accueil-->
<div class="connect container">
    <a href="index.php"><button type="button" class="btn btn-outline-success btn-accueil">Retour à l'accueil</button></a>
</div>

<?php include('footer.php'); ?>
