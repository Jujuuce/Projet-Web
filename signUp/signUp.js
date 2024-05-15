function signUp() {

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var password2 = document.getElementById("password2").value;
    var messageBox = document.getElementById("errorMessage");
    messageBox.innerHTML = "";

    if (username === '' || password === '' || password2 === '') {
        console.error('Username and password are required.');
        messageBox.innerHTML = "Veuillez remplir tous les champs.";
        return;
    }

    if (password !== password2) {
        console.error("Les mots de passe ne correspondent pas");
        messageBox.innerHTML = "Les mots de passe ne correspondent pas";
        return;
    }

    fetch('signUp.php', {
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
        } else {
            messageBox.innerHTML = data.message;
        }
    })
}

document.getElementById("signUpForm").addEventListener("submit", function(event) {
    event.preventDefault();
    signUp();
});
