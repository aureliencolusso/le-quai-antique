Bonjour, voici le guide d'exécution en local de l'application web "Le Quai Antique" !
Assurez-vous de suivre ces étapes pour configurer correctement l'environnement de développement.


Prérequis :
Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

PHP (version 8.2.6 ou supérieure)
MySQL (version 5.7.24 ou supérieure)
Un serveur web local (par exemple, Apache)


Étapes d'installation :

1. Clonez ce référentiel GitHub sur votre machine locale :
git clone https://github.com/votre-utilisateur/nom-du-repo.git

2. Importez la base de données :
Ouvrez votre client MySQL et connectez-vous à votre serveur de base de données.
Créez une nouvelle base de données pour l'application.
Importez le fichier de sauvegarde de la base de données (lequaiantique.sql) dans votre base de données nouvellement créée.

3. Configuration de la connexion à la base de données :
Ouvrez le fichier (connexion_bdd.php) dans le répertoire de votre application.
Modifiez les paramètres de connexion ($host, $username, $password, $dbname) pour correspondre à votre configuration MySQL.

4. Créez un administrateur pour le back-office :
Ouvrez votre client MySQL et connectez-vous à votre serveur de base de données.
Accédez à la base de données de l'application.
Exécutez une requête SQL pour insérer les informations de l'administrateur :
INSERT INTO users (email, password, name, phone_number, allergies, nb_guests, is_admin) VALUES ('exemple@admin.fr', 'motdepasse', 'Admin', '0000000000', 'aucune', '0', 1);

5. Démarrez le serveur web local :
Assurez-vous que votre serveur web local (par exemple, Apache) est en cours d'exécution.
Placez le contenu de l'application web dans le répertoire approprié pour que le serveur web puisse y accéder.

6. Accédez à l'application :
Ouvrez votre navigateur et accédez à l'URL locale correspondante à votre environnement de développement (par exemple, http://localhost/lequaiantique/index.php).

Vous devriez maintenant voir l'application web en cours d'exécution.


Accès au back-office :
Une fois l'application web exécutée localement, vous pouvez accéder au back-office en tant qu'administrateur en suivant ces étapes :

Accédez à la page de connexion du back-office en ajoutant /login.php à l'URL de l'application (par exemple, http://localhost/lequaiantique/login.php).

Utilisez les informations d'identification du compte "admin" que vous avez crée auparavant pour vous connecter :

Email : [email de l'administrateur que vous avez créé lors de l'étape 4 de l'installation]
Mot de passe : [mot de passe de l'administrateur que vous avez créé lors de l'étape 4 de l'installation]

Une fois connecté, vous trouverez sur la page d'accueil (index.php) les différentes fonctionnalités réservées à l'administrateur, telles que la gestion de la galerie où vous pourrez ajouter, modifier ou supprimer des images, des titres et des descriptions. Vous trouverez également la possibilité de modifier les horaires du restaurant.

Ensuite, n'hésitez pas à vous déconnecter du compte administrateur en cliquant sur le bouton "Déconnecter" dans votre profil afin de pouvoir créer d'autres utilisateurs classiques grâce au formulaire d'inscription qui se trouve dans la barre de navigation ou en tapant "/register.php" dans l'URL.

Vous pourrez également créer des réservations et retrouver le récapitulatif sur la page de confirmation, où vous aurez la possibilité de les supprimer. Si vous êtes connecté à votre compte utilisateur ou administrateur, les informations de l'utilisateur seront préremplies par défaut dans le formulaire de réservation.

Merci d'avoir consulté ce fichier README. J'espère que ces informations vous ont été utiles pour comprendre et utiliser mon application. Si vous avez des questions supplémentaires ou rencontrez des problèmes, n'hésitez pas à me contacter.
Je suis disponible pour vous aider et améliorer votre expérience avec mon application.

Bonne utilisation !

Halozor.