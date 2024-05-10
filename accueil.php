<?php
    session_start();
    
    if(isset($_POST['logout'])) {
        // Connexion à la base de données
        $dsn = 'mysql:host=localhost;dbname=dataBase_projet';
        $db_username = 'root';
        $db_password = '';

        try {
            $bdd = new PDO($dsn, $db_username, $db_password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $response['success'] = false;
            $response['message'] = 'Erreur de connexion : ' . $e->getMessage();
            echo json_encode($response);
            exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
        }

        $requete = $bdd->prepare('UPDATE Users SET Users.connected = 0 WHERE Users.login = :a');
        $requete->execute(array('a' => $_SESSION['login']));
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        unset($_SESSION['login']);
    }

    if(isset($_POST['delete'])) {
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
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>100x100 Grid</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="map.js"></script>
</head>
<body>
    <div id="map">
        <div id="grid-container"></div>

        <div id="chat">

            <div id="logOutForm">
                <?php if(isset($_SESSION['login'])): ?>
                    <form method="post">
                        <input type="submit" name="logout" value="Déconnexion">
                    </form>
                <?php endif; ?>
                <?php if(isset($_SESSION['login'])): ?>
                    <form method="post">
                        <input type="submit" name="delete" value="Supprimer le compte">
                    </form>
                <?php endif; ?>
            </div>

            <div id="messageBox">
                <div id="messageOutput">
                </div>
            </div>
            <div id="messageInput">
                <form id="messagerie">
                    <input name="message" id="message" type="text" />
                    <button type="submit">></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
