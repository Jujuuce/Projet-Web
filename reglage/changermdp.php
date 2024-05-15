<?php
    session_start();
    
    if (!isset($_SESSION['login'])) {
        header('Location: ../login/login.php');
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chnager le mot de passe</title>
    <link rel="stylesheet" href="../style.css">
    <script defer src="mdp.js"></script>
</head>
<body>
    <h1 class="formTitle">Changer le mot de passe</h1>
    <div id="container">
        <div class="retour">
            <a href="reglage.php"><img alt="Retour" src="../fleche_retour.png"></a>
        </div>
        <div class="quitter">
            <a href="../accueil.php"><img alt="Retour à l'accueil" src="../croix.png"></a>
        </div>
        <form id="newPass">
            <label for="pass">Nouveau mot de passe :</label>
            <input type="password" id="pass" name="pass">
            <label for="pass1">Confirmer nouveau mot de passe :</label>
            <input type="password" id="pass1" name="pass1">
            <input id="submitBouton" type="submit">
            <div id="errorMessage"></div>
        </form>
    </>
</body>
</html>
