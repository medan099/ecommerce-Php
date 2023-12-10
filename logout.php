<?php
// Initialiser la session
// logout.php

// Démarrez la session (si ce n'est pas déjà fait)
session_start();

// Récupérez les informations de l'utilisateur avant de détruire la session
$rememberedUsername = isset($_SESSION['rememberedUsername']) ? $_SESSION['rememberedUsername'] : '';
$rememberedPassword = isset($_SESSION['rememberedPassword']) ? $_SESSION['rememberedPassword'] : '';

// Détruisez la session existante
session_destroy();

// Créez des cookies pour se souvenir de l'utilisateur
if (!empty($rememberedUsername)) {
    setcookie('rememberedUsername', $rememberedUsername, time() + (86400 * 30), "/"); // valable pendant 30 jours
}
if (!empty($rememberedPassword)) {
    setcookie('rememberedPassword', $rememberedPassword, time() + (86400 * 30), "/"); // valable pendant 30 jours
}

// Redirigez vers la page de connexion
header("Location: login.php");
exit();
?>
