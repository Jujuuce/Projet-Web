<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $password = $data->password;

    $response = array();
    $response['success'] = true;
    $response['message'] = $username." ".$password;
    echo json_encode($response);
}
?>
