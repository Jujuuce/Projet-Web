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
    <script defer src="mdp.js"></script>
</head>
<body>
    <h1 class="formTitle">Changer le mot de passe</h1>
    <div id="container">
        <form id="newPass">
            <label for="pass">Nouveau mot de passe :</label>
            <input type="text" id="pass" name="pass"/>
            <label for="pass1">Confirmer nouveau mot de passe :</label>
            <input type="text" id="pass1" name="pass1"/>
            <input id="submitBouton" type="submit"/>
            <div id="errorMessage"></div>
        </form>
        <a href="reglage.php">Revenir aux réglages</a>
        <a href="../accueil.php">Revenir à l'accueil</a>
    </div>
</body>
</html>
