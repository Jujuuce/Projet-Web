<?php
session_start();

// Vérifier si la clé existe
if (!isset($_SESSION["login"])) {
    $data = array("session" => 0);
} else {
    $data = array("session" => $_SESSION["login"]);
}

$jsonData = json_encode($data);

header('Content-Type: application/json');

echo $jsonData;
?>