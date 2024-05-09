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

    // Connexion à la base de données
    $dsn = 'mysql:host=localhost;dbname=dataBase_projet';
    $db_username = 'root';
    $db_password = '';
    $response = array();

    try {
        $bdd = new PDO($dsn, $db_username, $db_password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    $username = $_SESSION["login"];
    
    try {
        $requete = $bdd->prepare("UPDATE Users SET X = :a, Y = :b WHERE Users.login = :c");
        $requete->execute(array('a' => $x, 'b' => $y));
        $response['success'] = true;
        $response['message'] = '';
    } catch (PDOException $e) {
        $response['success'] = false;
        $response['message'] = 'Erreur : ' . $e->getMessage();
        echo json_encode($response);
        exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    echo json_encode($response);
}
