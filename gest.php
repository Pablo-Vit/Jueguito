<?php
session_start();

$id = $_SESSION["id"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["action"] === "SEND") {

        $r = array(
            "atr" => "val"
        );
        echo json_encode($r);
        exit;
    } elseif ($_POST["action"] === "FETCH") {
        $r = array(
            "atr" => "val"
        );
        echo json_encode($r);
        exit;
    }
?>