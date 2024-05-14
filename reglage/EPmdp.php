<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
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

    $response = array();
    try {
        $requete = $bdd->prepare('UPDATE Users SET password = :a WHERE login = :b');
        $requete->execute(array('a' => $hashedPassword, 'b' => $_SESSION['login']));
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
        $response['success'] = true;
        $response['message'] = 'Mot de passe modifié';
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Erreur de modification : ' . $e->getMessage();
    }

    echo json_encode($response);
}
