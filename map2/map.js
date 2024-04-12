var coord = 50;

function createGrid(rows, cols) {
    var gridContainer = document.getElementById('grid');
    var gridHTML = '<div class="grid-container">';
    
    for (var i = 0; i < rows; i++) {
        for (var j = 0; j < cols; j++) {
            gridHTML += '<div class="grid-item">' + '' + '</div>';
        }
    }
    gridHTML += '</div>';
    gridContainer.innerHTML = gridHTML;
    emplacement[50].innerHTML = "0";
}

window.onload = function() {
    createGrid(10, 10);
};

var emplacement = document.getElementsByClassName('grid-item');

function deplacement(key) {
    fetch('changerPosition.php', {
        method: 'POST', 
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ key : key})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de l'envoi du message");
        }
        return response.json();
    })
    .then(data => {
            if (data.move == "ArrowRight") {
                emplacement[coord].innerHTML = "";
                emplacement[coord + 1].innerHTML = "0";
                coord = coord + 1;
            } else if (data.move == "ArrowLeft") {
                emplacement[coord].innerHTML = "";
                emplacement[coord - 1].innerHTML = "0";
                coord = coord - 1;
            } else if (data.move == "ArrowDown") {
                emplacement[coord].innerHTML = "";
                emplacement[coord + 10].innerHTML = "0";
                coord = coord + 10;
            } else if (data.move == "ArrowUp") {
                emplacement[coord].innerHTML = "";
                emplacement[coord - 10].innerHTML = "0";
                coord = coord - 10;
            }
        }
    )
    .catch(error => {
        console.error('Erreur:', error);
        alert("Une erreur s'est produite lors de la communication avec le serveur.");
    });
}

document.addEventListener('keydown', (event) => {
    var name = event.key;
    deplacement(name);
});
