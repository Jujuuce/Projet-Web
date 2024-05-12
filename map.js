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
            window.location.replace("/projet/login/login.php");
        }
    })
    .catch(error => {
        console.error('Erreur lors de la récupération des données :', error);
    });
}

checkID();

var coordx = 1;
var coordy = 1;
var L = 59;
var H = 35;
var tailleCellule = 25.6;
var start = true;
var carte = document.getElementById("grid-container");

function deplacement(key) {
    var orient = 's';
    if (key == "ArrowRight") {
        if (coordx < L - 1) coordx = coordx + 1;
        orient = 'e';
    } else if (key == "ArrowLeft") {
        if (coordx > 0) coordx = coordx - 1;
        orient = 'w';
    } else if (key == "ArrowDown") {
        if (coordy < H - 1) coordy = coordy + 1;
        orient = 's';
    } else if (key == "ArrowUp") {
        if (coordy > 0) coordy = coordy - 1;
        orient = 'n';
    }

    fetch("position.php", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({coordx: coordx * tailleCellule, coordy: coordy * tailleCellule, orient: orient})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de la requête Fetch.");
        }
        return response.json();
    })
    .then(content => {
        if (content["success"]) {
            console.log("Position updated. X: " + coordx + " Y: " + coordy);
        } else {
            console.log(content["message"]);
        }
    })
}


function affichageJoueur(name, orient) {
    var temp = "";
    if (orient == 'n') {
        temp = temp + "<div id='" + name + "' class='users'><p class='avatar'>" + name + "</p><img src='P1/dos.png'/></div>"
    } else if (orient == 's') {
        temp = temp + "<div id='" + name + "' class='users'><p class='avatar'>" + name + "</p><img src='P1/face.png'/></div>"
    } else if (orient == 'w') {
        temp = temp + "<div id='" + name + "' class='users'><p class='avatar'>" + name + "</p><img src='P1/gauche.png'/></div>"
    } else {
        temp = temp + "<div id='" + name + "' class='users'><p class='avatar'>" + name + "</p><img src='P1/droite.png'/></div>"
    }
    return temp;
}



function affichageJoueurs() {
    fetch("position.php", {
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
        if (content["success"]) {
            carte.innerHTML = "<img src=\"pokemon4.png\" alt=\"map\" class=\"map\"/>";
            var temp = "";
            for (let i = 0; i < content["users"].length; i++) {
                if (start && content["users"][i][4] == 1) {
                    coordx = content["users"][i][1];
                    coordy = content["users"][i][2];
                    start = false;
                }
                temp = temp + affichageJoueur(content["users"][i][0],content["users"][i][3])
            }
            carte.innerHTML += temp;
            for (let i = 0; i < content["users"].length; i++) {
                var affich = document.getElementById(content["users"][i][0]);
                affich.style.top = content["users"][i][2] + "px";
                affich.style.left = content["users"][i][1] + "px";
            }
        }
    })
}

var area = document.getElementById("messageOutput");

function afficherText(text) {
    if (text != "") {
        area.innerHTML = area.innerHTML + text;
    }
}

function affichageMessages(temp) {
    const queryParams = new URLSearchParams({ temp }).toString();
    fetch(`messagerie.php?${queryParams}`, {
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
        if (content["success"]) {
            var text = '';
            for (let i = 0; i < content["allMessages"].length; i++) {
                text = text + content["allMessages"][i];
            }
            afficherText(text);
        }
    })
}

function message() {

    var message = document.getElementById("message").value;
    document.getElementById("message").value = "";
    if (message  != "") {
        fetch('messagerie.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({message : message})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur HTTP, statut : ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log("Message envoyé");
            } else {
                console.error(data.message);
            }
        })
    }
}


document.getElementById("messagerie").addEventListener("submit", function(event) {
    event.preventDefault();
    message();
});



document.addEventListener('keydown', (event) => {
    var name = event.key;
    if (start == false && (name == "ArrowRight" || name == "ArrowLeft" || name == "ArrowDown" || name == "ArrowUp")) {
        deplacement(name);
    }
});


affichageMessages(1);

function ticTac () {
    affichageJoueurs();
    affichageMessages(0);
}



setInterval(ticTac, 50);


function submitOnEnter(event) {
    if (event.which === 13) {
        if (!event.repeat) {
            const newEvent = new Event("submit", {cancelable: true});
            event.target.form.dispatchEvent(newEvent);
        }
        event.preventDefault(); // Prevents the addition of a new line in the text field
    }
}

document.getElementById("message").addEventListener("keydown", submitOnEnter);
