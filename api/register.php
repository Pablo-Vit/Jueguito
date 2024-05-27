<?php
require_once("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $user = $_POST["user"];
    $password = $_POST["password"];
    $v = false;
    $sql = "SELECT id FROM users WHERE username = '$user'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $r = array(
            "logged" => 0,
            "error" => 'El usuario ya existe'
        );
        echo json_encode($r);
    } else {
        $v = true;
    }
    $sql = "SELECT id FROM users WHERE email = '$email';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $r = array(
            "logged" => 0,
            "error" => 'El email ya existe'
        );
        echo json_encode($r);
    } else {
        if ($v) {
            $passhashed = hash('fnv164',$password);
            $sql = "INSERT INTO `users`(`id`, `username`, `email`, `password`, `created_at`) VALUES ('0','$user','$email','$passhashed',NOW());";
            $result = $conn->query($sql);
            $r = array(
                "logged" => 1
            );
            echo json_encode($r);
        }
    }

    exit;
}
