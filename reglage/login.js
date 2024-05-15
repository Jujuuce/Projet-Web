function newLogin() {

    var login = document.getElementById("login").value;
    var messageBox = document.getElementById("errorMessage");
    messageBox.innerHTML = "";

    fetch('EPnewLogin.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({login: login})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP, statut : ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.replace("../index.php");
        } else {
            messageBox.innerHTML = data.message;
        }
    })
}



document.getElementById("newLogin").addEventListener("submit", function(event) {
    event.preventDefault();
    newLogin();
});
