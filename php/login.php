<?php
require_once("db_connection.php");
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $v = false;
    $id = 0;
    $sql = "SELECT id AS cant FROM users WHERE email = '$email';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sql = "SELECT id, email, password AS pass FROM users WHERE email = '$email';";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($row['pass'] == hash('fnv164',$password)) {
            $v = true;
            $id = $row['id'];
        } else {
            $r = array(
                "logged" => 0,
                "error" => 'Contraseña incorrecta'
            );
            echo json_encode($r);
        }
    } else {
        $r = array(
            "logged" => 0,
            "error" => 'Email no registrado'
        );
        echo json_encode($r);
    }
    if ($v) {
        $r = array(
            "logged" => 1
        );
        echo json_encode($r);
        $_SESSION["id"] = $id;
    }
    exit;
}
?>
