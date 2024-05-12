<?php
    session_start();
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJ Town réglages</title>
    <link rel="stylesheet" href="../style.css">
    <script defer src="login.js"></script>
</head>
<body>
    <h1 class="formTitle">Changer l'identifiant</h1>
    <div id="container">
        <form id="newLogin">
            <label for="login">Nouveau pseudo :</label>
            <input type="text" id="login" name="login"/>
            <input id="submitBouton" type="submit"/>
            <div id="errorMessage"></div>
        </form>
        <a href="reglage.php">Revenir aux réglages</a>
        <a href="../accueil.php">Revenir à l'accueil</a>
    </div>
</body>
</html>
