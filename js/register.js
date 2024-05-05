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
    const registerForm = document.getElementById("registerForm");

    registerForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const email = registerForm.querySelector('input[name="email"]').value;
        const user = registerForm.querySelector('input[name="username"]').value;
        const password = registerForm.querySelector('input[name="password"]').value;


        fetch("../api/register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `email=${encodeURIComponent(email)}&user=${encodeURIComponent(user)}&password=${encodeURIComponent(password)}`,
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