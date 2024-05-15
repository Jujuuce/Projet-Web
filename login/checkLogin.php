<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $password = $data->password;

    // Connexion au serveur MySQL
    $dsn = 'mysql:host=localhost';
    $db_username = 'root';
    $db_password = '';

    try {
        $bdd = new PDO($dsn, $db_username, $db_password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Erreur de connexion au serveur MySQL : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    // Vérifier si la base de données existe, sinon la créer
    $dbname = 'dataBase_projet';
    $requete = $bdd->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");
    $resultat = $requete->fetchColumn();
    if ($resultat == 0) {
        $bdd->exec("CREATE DATABASE $dbname");
    }

    // Sélectionner la base de données
    $bdd = new PDO("mysql:host=localhost;dbname=$dbname", $db_username, $db_password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créer la table Users si elle n'existe pas
    $bdd->exec("CREATE TABLE IF NOT EXISTS Users (
        login VARCHAR(255) PRIMARY KEY,
        password VARCHAR(255) NOT NULL,
        connected INT NOT NULL DEFAULT 0,
        X INT NOT NULL DEFAULT 0,
        Y INT NOT NULL DEFAULT 0,
        orientation VARCHAR(255) NOT NULL,
        lastConnection INT DEFAULT NULL
    )");

    // Créer la table messages si elle n'existe pas
    $bdd->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT,
        user VARCHAR(255) NOT NULL,
        heure VARCHAR(255) NOT NULL,
        mess VARCHAR(255) NOT NULL,
        PRIMARY KEY (id, user),
        FOREIGN KEY (user) REFERENCES Users(login) ON DELETE CASCADE ON UPDATE CASCADE
    )");    

    $requete = $bdd->prepare('SELECT * FROM `Users` WHERE Users.login = :a');
    $requete->execute(array('a' => $username));
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

    $response = array();
    if (count($resultats) == 1 && $resultats[0]["connected"] == 0 && password_verify($password, $resultats[0]["password"])) {
        $response['success'] = true;
        $response['message'] = 'Connexion reussie';
        $_SESSION["login"] = $username;
        $requete = $bdd->prepare('UPDATE Users SET Users.connected = 1, Users.lastConnection = :a WHERE Users.login = :b');
        $requete->execute(array('a' => time(), 'b' => $username));
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    } else if (count($resultats) == 1 && $resultats[0]["connected"] == 1 && password_verify($password, $resultats[0]["password"])) {
        $response["success"] = false;
        $response["message"] = "Utilisateur déjà connecté";
    } else {
        $response["success"] = false;
        $response["message"] = "Utilisateur ou mot de passe incorrect";
    }
    
    try {
        $requete = $bdd->prepare('UPDATE Users SET Users.connected = 0 WHERE Users.lastConnection < :a');
        $requete->execute(array('a' => time() - 1));
    } catch (PDOException $e) {
        
    }

    echo json_encode($response);
}