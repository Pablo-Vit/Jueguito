<?php
require_once("config.php");

function closeConnection($conn) {
    $conn->close();
}
?>
