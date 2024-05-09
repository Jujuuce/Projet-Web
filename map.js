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
var emplacement = document.getElementsByClassName('grid-cell');

function coordonnatesToNumber(x,y){
    return y * 54 + x
}

function numberToCoordonnates(nb) {
    var reste = nb % 54
    var res = [reste, (nb-reste)/54]
    return res;
}

/*
function deplacement(key) {
    if (key == "ArrowRight") {
        emplacement[coord].innerHTML = "";
        emplacement[coord + 1].innerHTML = '<p id="avatar"> Player </p><img src="P1/droite.png" id="player"/>';
        coord = coord + 1;
    } else if (key == "ArrowLeft") {
        emplacement[coord].innerHTML = "";
        emplacement[coord - 1].innerHTML = '<p id="avatar"> Player </p><img src="P1/gauche.png" id="player"/>';
        coord = coord - 1;
    } else if (key == "ArrowDown") {
        emplacement[coord].innerHTML = "";
        emplacement[coord + 54].innerHTML = '<p id="avatar"> Player </p><img src="P1/face.png" id="player"/>';
        coord = coord + 54;
    } else if (key == "ArrowUp") {
        emplacement[coord].innerHTML = "";
        emplacement[coord - 54].innerHTML = '<p id="avatar"> Player </p><img src="P1/dos.png" id="player"/>';
        coord = coord - 54;
    }
}
*/

function deplacement(key) {

    var temp = coord;
    if (key == "ArrowRight") {
        if (coord % 54 == 53) {
            return;
        }
        temp = coord + 1;
    } else if (key == "ArrowLeft") {
        if (coord % 54 == 0) {
            return;
        }
        temp = coord - 1;
    } else if (key == "ArrowDown") {
        if (coord >= 54*29) {
            return;
        }
        temp = coord + 54;
    } else if (key == "ArrowUp") {
        if (coord < 54) {
            return;
        }
        temp = coord - 54;
    }

    var coordonnees = numberToCoordonnates(temp);
    var x = coordonnees[0];
    var y = coordonnees[1];

    fetch("position.php", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({x: x, y: y})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de la requête Fetch.");
        }
        return response.json();
    })
    .then(content => {
        if (content["success"]) {
            emplacement[coord].innerHTML = "";
            coord = temp;
            emplacement[coord].innerHTML = '<p id="avatar"> Player </p><img src="P1/droite.png" id="player"/>';
            console.log("Position updated. X: " + x + " Y: " + y);
        } else {
            console.log(content["message"]);
        }
    })
}

function affichageJoueur() {
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
            console.log(content["users"]);
        }
    })
}

document.addEventListener('keydown', (event) => {
    var name = event.key;
    deplacement(name);
});

createGrid(30, 54);
setInterval(affichageJoueur, 1000);