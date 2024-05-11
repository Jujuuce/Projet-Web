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

function createGrid(x,y) {
    const gridContainer = document.getElementById('grid-container');
    for (let i = 0; i < x; i++) {
        for (let j = 0; j < y; j++) {
            const gridCell = document.createElement('div');
            gridCell.className = 'grid-cell';
            gridContainer.appendChild(gridCell);
        }
    }
}

var coord = 0;
var start = true;
var place = document.getElementsByClassName('grid-cell');
var positionUsers = {};

function coordonnatesToNumber(x,y){
    return y * 120 + x
}

function numberToCoordonnates(nb) {
    var reste = nb % 120
    var res = [reste, (nb-reste)/120]
    return res;
}

function deplacement(key) {

    var orient = 's';
    var temp = coord;
    if (key == "ArrowRight") {
        if (coord % 120 == 119) {
            return;
        }
        temp = coord + 1;
        orient = 'e';
    } else if (key == "ArrowLeft") {
        if (coord % 120 == 0) {
            return;
        }
        temp = coord - 1;
        orient = 'w';
    } else if (key == "ArrowDown") {
        if (coord >= 120*80) {
            return;
        }
        temp = coord + 120;
        orient = 's';
    } else if (key == "ArrowUp") {
        if (coord < 120) {
            return;
        }
        temp = coord - 120;
        orient = 'n';
    }

    var coordonnees = numberToCoordonnates(temp);
    var x = coordonnees[0];
    var y = coordonnees[1];

    fetch("position.php", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({x: x, y: y, orient: orient})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de la requête Fetch.");
        }
        return response.json();
    })
    .then(content => {
        if (content["success"]) {
            place[coord].innerHTML = "";
            coord = temp;
            console.log("Position updated. X: " + x + " Y: " + y);
        } else {
            console.log(content["message"]);
        }
    })
}

createGrid(80, 120);

function affichageJoueur(name, x, y, orient) {
    var place = document.getElementsByClassName('grid-cell');
    var nb = coordonnatesToNumber(x,y);
    if (orient == 'n') {
        place[nb].innerHTML = '<p class="avatar">' + name + '</p><img src="P1/dos.png" class="player"/>';
    } else if (orient == 's') {
        place[nb].innerHTML = '<p class="avatar">' + name + '</p><img src="P1/face.png" class="player"/>';
    } else if (orient == 'w') {
        place[nb].innerHTML = '<p class="avatar">' + name + '</p><img src="P1/gauche.png" class="player"/>';
    } else {
        place[nb].innerHTML = '<p class="avatar">' + name + '</p><img src="P1/droite.png" class="player"/>';
    }
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
            for (var key in positionUsers) {
                place[positionUsers[key]].innerHTML = "";
            }
            positionUsers = {};
            for (let i = 0; i < content["users"].length; i++) {
                positionUsers[content["users"][i][0]] = coordonnatesToNumber(content["users"][i][1],content["users"][i][2]);
                affichageJoueur(content["users"][i][0],content["users"][i][1],content["users"][i][2],content["users"][i][3]);
                if (start && content["users"][i][4] == 1) {
                    coord = coordonnatesToNumber(content["users"][i][1],content["users"][i][2])
                    start = false;
                }
            }
        }
    })
}

function afficherText(text) {
    var area = document.getElementById("messageOutput");
    if (text != "") {
        area.innerHTML = area.innerHTML + text;
    }
}

function affichageMessages() {
    fetch("messagerie.php", {
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


function ticTac () {
    affichageJoueurs();
    affichageMessages();
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