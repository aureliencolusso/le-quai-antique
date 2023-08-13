<?php
include('connexion_bdd.php');
include('header.php');

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_info'])) {
    // Récupérer les informations de l'utilisateur
    $email = $_SESSION['user_info']['email'];
    $name = $_SESSION['user_info']['name'];
    $phone_number = $_SESSION['user_info']['phone_number'];
    $nb_guests = $_SESSION['user_info']['nb_guests'];
    $allergies = $_SESSION['user_info']['allergies'];
} else {
    // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}
?>


<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
    <div class="container my-5 py-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="card-page-title">
                    <span class="bodonimt">Profil</span>
                </h1>
                <div class="card-page-text">
                    Bienvenue sur votre profil, <?php echo $_SESSION['user_info']['name'] ?> !
                </div>
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
                <h2 class="formule-title">Informations de votre compte</h2>
                <div class="infos-user">
                    <ul class="list-unstyled">
                        <strong>Nom :</strong> <?php echo $_SESSION['user_info']['name']; ?><br />
                        <strong>E-mail :</strong> <?php echo $_SESSION['user_info']['email']; ?><br />
                        <strong>Téléphone :</strong> <?php echo $_SESSION['user_info']['phone_number']; ?><br />
                        <strong>Convives par défaut :</strong> <?php echo $_SESSION['user_info']['nb_guests']; ?><br />
                        <strong>Allergies :</strong> <?php echo $_SESSION['user_info']['allergies'] ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Bouton Déconnexion-->
<div class="reserv container">
    <a href="logout.php"><button type="button" class="btn btn-outline-success btn-reserve">Déconnexion</button></a>
</div>


<?php include('footer.php'); ?>