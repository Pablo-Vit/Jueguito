<?php
session_start();
require_once("funcs.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["id"])) {
        $game = $_POST["game"];
        $filename = '../games/' . $game . '.json';
        if(file_exists($filename)){
            if ($fp = fopen($filename, 'r')) {
                $r = array();
                $gdata = json_decode(fread($fp, filesize($filename)), true);
                if (($_SESSION["id"] == $gdata["pl1"]) || ($_SESSION["id"] == $gdata["pl2"])) {
                        $r = array(
                            "map" => $gdata["mapa"],
                            "turno" => $gdata["turno"] == $_SESSION["id"] ? true : false,
                            "move" => $gdata["move"],
                            "myf" => $gdata["pl1"] == $_SESSION["id"] ? $gdata["f1"] : $gdata["f2"]
                        );    
                }
                echo json_encode($r);
            }
        }
    }
}

