

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link href="libs/css/bootstrap.min.css" rel="stylesheet">
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
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                    <label class="form-check-label" for="rememberMe" style="padding-top:10px">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>

            <!-- Affichage du message d'erreur (s'il y en a un) -->
            <?php
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
          <label class="form-check-label" style="padding-top:10px">Vous n'avez pas de compte?</label>   <a href="inscription.php">S'inscrire</a></p>
        </div>
    </div>
    <?php
    session_start();
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure la configuration de la base de données et la classe User
    include_once "config/database.php";
    include_once "objects/user.php";

    // Initialiser la connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Initialiser l'objet User 
    $user = new User($db);

    // Récupérer les valeurs du formulaire
    $user->username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberMe']) ? true : false;
    // Vérifier les informations d'identification de l'utilisateur
// Vérifier les informations d'identification de l'utilisateur
if ($user->usernameExists()) {
    // Vérifier si le mot de passe est vide ou incorrect
    if (!empty($password)) {
        // Ajoutons un message de débogage pour voir si nous atteignons cette étape
    

       // ...
       if ($user->login($password)) { 
        
        // Ajoutons un message de débogage pour voir si nous entrons dans cette condition
        echo "Mot de passe correct. Connexion réussie.<br>";
        if ($rememberMe) {
            $cookie_name_username = "rememberedUsername";
            $cookie_name_password = "rememberedPassword";
    
            // Définissez les cookies pour se souvenir de l'utilisateur
            setcookie($cookie_name_username, $user->username, time() + (86400 * 30), "/"); // Cookie valide pendant 30 jours
            setcookie($cookie_name_password, $password, time() + (86400 * 30), "/");
            
            // Définissez également les valeurs dans la session
              
            $_SESSION['rememberedPassword'] = $password;
        } else {
            // Supprimez les cookies si l'utilisateur ne veut pas se souvenir
            setcookie("rememberedUsername", "", time() - 3600, "/");
            setcookie("rememberedPassword", "", time() - 3600, "/");
            // Supprimez également les valeurs de la session
            unset($_SESSION['rememberedUsername']);
            unset($_SESSION['rememberedPassword']);
        }
        $userType = $user->type;
        echo($userType);
        $_SESSION['rememberedUsername'] = $user->username; 

        if ($userType == 'client') 
            header("Location: products.php");
         else if ($userType == 'admin') 
            header("Location: adminPage.php");

    } else {
        // Ajoutons un message de débogage pour voir si nous entrons dans cette condition
        $error_message = "Mot de passe incorrect.";
    }
    
// ...

    } else {
        // Ajoutons un message de débogage pour voir si nous entrons dans cette condition
        echo "Mot de passe vide.<br>";
        $error_message = "Mot de passe incorrect.";
    }
} else {
    // Ajoutons un message de débogage pour voir si nous entrons dans cette condition
   
    $error_message = "Nom d'utilisateur incorrect.";
}

}
?>
    <!-- Ajoutez cela dans l'en-tête de votre page HTML -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Récupérez les informations des cookies
        var rememberedUsername = getCookie('rememberedUsername');
        var rememberedPassword = getCookie('rememberedPassword');

        // Pré-remplissez le formulaire si des informations sont présentes
        if (rememberedUsername) {
            document.getElementById('username').value = rememberedUsername;
        }
        if (rememberedPassword) {
            document.getElementById('password').value = rememberedPassword;
        }
    });

    // Fonction pour récupérer la valeur d'un cookie
    function getCookie(cookieName) {
        var name = cookieName + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(';');
        for(var i = 0; i <cookieArray.length; i++) {
            var cookie = cookieArray[i];
            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) == 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }
        return "";
    }
</script>

</body>
</html>




