<?php

session_start();
if (isset($_SESSION[""]) && $_SESSION[""]) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $message = $data->message;
    $timestamp = time();
    $time = date("d F Y h:i:s", $timestamp);

    // Connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=dataBase_projet';
    $db_username = 'root';
    $db_password = '';
    $response = array();
    $username = $_SESSION["login"];

    try {
        $bdd = new PDO($dsn, $db_username, $db_password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    try {
        $requete = $bdd->prepare("INSERT INTO messages (user, heure, mess) VALUES (:a, :b, :c)");
        $requete->execute(array('a' => $username, 'b' => $time, 'c' => $message));
        $response['success'] = true;
        $response['message'] = 'ok';
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    echo json_encode($response);
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=dataBase_projet';
    $db_username = 'root';
    $db_password = '';
    $response = array();
    $moment = $_SESSION["moment"];

    try {
        $bdd = new PDO($dsn, $db_username, $db_password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $response['allMessages'] = false;
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    try {
        $requete = $bdd->prepare('SELECT * FROM `messages` WHERE messages.id >= :a');
        $requete->execute(array('a' => $moment));

        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        $allMessages = array();

        for ($i = 0; $i < count($resultats); $i++) {
            $temp = $resultats[$i];
            $user = $temp['user'];
            $heure = $temp['heure'];
            $mess = $temp['mess'];
            $allMessages[$i] = $user . ' at ' . $heure . ' : ' . $mess . '\n';
        }
        
        $response['allMessages'] = $allMessages;
        $response['success'] = true;
        $response['message'] = 'ok';

    } catch (PDOException $e) {
        $response['allMessages'] = false;
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    echo json_encode($response);

}