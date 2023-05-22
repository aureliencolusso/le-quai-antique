<?php
include('header.php');
include('connexion_bdd.php')
?>


<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
	<div class="container my-5 py-5">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1 class="card-page-title">
					<span class="bodonimt">Nos menus</span>
				</h1>
				<div class="card-page-text">
					<p>
						Retrouvez ici nos 3 menus disponibles.
						Tous nos plats sont faits maison et créés avec des produits locaux, provenant d’agriculteurs respectueux de l’environnement.
					</p>
				</div>
				<div class="separator"></div>
			</div>
		</div>
	</div>
</section>

<!--Menu déjeuner-->
<section class="menus-lists">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center mb-5">
				<h2 class="formule-title">Formule déjeuner</h2>
				<div class="menu-page-text">
					<p>
						Entrée et plat <b>ou</b> plat et dessert - <b>30€</b><br />
						Salade de chèvre et sa figue <b>ou</b> salade de quinoa et ses légumes de saison<br />
						Tartines de la forêt <b>ou</b> camembert rôti dans son lit de pain<br />
						Cheesecake aux fruits rouges <b>ou</b> crémeux et son coulis de fruits rouge
					</p>
				</div>
			</div>
		</div>
	</div>

	<!--Menu diner-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center mb-5">
				<h2 class="formule-title">Formule diner</h2>
				<div class="menu-page-text">
					<p>
						Entrée et plat et dessert - <b>40€</b><br />
						Salade de chèvre et sa figue <b>ou</b> salade de quinoa et ses légumes de saison<br />
						Tartines de la forêt <b>ou</b> camembert rôti dans son lit de pain<br />
						Cheesecake aux fruits rouges <b>ou</b> crémeux et son coulis de fruits rouge
					</p>
				</div>
			</div>
		</div>
	</div>

	<!--Menu enfant-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center mb-5">
				<h2 class="formule-title">Formule enfant</h2>
				<div class="menu-page-text">
					<p>
						Entrée et plat et dessert - <b>15€</b><br />
						Velouté de potiron maison<br />
						Filet de poulet, petits légumes<br />
						Sorbet fraise ou framboise
					</p>
				</div>
			</div>
		</div>
	</div>
</section>


<!--Bouton Réserver-->
<div class="reserv container">
	<a href="reserver.php"><button type="button" class="btn btn-outline-success btn-reserve">Réserver</button></a>
</div>

<?php include('footer.php'); ?>