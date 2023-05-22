<?php
include('connexion_bdd.php');
include('header.php') ?>


<!--Titres-->
<section class="banner d-flex justify-content-center align-items-center pt-5">
    <div class="container my-5 py-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="card-page-title">
                    <span class="bodonimt">Administration</span>
                </h1>
                <div class="card-page-text">
                    Bienvenue sur la plateforme d'administration du site du restaurant. Ici vous pouvez ajouter, modifier ou supprimer des images de la galerie et également modifier les horaires d'ouverture du restaurant présentes dans le pied de page.
                </div>
                <div class="separator"></div>
            </div>
        </div>
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
    $message = "Les informations de l'image ont été modifiées avec succès.";
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

// Vérifie si l'action est "edit_schedule"
if (isset($_GET['action']) && $_GET['action'] === 'edit_schedule') {
    // Récupère les horaires existants depuis la base de données
    $query = "SELECT * FROM schedules";
    $result = mysqli_query($connexion, $query);
    $schedules = array();

    // Parcourt les horaires et stocke-les dans un tableau
    while ($row = mysqli_fetch_assoc($result)) {
        $day = $row['day'];
        $time = $row['time'];
        $schedules[$day] = $time;
    }
?>

    <h2>Modifier les horaires</h2>

    <form action="admin.php" method="post">
        <?php
        // Affiche les champs pour chaque jour de la semaine
        foreach ($schedules as $day => $time) {
        ?>
            <div class="mb-3">
                <label for="<?php echo $day; ?>" class="form-label"><?php echo ucfirst($day); ?></label>
                <input type="text" class="form-control" id="<?php echo $day; ?>" name="<?php echo $day; ?>" value="<?php echo $time; ?>">
            </div>
        <?php
        }
        ?>

        <input type="hidden" name="action" value="update_schedule">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

<?php
} elseif (isset($_POST['action']) && $_POST['action'] === 'update_schedule') {
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

<?php
// Vérifie si l'action est "ajouter" et affiche le formulaire d'ajout
if (isset($_GET['action']) && $_GET['action'] === 'add') {
?>
    <section class="register-form py-5">
        <div class="container">
            <h3>Ajouter une image à la galerie</h3>
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="insert" />
                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control" type="file" id="image" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Ajouter</button>
            </form>
        </div>
    </section>
<?php
}
?>

<?php
// Vérifie si l'action est "modifier" et affiche le formulaire de modification
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    // Récupère l'ID de l'image à modifier
    $imageId = $_GET['id'];

    // Récupère les informations de l'image depuis la base de données
    $query = "SELECT * FROM gallery WHERE id = $imageId";
    $result = mysqli_query($connexion, $query);
    $row = mysqli_fetch_assoc($result);
?>
    <section class="register-form py-5">
        <div class="container">
            <h3 class="h3">Modifier l'image de la galerie</h3>
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="image_id" value="<?php echo $imageId; ?>" />
                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $row['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control" type="file" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Modifier</button>
            </form>
        </div>
    </section>
<?php
}
?>


<!-- Affichage du message de confirmation -->
<?php if (isset($_GET['message'])) { ?>
    <div class="alert alert-success"><?php echo $_GET['message']; ?></div>
<?php } ?>

<?php include('footer.php'); ?>