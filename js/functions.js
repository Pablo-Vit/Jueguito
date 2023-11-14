fetch("php/check-log.php")
.then(response => response.json())
.then(data => {
    console.log(data);
    if (data.Logged == 0) {
        window.location.href = 'login/';     
    }
});