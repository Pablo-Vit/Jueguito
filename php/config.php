<?php
$hostname = "xtl.h.filess.io:3305";
$username = "cosas_inventedno";
$password = "788c813f1a6323733c2aad2320853c67d3dcf94d";
$database = "cosas_inventedno";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
