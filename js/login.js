fetch("../api/check-log.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    }
})
.then(response => response.json())
.then(data => {
    console.log(data);
    if (data.Logged == 1) {
        window.location.href = '../';     
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const email = loginForm.querySelector('input[name="email"]').value;
        const password = loginForm.querySelector('input[name="password"]').value;

        // Aquí podrías realizar la validación de los campos

        // Enviar los datos al servidor para autenticación
        fetch("../api/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.logged == 1) {
                window.location.href = "../";
            } else {
                alert("Ha ocurrido un error: " + data.error);
            }
        })
        .catch(error => {
            console.error("Error en la solicitud:", error);
        });
    });
});
