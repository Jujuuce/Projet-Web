<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $password = $data->password;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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
        id INT AUTO_INCREMENT PRIMARY KEY,
        user VARCHAR(255) NOT NULL,
        heure VARCHAR(255) NOT NULL,
        mess VARCHAR(255) NOT NULL
    )");

    // Vérifier si l'utilisateur existe déjà
    $requete = $bdd->prepare('SELECT * FROM `Users` WHERE Users.login = :a');
    $requete->execute(array('a' => $username));
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

    $response = array();
    if (count($resultats) == 1) {
        $response['success'] = false;
        $response['message'] = 'Utilisateur déjà existant';
    } else {
        // Insérer l'utilisateur dans la base de données
        $requete = $bdd->prepare('INSERT INTO Users (login, password, connected, X, Y, orientation, lastConnection) VALUES (:a, :b, :c, 21, 5, :d, :e)');
        $requete->execute(array('a' => $username, 'b' => $hashedPassword, 'c' => 1, 'd' => 's', 'e' => time()));
        $response['success'] = true;
        $response['message'] = 'Inscription réussie';
        $_SESSION["login"] = $username;
    }

    echo json_encode($response);
}
