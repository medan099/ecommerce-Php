<?php
// Inclure le fichier de connexion à la base de données
include_once "config/database.php";

// Inclure la classe User
include_once "objects/user.php";



// Initialiser la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Initialiser l'objet User 
$user = new User($db);

// Définir les variables pour stocker les données du formulaire
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Traiter le formulaire lors de sa soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valider le nom d'utilisateur
    if (empty(trim($_POST["username"]))) {
        $username_err = "Veuillez entrer un nom d'utilisateur.";
    } else {
        // Vérifier si le nom d'utilisateur existe déjà
        if ($user->usernameExists(trim($_POST["username"]))) {
            $username_err = "Ce nom d'utilisateur est déjà pris.";
        } else {
            $username = trim($_POST["username"]);
        }
    }

    // Valider le mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Valider la confirmation du mot de passe
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Les mots de passe ne correspondent pas.";
        }
    }

    // Si aucune erreur, ajouter l'utilisateur à la base de données
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $user->username = $username;
        $user->password = $password;

        if ($user->create()) {
            // Rediriger vers la page de connexion après l'inscription
            header("location: login.php");
            exit();
        } else {
            echo "Une erreur s'est produite. Veuillez réessayer plus tard.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- Inclure les fichiers CSS nécessaires ici -->
        <!-- Bootstrap CSS -->
        <link href="libs/css/bootstrap.min.css" rel="stylesheet" media="screen">


<!-- custom css for users -->
<link href="libs/css/user.css" rel="stylesheet" media="screen">
<style>
        body {
            background-image: url('taiwan.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #ffffff;
            margin: 0; /* Ajout d'une marge zéro pour éliminer les marges par défaut du corps */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
        }

        .login-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-form label {
            font-weight: bold;
            color: #000000;
        }

        .login-form button {
            width: 100%;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
        <div class="login-form">
            <!-- Formulaire d'authentification -->
            <form method="post" action="/php-project/inscription.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                    <span class="error"></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                    <span class="error"></span>

                </div>
                <div class="mb-3 form-check">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe:</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" required="">
                <span class="error"></span>
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
            <label class="form-check-label" style="padding-top:10px">Vous avez déjà un compte?</label> <a href="login.php">Connectez-vous ici</a>.</p>
        </div>

            <!-- Affichage du message d'erreur (s'il y en a un) -->
            <?php
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
        </div>
    </div>

    <!-- Inclure les fichiers JavaScript nécessaires ici -->

</body>
</html>
