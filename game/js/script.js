let cols = 3;
let fil = 3;
let moves = 0;
let act = '';

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
            setTimeout(markMap, 300);
        })
        .catch(error => {
            console.error(`Ocurrio un error ${error}`);
        });
}

genMap();
markMap();

