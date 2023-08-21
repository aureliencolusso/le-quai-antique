<?php
include('connexion_bdd.php');
include('header.php');

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user_info'])) {
    // Récupère les informations de l'utilisateur dans la session
    $email = $_SESSION['user_info']['email'];

    // Récupère les informations de l'utilisateur
    $query = "SELECT * FROM users WHERE email = :email";

    // Prépare la requête
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':email', $email);

    // Exécute la requête
    $stmt->execute();

    // Récupère les résultats de la requête
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur est trouvé, récupère les informations
    if ($user) {
        $name = $user['name'];
        $phone_number = $user['phone_number'];
        $nb_guests = $user['nb_guests'];
        $allergies = $user['allergies'];
    } else {
        // Si l'utilisateur n'est pas trouvé, redirige vers la page de connexion
        header("Location: login.php");
        exit();
    }
} else {
    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
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
                    Bienvenue sur votre profil, <?php echo $name ?> !
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
                        <strong>Nom :</strong> <?php echo $name; ?><br />
                        <strong>E-mail :</strong> <?php echo $email; ?><br />
                        <strong>Téléphone :</strong> <?php echo $phone_number; ?><br />
                        <strong>Convives par défaut :</strong> <?php echo $nb_guests; ?><br />
                        <strong>Allergies :</strong> <?php echo $allergies; ?>
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
