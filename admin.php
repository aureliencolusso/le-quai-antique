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
        $stmt = $connexion->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>">
              </td>
              <td>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($row['description']); ?></textarea>
              </td>
              <td class="d-flex justify-content-center">
                <img src="<?php echo htmlspecialchars($imagePath); ?>" style="max-width: 100px; max-height: 100px;">
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
  $title = $_POST['title'];
  $description = $_POST['description'];
  $image = $_FILES['image'];

  // Vérifie la taille de l'image
  if ($image['size'] > 0) {
    $uploadDirectory = 'assets/img/uploads/';
    $imageFileName = uniqid() . '_' . $image['name'];
    $imagePath = $uploadDirectory . $imageFileName;

    // Déplace l'image téléchargée vers le répertoire de destination
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Prépare et exécute la requête d'insertion dans la base de données
    $query = "INSERT INTO gallery (title, description, image_path) VALUES (?, ?, ?)";
    $stmt = $connexion->prepare($query);
    $stmt->execute([$title, $description, $imagePath]);

    $message = "L'image a été ajoutée avec succès à la galerie.";
    header('Location: admin.php?message=' . urlencode($message));
    exit();
  }
}

// Vérifie si le formulaire de mise à jour a été soumis
if (isset($_POST['action']) && $_POST['action'] === 'update') {
  $imageId = $_POST['image_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $image = $_FILES['image'];

  // Vérifie la taille de l'image
  if ($image['size'] > 0) {
    $uploadDirectory = 'assets/img/uploads/';
    $imageFileName = uniqid() . '_' . $image['name'];
    $imagePath = $uploadDirectory . $imageFileName;

    // Déplace l'image téléchargée vers le répertoire de destination
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Prépare et exécute la requête de mise à jour dans la base de données avec l'image
    $query = "UPDATE gallery SET title=?, description=?, image_path=? WHERE id=?";
    $stmt = $connexion->prepare($query);
    $stmt->execute([$title, $description, $imagePath, $imageId]);
  } else {
    // Prépare et exécute la requête de mise à jour dans la base de données sans l'image
    $query = "UPDATE gallery SET title=?, description=? WHERE id=?";
    $stmt = $connexion->prepare($query);
    $stmt->execute([$title, $description, $imageId]);
  }

  $message = "Les informations de la galerie ont été modifiées avec succès.";
  header('Location: admin.php?message=' . urlencode($message));
  exit();
}

// Vérifie si l'action de suppression a été demandée et si l'ID de l'image est spécifié
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
  $imageId = $_GET['id'];

  // Récupère le chemin de l'image à partir de la base de données
  $query = "SELECT image_path FROM gallery WHERE id = ?";
  $stmt = $connexion->prepare($query);
  $stmt->execute([$imageId]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Supprime l'image du serveur
  $imagePath = $row['image_path'];
  unlink($imagePath);

  // Supprime l'enregistrement de l'image de la base de données
  $query = "DELETE FROM gallery WHERE id = ?";
  $stmt = $connexion->prepare($query);
  $stmt->execute([$imageId]);

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
        $stmt = $connexion->query($query);
        $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des champs pour chaque jour de la semaine
        foreach ($schedules as $schedule) {
          $day = $schedule['day'];
          $time = $schedule['time'];
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
            </td>
          </tr>
          </form>
        <?php
        }
        ?>
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
    $query = "UPDATE schedules SET time=:time WHERE day=:day";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':day', $day);
    $stmt->execute();
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
  $userId = $_GET['id'];

  // Supprime l'utilisateur de la base de données
  $query = "DELETE FROM users WHERE id = :userId";
  $stmt = $connexion->prepare($query);
  $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
  $stmt->execute();

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
        $stmt = $connexion->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
