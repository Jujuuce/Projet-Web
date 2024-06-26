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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JJ Town - Connexion</title>
	<link href="../style.css" rel="stylesheet" >
	<link rel="shortcut icon" type="image/png" href="../images/favicon.png">
	<script defer src="checkLogin.js"></script>
</head>
<body>
    <h1 class="formTitle">Connexion</h1>
    <div id="container">
        <form id="loginForm">
            <label for="username">Pseudo :</label>
            <input type="text" id="username" name="username">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password">
            <div id="errorMessage"></div>
            <input id="submitBouton" type="submit">
        </form>
        <a href="../signUp/signUpPage.php">Pas encore inscrit ?</a>
    </div>
</body>
</html>
