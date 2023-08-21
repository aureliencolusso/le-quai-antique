<?php
include('connexion_bdd.php');
include('header.php');

$error_message = "";

// Vérifie que le formulaire a été soumis
if (isset($_POST["btn-connect"])) {
    // Récupère les valeurs du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Récupère les informations de l'utilisateur
    $query = "SELECT * FROM users WHERE email = :email";

    // Prépare la requête
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':email', $email);

    // Exécute la requête
    $stmt->execute();

    // Récupère les résultats de la requête
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le mot de passe est correct, l'utilisateur est authentifié
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION['user_info'] = array(
            'email' => $user['email'],
            'name' => $user['name'],
            'phone_number' => $user['phone_number'],
            'nb_guests' => $user['nb_guests'],
            'allergies' => $user['allergies'],
            'menu' => $user['menu'],
            'date' => $user['date'],
            'time' => $user['time'],
            'other_info' => $user['other_info'],
            'is_admin' => $user['is_admin'],
            'id' => $user['id']
        );

        header("Location: profil.php");
        exit();
    } else {
        // Sinon, affiche un message d'erreur
        $error_message = "Email ou mot de passe incorrect";
    }
}
?>

<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
    <div class="container my-5 py-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="card-page-title">
                    <span class="bodonimt">Se connecter</span>
                </h1>
                <div class="separator"></div>
            </div>
        </div>
    </div>
</section>

<!--Formulaire de connexion-->
<section class="connect-form py-5">
    <div class="container">
        <form method="POST" action="login.php">
            <div class="row">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                    <input type="email" class="form-control" placeholder="Votre adresse email" name="email" required />
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-eye"></i></span>
                    <input type="password" class="form-control" placeholder="Votre mot de passe" name="password" required />
                </div>
            </div>

            <!-- Affichage du message d'erreur -->
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!--Bouton connexion-->
            <div class="connect container">
                <button type="submit" class="btn btn-outline-success btn-connect" name="btn-connect">Se connecter</button>
            </div>
        </form>
    </div>
</section>

<!--Bouton Inscription-->
<div class="register container">
    <a href="register.php"><button type="button" class="btn btn-outline-success btn-register">S'inscrire</button></a>
</div>

<?php include('footer.php'); ?>
