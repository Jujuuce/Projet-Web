<?php
    session_start();
    if (isset($_SESSION['moment'])){
        unset($_SESSION['moment']);
    }
    if(isset($_SESSION['login'])){
        header('Location: ../index.php');
    } 
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>JJ Town - Inscription</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
    <script defer src="signUp.js"></script>
</head>
<body>
    <h1 class="formTitle">Inscription</h1>
    <div id="container">
        <form id="signUpForm">
            <label for="username">Pseudo :</label>
            <input type="text" id="username" name="username">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password">
            <label for="password2">Confirmer le mot de passe :</label>
            <input type="password" id="password2" name="password2">
            <div id="errorMessage"></div>
            <input id="submitBouton" type="submit">
        </form>
        <a href="../login/login.php">Déjà inscrit ?</a>
    </div>
</body>
</html>
