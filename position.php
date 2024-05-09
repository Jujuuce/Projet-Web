<?php

session_start();
if (isset($_SESSION[""]) && $_SESSION[""]) {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $y = $data->y;
    $x = $data->x;
    $orient = $data->orient;

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
        $requete = $bdd->prepare("UPDATE Users SET X = :a, Y = :b, orientation = :d WHERE Users.login = :c");
        $requete->execute(array('a' => $x, 'b' => $y, 'c' => $username, 'd' => $orient));
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

    try {
        $bdd = new PDO($dsn, $db_username, $db_password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $response['users'] = false;
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    try {
        $requete = $bdd->prepare('SELECT * FROM `Users` WHERE Users.connected = :a');
        $requete->execute(array('a' => 1));

        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        $positions = array();

        for ($i = 0; $i < count($resultats); $i++) {
            $pos = $resultats[$i];
            $user = $pos['login'];
            $x = $pos['X'];
            $y = $pos['Y'];
            $orient = $pos['orientation'];
            $positions[$i] = [$user, $x, $y, $orient];
        }
        
        $response['users'] = $positions;
        $response['success'] = true;
        $response['message'] = 'ok';

    } catch (PDOException $e) {
        $response['users'] = false;
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    echo json_encode($response);

}
