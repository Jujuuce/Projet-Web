<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $login = $data->login;

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
        $requete = $bdd->prepare('SELECT * FROM `Users` WHERE Users.login = :a');
        $requete->execute(array('a' => $login));
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        $response = array();
        if (count($resultats) == 1) {
            $response['success'] = false;
            $response['message'] = 'Utilisateur déjà existant';
        } else {
            $requete = $bdd->prepare('UPDATE Users SET login = :a WHERE login = :b');
            $requete->execute(array('a' => $login, 'b' => $_SESSION['login']));
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            $response['success'] = true;
            $response['message'] = 'Mot de passe modifié';
        }
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Erreur de modification : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    echo json_encode($response);
}
