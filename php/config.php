<?php
$hostname = "yby.h.filess.io:3307";
$username = "cosas_readyorder";
$password = "209a93af41d02b54f23720770e8e241db7987158";
$database = "cosas_readyorder";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
