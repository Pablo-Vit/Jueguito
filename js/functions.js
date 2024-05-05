fetch("api/check-log.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    }
})
.then(response => response.json())
.then(data => {
    console.log(data);
    if (data.Logged == 0) {
        window.location.href = 'login/';
    }
    else {
        document.getElementById("username").innerText = "Conectado como: " + data.name;
        fetchGames();
        fetchOldGames();
        fetchFinishedGames();
    }
});

function createForm() {
    document.getElementById("gestbtns").remove();
    busc = document.getElementById("busc");
    busc.innerHTML = `<form id="creategameform" action="api/game_create.php" method="post">
    <input type="text" name="gname" id="name" placeholder="Nombre de la partida">
    <input type="password" name="gpass" id="pass" placeholder="Contraseña (vacio = publica)">
    <select name="gsize" id="size">
        <option value=0>Tamaño</option>
        <option value=1>Pequeño</option>
        <option value=2>Mediano</option>
        <option value=3>Grande</option>
    </select>
    <button>Crear Partida</button>
</form>` + busc.innerHTML;
    const createform = document.getElementById("creategameform");
    createform.addEventListener("submit", function (event) {
        event.preventDefault();

        const name = createform.querySelector('input[name="gname"]').value;
        const pass = createform.querySelector('input[name="gpass"]').value;
        const size = parseInt(createform.querySelector('select[name="gsize"]').value);
        error = false;
        emsg = '';
        if (size == 0) {
            error = true;
            emsg += 'Seleccione un tamaño\n';
        }
        if (name.length < 1) {
            error = true;
            emsg += 'Ingrese un nombre para la partida\n';
        }
        if (error) {
            alert(emsg);
        } else {
            fetch("api/game_create.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `name=${encodeURIComponent(name)}&pass=${encodeURIComponent(pass)}&size=${encodeURIComponent(size)}`
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.msg == 'hecho') {
                    localStorage.setItem("game", data.game);
                    window.location.href = 'game/';
                }
            })
            .catch(error => {
                console.error("Error en la solicitud:", error);
            });
        }
    });
}

function fetchGames(){
    fetch("api/game_fetch_n.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        document.getElementById("tbusc").innerHTML = '';
        a = document.getElementById("tbusc");
        a.innerHTML += `<tr>
        <td class="busc-td">Nombre</td>
        <td class="busc-td">Privacidad</td>
        <td class="busc-td">Tamaño</td>
        <td class="busc-td"><button onclick="fetchGames();" style="background-color: lime; border-radius: 3px;">Recargar</button></td>
        </tr>`;
        data.forEach(element => {
            let tr = document.createElement("tr");
            let atr2 = document.createAttribute("name");
            atr2.value = `trgame`;
            tr.setAttributeNode(atr2);
            let gname = document.createElement("td");
            gname.innerText = element.name;
            let gpriv = document.createElement("td");
            gpriv.className = "priv";
            gpriv.innerText = element.priv ? '🔒' : '📖';
            let gsize = document.createElement("td");
            if (element.mapa == 1) {
                gsize.innerText = 'Pequeño';
            } else if (element.mapa == 2) {
                gsize.innerText = 'Mediano';
            } else if (element.mapa == 3) {
                gsize.innerText = 'Grande';
            }
            let gbtn = document.createElement("button");
            let atr = document.createAttribute("onclick");
            atr.value = `tryGame('` + element.id + `',`+ element.priv +`);`;
            gbtn.setAttributeNode(atr);
            gbtn.innerText = 'Entrar'
            gbtn.id = 'enter'+ element.id;
            let btntd = document.createElement("td");
            btntd.appendChild(gbtn);
            tr.appendChild(gname);
            tr.appendChild(gpriv);
            tr.appendChild(gsize);
            tr.appendChild(btntd);
            a.appendChild(tr);
        });
    });
}

function fetchOldGames(){
    fetch("api/game_fetch_s.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        a = document.getElementById("startedbusc");
        data.forEach(element => {
            let tr = document.createElement("tr");
            let atr2 = document.createAttribute("name");
            atr2.value = `trgame`;
            tr.setAttributeNode(atr2);
            let gname = document.createElement("td");
            gname.innerText = element.name;
            
            gsize = document.createElement("td");
            if (element.mapa == 1) {
                gsize.innerText = 'Pequeño';
            } else if (element.mapa == 2) {
                gsize.innerText = 'Mediano';
            } else if (element.mapa == 3) {
                gsize.innerText = 'Grande';
            }
            let gstatus = document.createElement("td");
            gstatus.innerText = element.status;
            let gbtn = document.createElement("button");
            let atr = document.createAttribute("onclick");
            atr.value = `enterStartedGame('` + element.id + `');`;
            gbtn.setAttributeNode(atr);
            gbtn.innerText = 'Entrar'
            gbtn.id = 'enter'+ element.id;
            let btntd = document.createElement("td");
            btntd.appendChild(gbtn);
            tr.appendChild(gname);
            tr.appendChild(gsize);
            tr.appendChild(gstatus);
            tr.appendChild(btntd);
            a.appendChild(tr);
        });
    });
}

function fetchFinishedGames(){
    fetch("api/game_fetch_f.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        a = document.getElementById("finishedbusc");
        data.forEach(element => {
            let tr = document.createElement("tr");
            let gname = document.createElement("td");
            gname.innerText = element.name;
            let gbtn = document.createElement("button");
            let atr = document.createAttribute("onclick");
            atr.value = `enterStartedGame('` + element.id + `');`;
            gbtn.setAttributeNode(atr);
            gbtn.innerText = 'Entrar'
            gbtn.id = 'enter'+ element.id;
            let btntd = document.createElement("td");
            btntd.appendChild(gbtn);
            tr.appendChild(gname);
            tr.appendChild(btntd);
            a.appendChild(tr);
        });
    });
}

function joinGame(){
    document.getElementById("gestbtns").remove();
    document.getElementById("busc").innerHTML = `<form action="" id="busc-form">
    <input type="text" name="buscid" id="busc-id" placeholder="Ingrese el codigo" required>
    <input type="text" name="buscpass" id="busc-pass" placeholder="Contraseña">
    <button id="busc-btn">Ingresar</button>
</form>` + document.getElementById("busc").innerHTML;

}

function tryGame(id, priv = false) {
    if (priv) {
        document.getElementById("gestbtns").innerHTML = `<input placeholder="Contraseña" type="password" name="gpass" id="gpass">
        <button onclick="enterGame('`+id+`', document.getElementById('gpass').value)">Entrar</button>`;
    } else {
        enterGame(id);
    }
}

function enterGame(id, pass = ''){
    console.log(id,':',pass);
    fetch("api/trygame.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `game=${encodeURIComponent(id)}&pass=${encodeURIComponent(pass)}`
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.error != null) {
            alert(data.error)
        } else {
            if (data.isin) {
                localStorage.setItem("game",id);
                window.location.href = 'game/';
            }
        }
    });
}

function enterStartedGame(id) {
    localStorage.setItem("game", id);
    window.location.href = 'game/';
}