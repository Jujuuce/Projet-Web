<?php
    session_start();
    if(isset($_SESSION['login'])){
        header('Location: ../accueil.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JJ Town - Connexion</title>
	<link href="../style.css" rel="stylesheet" >
	<script defer type="text/javascript" src="checkLogin.js" defer></script>
</head>
<body>
    <h1 class="formTitle">Connexion</h1>
    <div id="container">
        <form id="loginForm">
            <label for="username">Pseudo :</label>
            <input type="text" id="username" name="username"/>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password"/>
            <input id="submitBouton" type="submit"/>
            <div id="errorMessage"></div>
        </form>
        <a href="../signUp/signUpPage.php">Pas encore inscrit ?</a>
    </div>
</body>
</html>