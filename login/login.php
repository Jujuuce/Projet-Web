<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST["login"];
    $password = $_POST["password"];

    $serveur = 'localhost';
    $utilisateur = 'votre_utilisateur';
    $motdepasse = 'votre_mot_de_passe';
    $base_de_donnees = 'votre_base_de_donnees';

    try {
        $connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $motdepasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = $connexion->prepare("SELECT * FROM Users WHERE Users.login = $login");
        $requete->execute();
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultats as $utilisateur) {
            echo "ID: " . $utilisateur['id'] . ", Login: " . $utilisateur['login'] . ", Mot de passe: " . $utilisateur['motdepasse'] . "<br>";
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de connexion
        echo "Erreur de connexion : " . $e->getMessage();
    }
    
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="../style.css" rel="stylesheet" >
	<script type="text/javascript" src="checkLogin.js" defer></script>
</head>
<body>
	<div id="connectionBox">
        <form id="loginForm">
            <label for="username">Username :</label>
            <input type="text" id="username" name="username"/>
            <label for="password">Password :</label>
            <input type="text" id="password" name="password"/>
            <input id="submitBouton" type="submit"/>
        </form>
    </div>
</body>
</html>