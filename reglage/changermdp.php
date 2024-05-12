<?php
    session_start();
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>100x100 Grid</title>
    <link rel="stylesheet" href="../style.css">
    <script defer src="reglages.js"></script>
</head>
<body>
    <h1 class="formTitle">Changer le mot de passe</h1>
    <div id="container">
        <form id="newPass">
            <label for="username">Nouveau mot de passe :</label>
            <input type="text" id="username" name="username"/>
            <input id="submitBouton" type="submit"/>
            <div id="errorMessage"></div>
        </form>
        <a href="reglage.php">Revenir aux réglages</a>
        <a href="../accueil.php">Revenir à l'accueil</a>
    </div>
</body>
</html>