<?php
    session_start();
    
    if (!isset($_SESSION['login'])) {
        header('Location: /projet/login/login.php');
    }

    if (isset($_SERVER['HTTP_CACHE_CONTROL']) && (strpos($_SERVER['HTTP_CACHE_CONTROL'], 'no-cache') !== false || strpos($_SERVER['HTTP_CACHE_CONTROL'], 'max-age=0') !== false)) {
        unset($_SESSION['moment']);
    }

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

        try {
            $requete = $bdd->prepare('UPDATE Users SET Users.connected = 0 WHERE Users.login = :a');
            $requete->execute(array('a' => $_SESSION['login']));

            unset($_SESSION['login']);
            header('Location: /projet/login/login.php');
        } catch (PDOException $e) {
        
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJ Town</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <script defer src="map.js"></script>
</head>
<body>
    <div id="vitre"></div>
    <div id="JJ-town"><h1>JJ Town</h1></div>
    <div id="map">
        <div id="grid-container">
        </div>

        <div id="chat">

            <div id="logOutForm">
                <?php if(isset($_SESSION['login'])): ?>
                    <form method="post" class="formButton">
                        <input type="submit" name="logout" value="Déconnexion">
                    </form>
                <?php endif; ?>
                <form style="display: inline" action="reglage/reglage.php" method="get">
                  <button>Réglages</button>
                </form>
            </div>

            <div id="messageBox">
                <div id="messageOutput"></div>
            </div>
            <div id="messageInput">
                <form id="messagerie">
                    <textarea name="message" cols="25" rows="5" id="message" placeholder="Message"></textarea>
                    <input type="submit">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
