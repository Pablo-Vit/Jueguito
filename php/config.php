<?php
$hostname = "mysql.clawnhost.com";
$username = "pteras-user";
$password = "ClawN123";
$database = "Webadas";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>