
function loginVerification() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    console.log("Username:", username);
    console.log("Password:", password);

    fetch('https://exemple.com/sauvegarder', {
        method: 'POST', headers: {'Content-Type': 'application/json',},
        body: JSON.stringify({ username: username, password: password, accept: false}),
    })
    .then(response => {
        
    })
    .catch(error => {
        console.error('Erreur :', error);
    });

}

window.onload = function() {
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();
        loginVerification();
    });
}