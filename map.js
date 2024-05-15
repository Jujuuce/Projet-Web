var carte = document.getElementById("grid-container");
var coordx = 1;
var coordy = 1;
var orient = 's';
var L = 60;
var H = 34;
var largeurCellule = carte.offsetWidth / L;
var hauteurCellule = carte.offsetHeight / H;
var largeurOffset = -largeurCellule/8;
var hauteurOffset = -1.2*hauteurCellule/2;
var start = true;
var pseudo = "";

function deplacement(key) {
    var tempx = coordx;
    var tempy = coordy;
    if (key == "ArrowRight") {
        tempx = tempx + 1;
        orient = 'e';
    } else if (key == "ArrowLeft") {
        tempx = tempx - 1;
        orient = 'w';
    } else if (key == "ArrowDown") {
        tempy = tempy + 1;
        orient = 's';
    } else if (key == "ArrowUp") {
        tempy = tempy - 1;
        orient = 'n';
    }

    fetch("position.php", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({coordx: tempx, coordy: tempy, orient: orient})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de la requête Fetch.");
        }
        return response.json();
    })
    .then(content => {
        if (content["success"]) {
            if (content["message"] == "yes") {
                coordx = tempx;
                coordy = tempy;
                console.log("Position updated. X: " + coordx + " Y: " + coordy);
            } else if (content["message"] == "tp") {
                coordx = content["x"];
                coordy = content["y"];
                console.log("Position updated. X: " + coordx + " Y: " + coordy);
            }
        } else {
            console.log(content["message"]);
        }
    })
}


function affichageJoueur(name, orient, modeUser) {
    var avatar = "</div><div class='avatar'>&nbsp;" + name + "&nbsp;</div>";
    if (modeUser) avatar = "<div class='avatarUser'>&nbsp;" + name + "&nbsp;</div>";
    if (orient == 'n') {
        temp = "<div id='" + name + "' class='users'>" + avatar + "<img class=\"perso\" src='P1/dos.png'/></div>"
    } else if (orient == 's') {
        temp = "<div id='" + name + "' class='users'>" + avatar + "<img class=\"perso\" src='P1/face.png'/></div>"
    } else if (orient == 'w') {
        temp = "<div id='" + name + "' class='users'>" + avatar + "<img class=\"perso\" src='P1/gauche.png'/></div>"
    } else {
        temp = "<div id='" + name + "' class='users'>" + avatar + "<img class=\"perso\" src='P1/droite.png'/></div>"
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
            carte.innerHTML = "<img src=\"pokemon4.png\" alt=\"map\" class=\"map\"/><img src=\"calque.png\" alt=\"map\" id=\"calque\"/>";
            for (let i = 0; i < content["users"].length; i++) {
                if (start && content["users"][i][4] == 1) {
                    coordx = content["users"][i][1];
                    coordy = content["users"][i][2];
                    pseudo = content["pseudo"];
                    start = false;
                }
                carte.innerHTML += affichageJoueur(content["users"][i][0],content["users"][i][3], content["users"][i][4]);
            }
            for (let i = 0; i < content["users"].length; i++) {
                var affich = document.getElementById(content["users"][i][0]);
                affich.style.top = content["users"][i][2]*hauteurCellule + hauteurOffset + "px";
                affich.style.left = content["users"][i][1]*largeurCellule + largeurOffset + "px";
                affich.style.width = 1.2*largeurCellule + "px";
                affich.style.height = 1.2*hauteurCellule + "px";
                var perso = document.getElementsByClassName("perso")[i];
                perso.style.width = largeurCellule + "px";
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
    var focusedElement = document.activeElement;
    if (focusedElement.tagName !== 'TEXTAREA') {
        var name = event.key;
        if (!start && (name == "ArrowRight" || name == "ArrowLeft" || name == "ArrowDown" || name == "ArrowUp")) {
            deplacement(name);
        }
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