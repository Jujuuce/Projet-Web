function loginVerification() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var messageBox = document.getElementById("errorMessage");
    messageBox.innerHTML = "";

    // Check if username or password is empty
    if (username === '' || password === '') {
        messageBox.innerHTML = "Veuillez remplir tous les champs.";
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
            window.location.replace("/projet/index.php");
        } else {
            console.error(data.message);
            messageBox.innerHTML = data.message;
        }
    })
}

document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    loginVerification();
});
