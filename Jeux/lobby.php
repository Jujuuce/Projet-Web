<?php

session_start();
$_SESSION = array();
session_destroy();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Le titre du projet</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Salle d'attente pour le jeu choisi</h1>
</body>
</html>
