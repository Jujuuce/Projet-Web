<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header('Location: ../login/login.php');
    }
    
    if (isset($_POST['delete'])) {
        $dsn = 'mysql:host=localhost;dbname=dataBase_projet';
        $db_username = 'root';
        $db_password = '';
    
        try {
            $bdd = new PDO($dsn, $db_username, $db_password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
        }

        $requete = $bdd->prepare('DELETE FROM Users WHERE Users.login = :a');
        $requete->execute(array('a' => $_SESSION['login']));

        unset($_SESSION['login']);
        header('Location: ../index.php');
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png">
</head>
<body>
    <h1 class="formTitle">Paramètres</h1>
    <div class="quitter">
        <a href="../index.php"><img alt ="Retour à l'accueil" src="../images/croix.png"></a>
    </div>
    <div id="reglages">
        <form style="display: inline" action="changerlogin.php" method="get">
          <button>Modifier le pseudo</button>
        </form>
        <form style="display: inline" action="changermdp.php" method="get">
          <button>Modifier le mot de passe</button>
        </form>
        <?php if(isset($_SESSION['login'])): ?>
            <form method="post" class="formButton">
                <input type="submit" name="delete" value="Supprimer le compte">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
