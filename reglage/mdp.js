function checkID() {
    fetch("../idCheck.php", { 
        method: 'GET',
        headers: {'Content-Type': 'application/json;charset=utf-8'}
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de la requête Fetch.");
        }
        return response.json();
    })
    .then(content => {
        if (content["session"] == 0) {
            window.location.replace("../login/login.php");
        }
    })
    .catch(error => {
        console.error('Erreur lors de la récupération des données :', error);
    });
}

checkID();

function newPass() {

    var password = document.getElementById("pass").value;
    var password1 = document.getElementById("pass1").value;
    var messageBox = document.getElementById("errorMessage");
    messageBox.innerHTML = "";

    if (password !== password1) {
        console.error("Les mots de passe ne correspondent pas");
        messageBox.innerHTML = "Les mots de passe ne correspondent pas";
        return;
    }

    fetch('EPmdp.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({password: password})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP, statut : ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.alert("Mot de passe modifié");
            window.location.replace("../accueil.php");
        } else {
            console.error(data.message);
        }
    })
}

document.getElementById("newPass").addEventListener("submit", function(event) {
    event.preventDefault();
    newPass();
});