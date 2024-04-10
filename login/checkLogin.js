function loginVerification() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Check if username or password is empty
    if (username === '' || password === '') {
        console.error('Username and password are required.');
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
            // Authentification réussie
            console.log(data.message);
            // Rediriger ou effectuer d'autres actions pour les utilisateurs authentifiés
        } else {
            // Échec de l'authentification
            console.error(data.message);
            // Afficher un message d'erreur à l'utilisateur
        }
    })
}

window.onload = function() {
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();
        loginVerification();
    });
}