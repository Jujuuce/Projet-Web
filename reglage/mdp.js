function newPass() {

    var password = document.getElementById("pass").value;
    var password1 = document.getElementById("pass1").value;
    var messageBox = document.getElementById("errorMessage");
    messageBox.innerHTML = "";

    if (password == "" || password1 == "") {
        messageBox.innerHTML = "Veuillez remplir tous les champs";
        return;
    } 
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
            messageBox.innerHTML = data.message;
            window.location.replace("../index.php");
        } else {
            messageBox.innerHTML = data.message;
        }
    })
}

document.getElementById("newPass").addEventListener("submit", function(event) {
    event.preventDefault();
    newPass();
});
