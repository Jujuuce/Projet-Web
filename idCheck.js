function checkID() {
    fetch("idCheck.php", { 
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
            window.location.replace("/projet/login/login.html");
        }
    })
    .catch(error => {
        console.error('Erreur lors de la récupération des données :', error);
    });
}

checkID();
