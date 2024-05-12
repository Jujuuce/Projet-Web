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
            window.alert("Login modifié");
            window.location.replace("../accueil.php");
        } else {
            console.error(data.message);
        }
    })
}



document.getElementById("newLogin").addEventListener("submit", function(event) {
    event.preventDefault();
    newLogin();
});