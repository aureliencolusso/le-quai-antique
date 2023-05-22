<?php
include('header.php');
include('connexion_bdd.php');


// Vérification que le formulaire a été soumis
if (isset($_POST["btn-connect"])) {
	// Récupération des valeurs du formulaire
	$email = $_POST["email"];
	$password = $_POST["password"];

	// Requête SQL qui récupère les informations de l'user
	$sql = "SELECT * FROM users WHERE email = '$email'";

	// Exécution de la requête
	$resultat = mysqli_query($connexion, $sql);

	// Vérification de la réussite de la requête
	if (!$resultat) {
		die("Erreur dans la requête : " . mysqli_error($connexion));
	}

	// Récupération des résultats de la requête
	$users = mysqli_fetch_assoc($resultat);

	if (password_verify($password, $users["password"])) {
		// Le mot de passe est correct, l'utilisateur est authentifié
		// Vous pouvez maintenant rediriger l'utilisateur vers une page sécurisée
		$_SESSION['user_info'] = array(
			'email' => $users['email'],
			'name' => $users['name'],
			'phone_number' => $users['phone_number'],
			'nb_guests' => $users['nb_guests'],
			'allergies' => $users['allergies'],
			'menu' => $users['menu'],
			'date' => $users['date'],
			'time' => $users['time'],
			'other_info' => $users['other_info'],
			'is_admin' => $users['is_admin'],
			'id' => $users['id']
		);

		header("Location: profil.php");
	} else {
		// Le mot de passe est incorrect, l'utilisateur est refusé
		// Vous pouvez afficher un message d'erreur à l'utilisateur
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
			<?php if (isset($error_message)) : ?>
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