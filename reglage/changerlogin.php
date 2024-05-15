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
    <title>Changer de pseudo</title>
    <link rel="stylesheet" href="../style.css">
    <script defer src="login.js"></script>
</head>
<body>
    <h1 class="formTitle">Changer de pseudo</h1>
    <div id="container">
        <div class="retour">
            <a href="reglage.php"><img alt="Retour" src="../images/fleche_retour.png"></a>
        </div>
        <div class="quitter">
            <a href="../index.php"><img alt ="Retour à l'accueil" src="../images/croix.png"></a>
        </div>
        <form id="newLogin">
            <label for="login">Nouveau pseudo :</label>
            <input type="text" id="login" name="login">
            <input id="submitBouton" type="submit">
            <div id="errorMessage"></div>
        </form>
    </div>
</body>
</html>
