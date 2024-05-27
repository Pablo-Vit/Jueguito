fetch("../api/check-log.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    }
})
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.Logged == 0) {
            window.location.href = '../login/';
        } else {
            getInfo();
        }
    });

let game;
let move;
let mapa;
let myid;
let fetinter = -1;


if (!(game = localStorage.getItem("game"))) {
    window.location.href = '../';
}

function getInfo() {
    fetch("../api/game_getinfo.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `game=${encodeURIComponent(game)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.error == 0) {
                localStorage.removeItem('game');
                window.location.href = '../';
            }
            if (data.error == 1) {
                alert("La partida no existe");
                localStorage.removeItem('game');
                window.location.href = '../';
            }
            console.log(data);
            document.getElementById("title").innerText = 'Jugando: ' + data.name;
            move = data.move;
            let p = document.createElement("p");
            let rival = 'Tu oponente es: ' + (data.rival == null ? 'En espera..' : data.rival);
            p.innerText = rival;
            p.id = 'p-rival';
            p.className = 'p-rival';
            document.getElementById("info").appendChild(p);
            let fichas = document.createElement("p");
            fichas.className = "fichas";
            fichas.innerText = 'Fichas: ' + data.myf;
            fichas.id = 'fichas';
            document.getElementById("info").appendChild(fichas);
            let size = 1;
            if (data.mapa == 1) {
                size = 5;
            } else if (data.mapa == 2) {
                size = 9;
            } else if (data.mapa == 3) {
                size = 11;
            }
            myid = data.myid;
            mapa = data.mapinfo;
            genMap(size);
            if (move != -255) {
                if (data.turno) {
                    switchMap(true, size);
                } else {
                    if (fetinter != -1) {
                        clearInterval(fetinter);
                    }
                    fetinter = setInterval(() => {
                        fetchMap();
                    }, 500);
                }
            } else {
                checkWinner();
            }
        });
}

function genMap(size) {
    let map = document.createElement("div");
    map.className = "map";
    map.id = "map";
    let tab = document.createElement("table");
    tab.className = "tab-map";
    let inter = true;
    for (let i = 0; i < size; i++) {
        let nfil = document.createElement("tr");
        for (let j = 0; j < size; j++) {
            let ncol = document.createElement("td");
            if (mapa[i][j] != 0) {
                let img = document.createElement("img");
                let src = document.createAttribute("src");
                src.value = mapa[i][j] == myid ? "imgs/ficha1-1.png" : "imgs/ficha2-1.png";
                img.setAttributeNode(src);
                ncol.appendChild(img);
            }
            let id = i + '-' + j;
            ncol.className = inter ? "casA" : "casB";
            inter = !inter;
            ncol.id = id;
            let atr2 = document.createAttribute("name");
            atr2.value = `ptab`;
            ncol.setAttributeNode(atr2);
            nfil.appendChild(ncol);
        }
        tab.appendChild(nfil);
    }
    map.appendChild(tab);
    document.getElementById("divi").appendChild(map);
    console.log('Tablero Generado');
}

function switchMap(turno, size) {
    for (let i = 0; i < size; i++) {
        for (let j = 0; j < size; j++) {
            let id = i + '-' + j;
            if (mapa[i][j] == 0) {
                if (turno) {
                    if (!((move == 0) && ((i == 0 || i == size-1) && (j == 0 || j == size-1)))) {
                        let btn = document.createElement("button");
                        btn.className = 'cas';
                        btn.id = 'btn.' + id;
                        btn.innerText = 'X';
                        let atr = document.createAttribute("onclick");
                        atr.value = 'placeToken("' + id + '");';
                        btn.setAttributeNode(atr);
                        document.getElementById(id).innerHTML = '';
                        document.getElementById(id).appendChild(btn);    
                    }
                } else {
                    document.getElementById(id).innerHTML = '';
                }
            }
        }
    }
}

function placeToken(id) {
    let w = id.indexOf("-");
    let f = parseInt(id.slice(0, w));
    let c = parseInt(id.slice(w + 1));
    fetch("../api/play_move.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `game=${encodeURIComponent(game)}&posi=${encodeURIComponent(f)}&posj=${encodeURIComponent(c)}`
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.error == null) {
                document.getElementById(id).innerHTML = '<img src="imgs/ficha1-1.png" alt="Ficha propia" class="cas">';
                switchMap(false, mapa.length);
                editMap(data.map);
                fetchMap();
                move = data.move;
                if (move == -255) {
                    clearInterval(fetinter);
                    checkWinner();
                }
                if (fetinter == -1) {
                    fetinter = setInterval(() => {
                        fetchMap();
                    }, 500);
                }
                document.getElementById('fichas').innerText = 'Fichas: ' + data.myf;
            }
        });
}

function fetchMap() {
    fetch("../api/play_fetch.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `game=${encodeURIComponent(game)}&move=${encodeURIComponent(move)}`
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.error == null) {
                size = mapa.length;
                editMap(data.map);
                move = data.move;
                if (move == -255) {
                    clearInterval(fetinter);
                    checkWinner();
                }
                mapa = data.map;
                if (data.turno) {
                    clearInterval(fetinter);
                    fetinter = -1;
                    switchMap(true, mapa.length);
                } else if (fetinter == -1) {
                    fetinter = setInterval(() => {
                        fetchMap();
                    }, 500);
                }
            } else if (data.error == 0) {
                localStorage.removeItem('game');
                window.location.href = '../';
            }
            document.getElementById('fichas').innerText = 'Fichas: ' + data.myf;
        });
}

function editMap(mapnew) {
    size = mapnew.length;
    for (let i = 0; i < size; i++) {
        for (let j = 0; j < size; j++) {
            if (mapnew[i][j] != 0) {
                if (mapnew[i][j] != mapa[i][j]) {
                    if (mapa[i][j] == 0) {
                        color = mapnew[i][j] == myid ? 1 : 2;
                        document.getElementById(i + '-' + j).innerHTML = '<img src="imgs/ficha' + color + '-1.png" alt="" srcset="">';
                    } else {
                        changeColor(i, j);
                    }

                }
            }
        }
    }
}

function changeColor(y, x) {
    let color = mapa[y][x] == myid ? 1 : 2;
    let timer = 300;
    let cantsprites = 4;
    for (let i = 1; i <= cantsprites; i++) {
        setTimeout(() => {
            document.getElementById(y + '-' + x).innerHTML = '<img src="imgs/ficha' + color + '-' + i + '.png" alt="" srcset="">';
        }, timer * i);
    }
    setTimeout(() => {
        color = color == 1 ? 2 : 1;
        document.getElementById(y + '-' + x).innerHTML = '<img src="imgs/ficha' + color + '-1.png" alt="" srcset="">';
    }, timer * 5);
}

function checkWinner() {
    let f1 = 0;
    let f2 = 0;
    mapa.forEach(element => {
        element.forEach(e => {
            if (e != 0) {
                if (e == myid) {
                    f1++;
                } else {
                    f2++;
                }
            }
        });
    });
    let winner = f1 >= f2 ? true : false;
    console.log('f1: ' + f1);
    console.log('f2: ' + f2);
    document.getElementById("p-rival").innerText = winner ? 'Has ganado' : 'Has perdido';
}
function check() {
    let f1 = 0;
    let f2 = 0;
    for (let i = 0; i < mapa.length; i++) {
        for (let j = 0; j < mapa[i].length; j++) {
            if (mapa[i][j] == myid) {
                f1++;
            } else {
                f2++;
            }
        }
    }
    console.log('f1: ' + f1);
    console.log('f2: ' + f2);
}
