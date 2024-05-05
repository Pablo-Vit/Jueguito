<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["id"])) {
        $r = array(
            "Logged" => 0
        );
        echo json_encode($r);
        exit;
    } else {
        $r = array(
            "Logged" => 1,
            "name" => $_SESSION["name"]
        );
        echo json_encode($r);
    }
}

?>