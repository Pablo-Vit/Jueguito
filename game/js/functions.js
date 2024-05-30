
fetch("../api/msg_new.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `cont=${encodeURIComponent("¡Gran Movimiento!")}&game=${encodeURIComponent('bmOvSF')}`
})
.then(response => response.json())
.then(data => {
    console.log(data);
})
.catch(error => {
    console.error(`Ocurrio un error ${error}`);
});

let act = '';
let cols = 3;
let fil = 3;

function genMap() {
    let map = document.createElement("div");
    map.className = "map";
    map.id = "map";
    let tab = document.createElement("table");
    tab.className = "tab-map";
    for (let i = 0; i < fil; i++) {
        let nfil = document.createElement("tr");
        for (let j = 0; j < cols; j++) {
            let ncol = document.createElement("td");
            let cas = document.createElement("button");
            let id = i + '-' + j;
            cas.className = "cas";
            ncol.className = "casd";
            ncol.id = id;
            let atr = document.createAttribute("onclick");
            atr.value = `reveal(` + i + `,` + j + `);`;
            cas.setAttributeNode(atr);
            ncol.appendChild(cas);
            nfil.appendChild(ncol);
        }
        tab.appendChild(nfil);
    }
    map.appendChild(tab);
    document.body.appendChild(map);
    console.log('Tablero Generado');
}

function reveal(f, c) {
    fetch("save.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `data=${encodeURIComponent(f + "-" + c)}`,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error(`Ocurrio un error ${error}`);
    });
}

function markMap() {
    fetch("fetch.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `last=${encodeURIComponent(moves)}`,
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.text != 'No hay nuevo click') {
                if (data.cant > moves) {
                    moves = data.cant;
                }
                if (data.move.length > 0) {
                    let id = data.move[0];
                    let w = id.indexOf("-");
                    let f = parseInt(id.slice(0,w));
                    let c = parseInt(id.slice(w+1));
                    try {
                        let aw = act.indexOf("-");
                        let af = parseInt(act.slice(0,aw));
                        let ac = parseInt(act.slice(aw+1));
                        document.getElementById(act).innerHTML = `<button class="cas" onclick="reveal(${af},${ac});"></button>`
                    } catch (error) {
                        console.log(`El error es: ${error}`)
                    }
                    document.getElementById(id).innerText = 'X';
                    act = id;
                    setTimeout(function () {
                        document.getElementById(id).innerHTML = `<button class="cas" onclick="reveal(${f},${c});"></button>`;
                    }, 1500);
                }
            }
        })
        .catch(error => {
            console.error(`Ocurrio un error ${error}`);
        });
}

function checkY(map, y) {
    return ((y >= 0) && (y < map.length)) ? true : false;
}

function checkX(map, x) {
    return ((x >= 0) && (x < map.length)) ? true : false;
}

function searchEnemy(map, pl1, pl2, y, x) {
    let r = [];
    for (let i = -1; i < 2; i++) {
        if (checkY(map, y+i)) {
            for (let j = -1; j < 2; j++) {
                if (checkY(map, x+j)) {
                    if (map[y+i][x+j] == pl2) {
                        if (tryConvertEnemy(map, pl1, y+i, x+j)) {
                            info = {
                                y : y+i,
                                x : x+j,
                                now : pl1
                            }
                            r.push(info)
                        }
                    }
                }
            }    
        }
    }
    return r;
}

function tryConvertEnemy(map, pl1, y, x) {
    let limiter = 0;
    for (let i = -1; i < 2; i++) {
        if (checkY(map, y+i)) {
            for (let j = -1; j < 2; j++) {
                if (checkY(map, x+j)) {
                    if (limiter == 4) {
                        return false;
                    }
                    limiter++;
                    let vy = y+i;
                    let vx = x+j;
                    let cy = y+(i*-1);
                    let cx = x+(j*-1);
                    if ((checkY(cy) && checkX(cx))) {
                        if ((map[vy][vx] == pl1) && (map[cy][cx] == pl1)) {
                            return true;   
                        }
                    }
                }
            }    
        }
    }
}