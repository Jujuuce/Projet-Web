<?php
session_start();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $move = json_decode(file_get_contents("php://input"));
    $response['move'] = $move->key;
    echo json_encode($response);
}

?>