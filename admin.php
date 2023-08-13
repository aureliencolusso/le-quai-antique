<?php
include('connexion_bdd.php');
include('header.php');
?>

<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
  <div class="container my-5 py-5">
    <div class="row">
      <div class="col-md-12 text-center">
        <h1 class="card-page-title">
          <span class="bodonimt">Administration</span>
        </h1>
        <div class="card-page-text">
          Bienvenue sur la plateforme d'administration du site du restaurant. Ici vous pouvez ajouter, modifier ou supprimer des images de la galerie, modifier les horaires d'ouverture du restaurant présentes dans le pied de page et supprimer des utilisateurs.
        </div>
        <div class="separator"></div>
      </div>
    </div>
  </div>
</section>


<!-- Message de confirmation -->
<section class="container" style="margin-top: -80px">
<?php if (isset($_GET['message'])) { ?>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="alert alert-success text-center" role="alert">
          <?php echo $_GET['message']; ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
</section>


<!-- Titre gestion de la galerie d'images -->
<section class="container text-center" style="margin-top: 120px">
  <div class="about" style="margin-bottom: 30px">Gestion de la galerie d'images</div>

  <!-- Tableau de gestion de la galerie d'images -->
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Titre</th>
          <th>Description</th>
          <th style="width: 150px;">Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Récupération de toutes les images de la galerie depuis la base de données
        $query = "SELECT * FROM gallery";
        $result = mysqli_query($connexion, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          $imageId = $row['id'];
          $title = $row['title'];
          $description = $row['description'];
          $imagePath = $row['image_path'];
        ?>
          <form action="admin.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="image_id" value="<?php echo $imageId; ?>" />
            <tr>
              <td>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>">
              </td>
              <td>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $row['description']; ?></textarea>
              </td>
              <td class="d-flex justify-content-center">
                <img src="<?php echo $imagePath; ?>" style="max-width: 100px; max-height: 100px;">
              </td>
              <td>
                <button type="submit" class="btn btn-primary" name="submit">Modifier</button>
                <a href="admin.php?action=delete&id=<?php echo $imageId; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">Supprimer</a>
              </td>
            </tr>
          </form>
        <?php
        }
        ?>
        <form action="admin.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action" value="insert" />
          <tr>
            <td>
              <input type="text" class="form-control" id="title" name="title">
            </td>
            <td>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </td>
            <td>
              <input class="form-control" type="file" id="image" name="image" required>
            </td>
            <td>
              <button type="submit" class="btn btn-primary" name="submit">Ajouter</button>
            </td>
          </tr>
        </form>
      </tbody>
    </table>
  </div>
</section>

<?php
// Vérifie si le formulaire d'ajout a été soumis
if (isset($_POST['action']) && $_POST['action'] === 'insert') {
  // Récupère les données du formulaire
  $title = $_POST['title'];
  $description = $_POST['description'];
  $image = $_FILES['image'];

  // Vérifie si une image a été sélectionnée
  if ($image['size'] > 0) {
    // Emplacement du dossier d'upload des images
    $uploadDirectory = 'assets/img/uploads/';

    // Génère un nom de fichier unique pour l'image
    $imageFileName = uniqid() . '_' . $image['name'];

    // Chemin complet de l'image
    $imagePath = $uploadDirectory . $imageFileName;

    // Déplace l'image téléchargée vers le dossier d'upload
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Insère les informations de l'image dans la base de données
    $query = "INSERT INTO gallery (title, description, image_path) VALUES ('$title', '$description', '$imagePath')";
    mysqli_query($connexion, $query);

    // Redirige vers la page d'administration après l'ajout
    $message = "L'image a été ajoutée avec succès à la galerie.";
    header('Location: admin.php?message=' . urlencode($message));
    exit();
  }
}

// Vérifie si le formulaire de modification a été soumis
if (isset($_POST['action']) && $_POST['action'] === 'update') {
  // Récupère les données du formulaire
  $imageId = $_POST['image_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $image = $_FILES['image'];

  // Vérifie si une nouvelle image a été sélectionnée
  if ($image['size'] > 0) {
    // Emplacement du dossier d'upload des images
    $uploadDirectory = 'assets/img/uploads/';

    // Génère un nom de fichier unique pour l'image
    $imageFileName = uniqid() . '_' . $image['name'];

    // Chemin complet de l'image
    $imagePath = $uploadDirectory . $imageFileName;

    // Déplace la nouvelle image téléchargée vers le dossier d'upload
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Met à jour les informations de l'image dans la base de données
    $query = "UPDATE gallery SET title='$title', description='$description', image_path='$imagePath' WHERE id='$imageId'";
    mysqli_query($connexion, $query);
  } else {
    // Met à jour seulement le titre et la description de l'image dans la base de données
    $query = "UPDATE gallery SET title='$title', description='$description' WHERE id='$imageId'";
    mysqli_query($connexion, $query);
  }

  // Redirige vers la page d'administration après la modification
  $message = "Les informations de la galerie ont été modifiées avec succès.";
  header('Location: admin.php?message=' . urlencode($message));
  exit();
}

// Vérifie si l'action est "supprimer" et récupère l'ID de l'image à supprimer
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
  // Récupère l'ID de l'image à supprimer
  $imageId = $_GET['id'];

  // Récupère le chemin de l'image depuis la base de données
  $query = "SELECT image_path FROM gallery WHERE id = $imageId";
  $result = mysqli_query($connexion, $query);
  $row = mysqli_fetch_assoc($result);

  // Supprime l'image du dossier d'upload
  $imagePath = $row['image_path'];
  unlink($imagePath);

  // Supprime l'image de la base de données
  $query = "DELETE FROM gallery WHERE id = $imageId";
  mysqli_query($connexion, $query);

  // Redirige vers la page d'administration après la suppression
  // Afficher un message de confirmation
  $message = "L'image a été supprimée avec succès de la galerie.";
  header('Location: admin.php?message=' . urlencode($message));
  exit();
}
?>


<!-- Séparateur -->
<div class="container">
  <div class="col-md-12">
    <div class="separator d-flex"></div>
  </div>
</div>


<!-- Section de gestion des horaires -->
<section class="container text-center">
  <div class="fav-dishes">Modifier les horaires</div>

  <!-- Tableau de gestion des horaires -->
  <div class="table-responsive">
    <table class="table table-bordered">
      <tr>
        <th style="width: 150px;">Jours</th>
        <th style="width: 150px;">Horaires</th>
        <th style="width: 150px;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Récupération des horaires existants depuis la base de données
      $query = "SELECT * FROM schedules";
      $result = mysqli_query($connexion, $query);
      $schedules = array();
      while ($row = mysqli_fetch_assoc($result)) {
          $day = $row['day'];
          $time = $row['time'];
          $schedules[$day] = $time;
      }

      // Affichage des champs pour chaque jour de la semaine
      foreach ($schedules as $day => $time) {
      ?>
        <tr>
          <td><?php echo ucfirst($day); ?></td>
          <td>
            <form action="admin.php" method="post">
              <div class="input-group">
              <input type="text" class="form-control" id="<?php echo $day; ?>" name="<?php echo $day; ?>" value="<?php echo $time; ?>">
              </div>
          </td>
          <td>
          <input type="hidden" name="action" value="update_schedule">
              <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
        </tr>
      <?php
      }
      ?>
      </form>
    </tbody>
  </table>
</div>
</section>

<?php
  if (isset($_POST['action']) && $_POST['action'] === 'update_schedule') {
    // Récupère les horaires modifiés depuis le formulaire
    $schedules = $_POST;

    // Met à jour les horaires dans la base de données
    foreach ($schedules as $day => $time) {
        $query = "UPDATE schedules SET time='$time' WHERE day='$day'";
        mysqli_query($connexion, $query);
    }

    // Redirige vers la page d'administration avec un message de confirmation
    $message = "Les horaires ont été modifiés avec succès.";
    header('Location: admin.php?message=' . urlencode($message));
    exit();
}
?>


<!-- Séparateur -->
<div class="container">
  <div class="col-md-12">
    <div class="separator d-flex"></div>
  </div>
</div>

<?php
// Vérifie si l'action est "supprimer" et récupère l'ID de l'utilisateur à supprimer
if (isset($_GET['action']) && $_GET['action'] === 'del' && isset($_GET['id'])) {
  // Récupère l'ID de l'utilisateur à supprimer
  $userId = $_GET['id'];

  // Supprime l'utilisateur de la base de données
  $query = "DELETE FROM users WHERE id = $userId";
  mysqli_query($connexion, $query);

  // Redirige vers la page d'administration après la suppression
  $message = "L'utilisateur a été supprimé avec succès.";
  header('Location: admin.php?message=' . urlencode($message));
  exit();
}
?>

<!-- Tableau des utilisateurs -->
<section class="container text-center">
  <div class="fav-dishes">Liste des Utilisateurs</div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Nom</th>
          <th>Numéro de téléphone</th>
          <th>Allergies</th>
          <th>Nombre d'invités</th>
          <th>Administrateur</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Récupération des utilisateurs depuis la base de données
        $query = "SELECT * FROM users";
        $result = mysqli_query($connexion, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $email = $row['email'];
          $name = $row['name'];
          $phone_number = $row['phone_number'];
          $allergies = $row['allergies'];
          $nb_guests = $row['nb_guests'];
          $is_admin = $row['is_admin'];
        ?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $phone_number; ?></td>
            <td><?php echo $allergies; ?></td>
            <td><?php echo $nb_guests; ?></td>
            <td><?php echo ($is_admin == 1) ? 'Oui' : 'Non'; ?></td>
            <td>
            <a href="admin.php?action=del&id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</section>


<?php
include('footer.php');
?>
