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

function reveal(f,c) {
    
}

genMap();


