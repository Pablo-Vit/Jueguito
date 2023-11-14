<?php
session_start();

if (!isset($_SESSION["id"])) {
    $r = array(
        "Logged" => 0
    );
    echo json_encode($r);
    exit;
} else {
    $r = array(
        "Logged" => 1
    );
    echo json_encode($r);
}


?>