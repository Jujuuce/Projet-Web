<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $password = $data->password;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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

    $requete = $bdd->prepare('SELECT * FROM `Users` WHERE Users.login = :a');
    $requete->execute(array('a' => $username));
    $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

    $response = array();
    if (count($resultats) == 1) {
        $response['success'] = false;
        $response['message'] = 'Utilisateur déjà existant';
    } else {
        $requete = $bdd->prepare('INSERT INTO Users (login, password, connected, X, Y, orientation, lastConnection) VALUES (:a, :b, :c, 21, 5, :d, :e)');
        $requete->execute(array('a' => $username, 'b' => $hashedPassword, 'c' => 1, 'd' => 's', 'e' => time()));
        $response['success'] = true;
        $response['message'] = 'Inscription réussie';
        $_SESSION["login"] = $username;
    }

    echo json_encode($response);
}
