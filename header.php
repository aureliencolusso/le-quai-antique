<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/css/styles.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<link rel="icon" type="assets/img/autres/icon.png" href="favicon.png">
	<title>Le Quai Antique</title>
</head>

<body>

	<!--Barre de Navigation-->
	<nav class="cc-navbar navbar navbar-dark position-fixed w-100">
		<div class="container-fluid justify-content-between">
			<div class="align-items-center">
				<a href="index.php"><img src="assets/img/autres/logo.png" class="logo-site" alt="Le Quai Antique"></a>
			</div>
			<div class="align-items-center">
				<?php if (isset($_SESSION['user_info']) && $_SESSION['user_info']['is_admin'] == 1) { ?>
					<a href="admin.php"><img src="assets/img/autres/admin.png" class="logo-admin" alt="Administration"></a>
				<?php } ?>
				<?php if (isset($_SESSION['reservation_info'])) { ?>
					<a href="confirm_reservation.php"><img src="assets/img/autres/réservation.png" class="logo-reserv" alt="Réservation"></a>
				<?php } else { ?>
					<a href="reserver.php"><img src="assets/img/autres/réservation.png" class="logo-reserv" alt="Réservation"></a>
				<?php } ?>
				<?php if (isset($_SESSION['user_info'])) { ?>
					<a href="profil.php"><img src="assets/img/autres/connexion.png" class="logo-connex" alt="Connexion"></a>
				<?php } else { ?>
					<a href="login.php"><img src="assets/img/autres/connexion.png" class="logo-connex" alt="Connexion"></a>
				<?php } ?>
			</div>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<img src="assets/img/autres/menu.png" class="menu">
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item pe-4">
						<a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
					</li>
					<li class="nav-item pe-4">
						<a class="nav-link" href="dishes.php">La Carte</a>
					</li>
					<li class="nav-item pe-4">
						<a class="nav-link" href="menus.php">Nos Menus</a>
					</li>
					<?php if (isset($_SESSION['user_info']) && $_SESSION['user_info']['is_admin'] == 1) { ?>
						<li class="nav-item pe-4">
							<a class="nav-link" href="admin.php">Administration</a>
						</li>
					<?php } ?>
					<?php if (isset($_SESSION['reservation_info'])) { ?>
						<li class="nav-item pe-4">
							<a class="nav-link" href="confirm_reservation.php"><strong>Ma reservation</strong></a>
						</li>
					<?php } else { ?>
						<li class="nav-item pe-4">
							<a class="nav-link" href="reserver.php"><strong>Réserver</strong></a>
						</li>
					<?php } ?>
					<?php if (isset($_SESSION['user_info'])) { ?>
						<li class="nav-item pe-4">
							<a class="nav-link" href="profil.php">Profil</a>
						</li>
					<?php } else { ?>
						<li class="nav-item pe-4">
							<a class="nav-link" href="register.php">S'inscrire</a>
						</li>
						<li class="nav-item pe-4">
							<a class="nav-link" href="login.php">Se connecter</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>