<?php
include('connexion_bdd.php');
include('header.php');

// Vérifie si un message de confirmation est présent dans l'URL
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

// Récupération des données du formulaire
if (isset($_POST['btn-reserver'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone_number = $_POST['phone_number'];
	$menu = $_POST['menu'];
	$nb_guests = $_POST['nb_guests'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	$allergies = implode(",", $_POST['allergies']);
	$other_info = $_POST['other_info'];

	// Stockage des informations de réservation dans une session
	$_SESSION['reservation_info'] = array(
		'id' => $id,
		'name' => $name,
		'email' => $email,
		'phone_number' => $phone_number,
		'menu' => $menu,
		'nb_guests' => $nb_guests,
		'date' => $date,
		'time' => $time,
		'allergies' => $allergies,
		'other_info' => $other_info
	);

	// Vérification que l'email respecte le motif
	$email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
	if (!preg_match($email_pattern, $email)) {
		$email_error = "Veuillez entrer une adresse e-mail valide. Exemple : email@gmail.com";
	}
	// Vérification que le nom respecte le motif
	$name_pattern = '/^[A-Za-z\s]+$/';
	if (!preg_match($name_pattern, $name)) {
		$name_error = "Le nom ne doit contenir que des lettres alphabétiques et des espaces.";
	}
	// Vérification que le numéro de téléphone respecte le motif
	$phone_pattern = '/^\d{10}$/';
	if (!preg_match($phone_pattern, $phone_number)) {
		$phone_error = "Veuillez entrer un numéro de téléphone valide (10 chiffres).";
	}
	// Vérification de la capacité maximale
	$query = "SELECT max_guests FROM restaurant WHERE id = 1";
	$result = $connexion->query($query);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$maxGuests = $row['max_guests'];
		$totalGuests = 0;

		// Calcul du nombre total de convives attendus à la date et heure de la réservation
		$stmt = $connexion->prepare("SELECT nb_guests FROM reservations WHERE date = ? AND time = ?");
		$stmt->bind_param("ss", $date, $time);
		$stmt->execute();
		$stmt->store_result();

		$totalGuests = $stmt->num_rows;

		$totalGuests += $nb_guests;

		if ($totalGuests > $maxGuests) {
			echo "Capacité maximale atteinte. La réservation ne peut pas être effectuée.";
		} else {
			// Insertion de la réservation dans la base de données
			$users_id = isset($_SESSION['user_info']['id']) ? $_SESSION['user_info']['id'] : 0;
			$stmt = $connexion->prepare("INSERT INTO reservations (id, users_id, name, email, phone_number, menu, nb_guests, date, time, allergies, other_info)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("iisssisssss", $id, $users_id, $name, $email, $phone_number, $menu, $nb_guests, $date, $time, $allergies, $other_info);

			if ($stmt->execute()) {
				header("Location: confirm_reservation.php");
				exit();
			} else {
				echo "Erreur lors de l'insertion de la réservation : " . $stmt->error;
			}
		}
	} else {
		echo "Impossible de récupérer la capacité maximale du restaurant.";
	}
}
?>


<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
	<div class="container my-5 py-5">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1 class="card-page-title">
					<span class="bodonimt">Réserver</span>
				</h1>
				<div class="card-page-text">
					Merci d’avance de préciser en commentaire le nombre d’enfants présent à table (si il y en a).
					Pour tout retard de plus de 20 minutes votre table sera donnée à un autre client.
				</div>
				<div class="separator"></div>
			</div>
			<!-- Affichage du message de confirmation -->
			<?php if (isset($message)) : ?>
				<div class="alert alert-success"><?php echo $message; ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>


<!--Formulaire de réservation pour utilisateur connecté-->
<?php if (isset($_SESSION['user_info'])) : ?>
	<section class="register-form py-5">
		<div class="container">
			<form method="POST" action="reserver.php">
				<div class="row">
					<div style="display: none;">
						<div class="input-group mb-3">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
							<?php
							$id = preg_replace('/[^0-9]/', '', uniqid());
							?>
							<input type="int" class="form-control" placeholder="id" name="id" value="<?php echo $id; ?>" />
						</div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-user"></i></span>
						<input type="text" class="form-control" placeholder="Votre nom complet" name="name" value="<?php echo $_SESSION['user_info']['name']; ?>" readonly />
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-at"></i></span>
						<input type="email" class="form-control" placeholder="Votre adresse email" name="email" value="<?php echo $_SESSION['user_info']['email']; ?>" readonly />
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-phone"></i></span>
						<input type="tel" class="form-control" placeholder="Numéro de téléphone" name="phone_number" value="<?php echo $_SESSION['user_info']['phone_number']; ?>" />
					</div>
					<div class="input-group mb-3">
						<label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-utensils"></i></label>
						<select class="form-select" id="inputGroupSelect01" name="menu">
							<option class="text-muted">Choisir un menu</option>
							<option value="Déjeuner">Déjeuner</option>
							<option value="Dîner">Diner</option>
							<option value="Enfant">Enfant</option>
						</select>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-users"></i></span>
						<select class="form-select" name="nb_guests">
							<option value="0" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 0) {
													echo "selected";
												} ?>>Nombre de personnes</option>
							<option value="1" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 1) {
													echo "selected";
												} ?>>1 personne</option>
							<option value="2" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 2) {
													echo "selected";
												} ?>>2 personnes</option>
							<option value="3" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 3) {
													echo "selected";
												} ?>>3 personnes</option>
							<option value="4" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 4) {
													echo "selected";
												} ?>>4 personnes</option>
							<option value="5" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 5) {
													echo "selected";
												} ?>>5 personnes</option>
							<option value="6" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 6) {
													echo "selected";
												} ?>>6 personnes</option>
							<option value="7" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 7) {
													echo "selected";
												} ?>>7 personnes</option>
							<option value="8" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 8) {
													echo "selected";
												} ?>>8 personnes</option>
							<option value="9" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 9) {
													echo "selected";
												} ?>>9 personnes</option>
							<option value="10" <?php if (isset($_SESSION['user_info']['nb_guests']) && $_SESSION['user_info']['nb_guests'] == 10) {
													echo "selected";
												} ?>>10 personnes ou plus</option>
						</select>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
						<input type="date" class="form-control" placeholder="Date" name="date" min="<?php echo date('Y-m-d'); ?>" required />
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-clock"></i></span>
						<select class="form-select" aria-label="Select time" name="time" required>
							<option selected>Choisir une heure</option>
							<optgroup label="Midi">
								<option value="12:00">12:00</option>
								<option value="12:15">12:15</option>
								<option value="12:30">12:30</option>
								<option value="12:45">12:45</option>
								<option value="13:00">13:00</option>
								<option value="13:15">13:15</option>
								<option value="13:30">13:30</option>
								<option value="13:45">13:45</option>
								<option value="14:00">14:00</option>
							</optgroup>
							<optgroup label="Soir">
								<option value="19:00">19:00</option>
								<option value="19:15">19:15</option>
								<option value="19:30">19:30</option>
								<option value="19:45">19:45</option>
								<option value="20:00">20:00</option>
								<option value="20:15">20:15</option>
								<option value="20:30">20:30</option>
								<option value="20:45">20:45</option>
								<option value="21:00">21:00</option>
								<option value="21:15">21:15</option>
								<option value="21:30">21:30</option>
								<option value="21:45">21:45</option>
								<option value="22:00">22:00</option>
							</optgroup>
						</select>
					</div>

					<div class="input-group mb-3">
						<span class="input-group-text">Allergies</span>
						<textarea class="form-control" aria-label="With textarea" name="allergies[]"><?php echo $_SESSION['user_info']['allergies'] ?></textarea>
					</div>

					<div class="input-group mb-3">
						<span class="input-group-text">Autres informations</span>
						<textarea class="form-control" aria-label="With textarea" placeholder="Ex: Il y aura 2 enfants" name="other_info"></textarea>
					</div>

					<div class="connect container">
						<button type="submit" class="btn btn-outline-success btn-connect" name="btn-reserver">Réserver</button>
					</div>
				</div>
			</form>
		</div>
	</section>

<?php else : ?>

	<!--Formulaire de réservation pour utilisateur non-connecté-->
	<section class="register-form py-5">
		<div class="container">
			<form method="POST" action="reserver.php">
				<div class="row">
					<div style="display: none;">
						<div class="input-group mb-3">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
							<?php
							$id = preg_replace('/[^0-9]/', '', uniqid());
							?>
							<input type="int" class="form-control" placeholder="id" name="id" value="<?php echo $id; ?>" />
						</div>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-user"></i></span>
						<input type="text" class="form-control" placeholder="Votre nom complet" name="name" pattern="[A-Za-z\s]+" required />
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-at"></i></span>
						<input type="email" class="form-control" placeholder="Votre adresse email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required />
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-phone"></i></span>
						<input type="tel" class="form-control" placeholder="Numéro de téléphone" name="phone_number" pattern="\d{10}" required />
					</div>
					<div class="input-group mb-3">
						<label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-utensils"></i></label>
						<select class="form-select" id="inputGroupSelect01" name="menu">
							<option class="text-muted">Choisir un menu</option>
							<option value="dejeuner">Déjeuner</option>
							<option value="diner">Diner</option>
							<option value="enfant">Enfant</option>
						</select>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-users"></i></span>
						<select class="form-select" name="nb_guests">
							<option value="-1" selected>Nombre de personnes</option>
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
						<span class="input-group-text"><i class="fas fa-calendar"></i></span>
						<input type="date" class="form-control" placeholder="Date" name="date" min="<?php echo date('Y-m-d'); ?>" required />
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="fas fa-clock"></i></span>
						<select class="form-select" aria-label="Select time" name="time" required>
							<option selected disabled>Choisir une heure</option>
							<optgroup label="Midi">
								<option value="12:00">12:00</option>
								<option value="12:15">12:15</option>
								<option value="12:30">12:30</option>
								<option value="12:45">12:45</option>
								<option value="13:00">13:00</option>
								<option value="13:15">13:15</option>
								<option value="13:30">13:30</option>
								<option value="13:45">13:45</option>
								<option value="14:00">14:00</option>
							</optgroup>
							<optgroup label="Soir">
								<option value="19:00">19:00</option>
								<option value="19:15">19:15</option>
								<option value="19:30">19:30</option>
								<option value="19:45">19:45</option>
								<option value="20:00">20:00</option>
								<option value="20:15">20:15</option>
								<option value="20:30">20:30</option>
								<option value="20:45">20:45</option>
								<option value="21:00">21:00</option>
								<option value="21:15">21:15</option>
								<option value="21:30">21:30</option>
								<option value="21:45">21:45</option>
								<option value="22:00">22:00</option>
							</optgroup>
						</select>
					</div>
					<div class="input-group mb-3">
						<label class="input-group-text" for="allergies-select"><i class="fas fa-exclamation-triangle"></i></label>
						<select class="form-select" id="allergies-select" name="allergies[]" multiple>
							<option value="0" selected>Sélectionnez vos allergies</option>
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
					<div class="input-group">
						<span class="input-group-text">Autres informations</span>
						<textarea class="form-control" aria-label="With textarea" placeholder="Ex: Il y aura 2 enfants" name="other_info"></textarea>
					</div>
					<div class="connect container">
						<button type="submit" class="btn btn-outline-success btn-connect" name="btn-reserver">Réserver</button>
					</div>
				</div>
			</form>
		</div>
	</section>

<?php endif; ?>


<?php include('footer.php') ?>