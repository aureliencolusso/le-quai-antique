<?php
include('connexion_bdd.php');
include('header.php');


// Récupération des données de la table "gallery"
$sql = 'SELECT * FROM gallery';
$result = mysqli_query($connexion, $sql);

if (!$result) {
  die('Erreur dans la requête : ' . mysqli_error($connexion));
}
?>


<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
  <div class="container my-5 py-5">
    <div class="row">
      <div class="col-md-12 text-center">
        <h1 class="title1">
          <span class="barlowcondensed">Restaurant Gastronomique</span>
        </h1><br>
        <h1 class="title2">
          <span class="bodonimt">Le Quai Antique</span>
        </h1>
        <div class="separator"></div>
      </div>
    </div>
  </div>
</section>


<!--Carousel-->
<section class="cc-carousel text-center">
  <div class="container">
    <div class="row">
      <h2 class="about">A PROPOS</h2>
      <div class="about-text">
        Bienvenue sur le site du chef Michant, un véritable passionné de cuisine qui a récemment ouvert son 3ème restaurant gastronomique en Savoie. Chef talentueux, il est reconnu pour son savoir-faire culinaire et son utilisation exclusive de produits locaux et de saison.<br><br>
        Le nouveau restaurant du chef Michant, situé dans le cœur historique de la ville, est un véritable joyau de la gastronomie savoyarde. Vous pourrez y déguster des plats authentiques et inventifs, sublimés par des ingrédients de qualité issus des producteurs locaux.<br><br>
        Alors si vous cherchez une expérience gastronomique unique en Savoie, ne manquez pas de reserver votre table au restaurant du chef Michant dès maintenant.
      </div>
    </div>
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/img/Carousel/carousel1.gif" class="img-fluid" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="assets/img/Carousel/carousel2.jpg" class="img-fluid" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="assets/img/Carousel/carousel3.gif" class="img-fluid" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="assets/img/Carousel/carousel4.jpg" class="img-fluid" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="assets/img/Carousel/carousel5.gif" class="img-fluid" class="d-block w-100" alt="..." />
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
      </button>
    </div>
  </div>
</section>

<!-- Séparateur -->
<div class="container">
  <div class="col-md-12">
    <div class="separator"></div>
  </div>
</div>


<!--Les plats phares-->
<section class="star-dishes text-center">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-5">
        <h2 class="fav-dishes">NOS PLATS PHARES</h2>
      </div>
      <div class="col-md-12 text-center">
        <p class="fav-dishes-text">
          Le Quai Antique propose une expérience culinaire unique, avec des plats savoureux et inventifs, mettant en valeur les produits locaux et de saison. Parmi les plats phares du restaurant, vous pourrez découvrir des mets délicats, aux associations de saveurs surprenantes.
        </p>
      </div>
      <div class="col-12">
        <div class="card-deck">
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $title = $row['title'];
            $description = $row['description'];
            $imagePath = $row['image_path'];
          ?>
            <div class="col-12 my-4">
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title"><?php echo $title; ?></h3>
                  <p class="card-text"><?php echo $description; ?></p>
                </div>
                <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="..." />
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Séparateur -->
<div class="container">
  <div class="col-md-12">
    <div class="separator d-flex"></div>
  </div>
</div>


<!--Nos menus-->
<div class="container py-4">
  <h2 class="our-menus">NOS MENUS</h2>
  <div class="menu-card">
    <div class="menu-card-header">
      <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
          <a class="nav-link menu-title active" data-menu="dejeuner" onclick="afficherDescription('dejeuner')">Déjeuner</a>
        </li>
        <li class="nav-item">
          <a class="nav-link menu-title" data-menu="diner" onclick="afficherDescription('diner')">Dîner</a>
        </li>
        <li class="nav-item">
          <a class="nav-link menu-title" data-menu="enfant" onclick="afficherDescription('enfant')">Enfant</a>
        </li>
      </ul>
    </div>
    <div class="menu-card-body">
      <div id="description-dejeuner" class="menu-description">
        <p class="card-text">
          Entrée et plat <b>ou</b> plat et dessert - <b>30€</b><br>
          Salade de chèvre et sa figue <b>ou</b> salade de quinoa et ses légumes de saison<br>
          Tartines de la forêt <b>ou</b> camembert rôti dans son lit de pain<br>
          Cheesecake aux fruits rouges <b>ou</b> crémeux et son coulis de fruits rouges
        </p>
      </div>
      <div id="description-diner" class="menu-description" style="display: none;">
        <p class="card-text">
          Entrée et plat et dessert - <b>40€</b><br>
          Salade de chèvre et sa figue <b>ou</b> salade de quinoa et ses légumes de saison<br>
          Tartines de la forêt <b>ou</b> camembert rôti dans son lit de pain<br>
          Cheesecake aux fruits rouges <b>ou</b> crémeux et son coulis de fruits rouges
        </p>
      </div>
      <div id="description-enfant" class="menu-description" style="display: none;">
        <p class="card-text">
          Entrée et plat et dessert - <b>15€</b><br>
          Velouté de potiron maison<br>
          Filet de poulet, petits légumes<br>
          Sorbet fraise <b>ou</b> sorbet framboise
        </p>
      </div>
    </div>
  </div>
</div>


<!--Bouton Réserver-->
<div class="reserv container">
  <a href="reserver.php"><button type="button" class="btn btn-outline-success btn-reserve">Réserver</button></a>
</div>

<?php include('footer.php'); ?>