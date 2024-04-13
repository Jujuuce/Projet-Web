function noCorespondingPassword() {
    console.error("Les mots de passe ne correspondent pas");
    // Afficher un message d'erreur à l'utilisateur
    
}

function signUp() {

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var password2 = document.getElementById("password2").value;

    if (password !== password2) {
        console.error("Les mots de passe ne correspondent pas");
        // Afficher un message d'erreur à l'utilisateur
        return;
    }

    fetch('checkLogin.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({username: username, password: password})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP, statut : ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.replace("/projet/accueil.php");
            // Rediriger ou effectuer d'autres actions pour les utilisateurs authentifiés
        } else {
            // Échec de l'authentification
            console.error(data.message);
            // Afficher un message d'erreur à l'utilisateur
        }
    })
}

window.onload = function() {
    document.getElementById("signUpForm").addEventListener("submit", function(event) {
        event.preventDefault();
        signUp();
    });
}