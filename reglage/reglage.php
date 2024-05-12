<?php
    session_start();

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
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        unset($_SESSION['login']);
        header('Location: /projet/login/login.php');
    }
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
<h1 class="formTitle">Paramètres</h1>
    <div id="reglages">
        <a href="changermdp.php"><button>Modifier l'identifiant</button></a>
        <a href="changerlogin.php"><button>Modifier le mot de passe</button></a>
        <?php if(isset($_SESSION['login'])): ?>
            <form method="post" class="formButton">
                <input type="submit" name="delete" value="Supprimer le compte">
            </form>
        <?php endif; ?>
        <a href="../accueil.php">Revenir à l'accueil</a>
    </div>
</body>
</html>
