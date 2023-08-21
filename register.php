<?php
include('connexion_bdd.php');
include('header.php');

if (isset($_POST['btn-register'])) {
	// Récupère les données du formulaire
	$email = $_POST['email'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$phone_number = $_POST['phone_number'];
	$nb_guests = $_POST['nb_guests'];
	$allergies = implode(",", $_POST['allergies']);

	// Vérifie que l'email respecte le motif
	$email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
	if (!preg_match($email_pattern, $email)) {
		$email_error = "Veuillez entrer une adresse e-mail valide. Exemple : email@gmail.com";
	}

	// Vérifie que le mot de passe respecte le motif
	$password_pattern = '/^(?=.*\d).{6,}$/';
	if (!preg_match($password_pattern, $password)) {
		$password_error = "Le mot de passe doit contenir au moins 8 caractères et au moins 1 chiffre.";
	}

	// Vérifie que le nom respecte le motif
	$name_pattern = '/^[A-Za-z\s]+$/';
	if (!preg_match($name_pattern, $name)) {
		$name_error = "Le nom ne doit contenir que des lettres alphabétiques et des espaces.";
	}

	// Vérifie que le numéro de téléphone respecte le motif
	$phone_pattern = '/^\d{10}$/';
	if (!preg_match($phone_pattern, $phone_number)) {
		$phone_error = "Veuillez entrer un numéro de téléphone valide (10 chiffres).";
	}

	// Hashage du mot de passe
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	// Insert les données dans la base de données en utilisant une requête préparée
	$requete = "INSERT INTO users (email, password, name, phone_number, nb_guests, allergies) VALUES (?, ?, ?, ?, ?, ?)";
	$stmt = $connexion->prepare($requete);
	$stmt->execute([$email, $hashed_password, $name, $phone_number, $nb_guests, $allergies]);

	// Démarre la session
	$_SESSION['user_info'] = array(
		'email' => $email,
		'name' => $name,
		'phone_number' => $phone_number,
		'nb_guests' => $nb_guests,
		'allergies' => $allergies,
	);

	// Redirige vers la page de profil
	header("Location: profil.php");
	exit();
}
?>

<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
	<div class="container my-5 py-5">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1 class="card-page-title">
					<span class="bodonimt">Inscription</span>
				</h1>
				<div class="separator"></div>
			</div>
		</div>
	</div>
</section>

<!--Formulaire Inscription-->
<section class="register-form py-5">
	<div class="container">
		<form method="POST" action="register.php">
			<div class="row">
				<div class="input-group mb-3">
					<span class="input-group-text"><i class="fas fa-at"></i></span>
					<input type="email" class="form-control" placeholder="Votre adresse email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required />
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text"><i class="fas fa-eye"></i></span>
					<input type="password" class="form-control" placeholder="Votre mot de passe (Au moins 8 caractères et un chiffre)" name="password" pattern="^(?=.*\d).{6,}$" title="Le mot de passe doit contenir au moins 6 caractères et au moins 1 chiffre." required />
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text"><i class="fas fa-user"></i></span>
					<input type="text" class="form-control" placeholder="Votre nom complet" name="name" pattern="[A-Za-z\s]+" required />
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text"><i class="fas fa-phone"></i></span>
					<input type="tel" class="form-control" placeholder="Numéro de téléphone" name="phone_number" pattern="\d{10}" required />
				</div>
				<div class="input-group mb-3">
					<span class="input-group-text"><i class="fas fa-users"></i></span>
					<select class="form-select" name="nb_guests">
						<option value="0" selected>Nombre de convives par défaut</option>
						<option value="1">1 personne</option>
						<option value="2">2 personnes</option>
						<option value="3">3 personnes</option>
						<option value="4">4 personnes</option>
						<option value="5">5 personnes</option>
						<option value="6">6 personnes</option>
						<option value="7">7 personnes</option>
						<option value="8">8 personnes</option>
						<option value="9">9 personnes</option>
						<option value="10">10 personnes ou plus</option>
					</select>
				</div>
				<div class="input-group mb-3">
					<label class="input-group-text" for="allergies-select"><i class="fas fa-exclamation-triangle"></i></label>
					<select class="form-select" id="allergies-select" name="allergies[]" multiple>
						<option value="aucune" selected>Sélectionnez vos allergies</option>
						<option value="aucune">Aucune</option>
						<option value="lactose">Lactose</option>
						<option value="gluten">Gluten</option>
						<option value="arachides">Arachides</option>
						<option value="noix">Noix</option>
						<option value="crustaces">Crustacés</option>
						<option value="poisson">Poisson</option>
						<option value="soja">Soja</option>
						<option value="oeufs">Œufs</option>
						<option value="autre">Autre</option>
					</select>
				</div>

				<div class="cgu d-flex justify-content-center align-items-center">
					<div class="form-group text-center">
						<label for="accept-cgu">
							J'accepte les <a href="terms_of_service.php" target="_blank">conditions générales d'utilisation</a>
						</label>
						<div class="form-check d-inline-flex">
							<input class="form-check-input" type="checkbox" value="accepted" id="accept-cgu" name="accept-cgu" required>
							<label class="form-check-label" for="accept-cgu"> </label>
						</div>
					</div>
				</div>

				<div class="connect container">
					<button type="submit" class="btn btn-outline-success btn-connect" name="btn-register">S'inscrire</button>
				</div>
			</div>
		</form>
	</div>
</section>

<?php include('footer.php'); ?>
