<?php
require_once("funcs.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gamename = generateRandomString(6);
    $filename = '../games/' . $gamename . '.json';
    if (!$fp = fopen($filename, 'w')) {
        $r = array(
            "error" => 'Codigo error 1, contacta al creador y dile este codigo.'
        );
        echo json_encode($r);
        exit;
    } else {
        $games = "games.json";
        $handle = fopen($games, "c+");
        fseek($handle, 0);
        $data = json_decode(fread($handle, filesize($games)), true);
        array_push($data["currentgames"], $gamename);
        ftruncate($handle,0);
        fseek($handle, 0);
        if (fwrite($handle, json_encode($data)) === FALSE) {
            $r = array(
                "error" => 'Codigo error 4, contacta al creador y dile este codigo.'
            );
            echo json_encode($r);
            exit;
        }
        fclose($handle);        
    }
    $gname = $_POST["name"];
    $gpass = $_POST["pass"];
    $gsize = $_POST["size"];
    $game = array(
        "name" => $gname,
        "pass" => $gpass,
        "turno" => 0,
        "move" => 0,
        "pl1" => (int) $_SESSION["id"],
        "pl2" => -1,
        "f1" => 1,
        "f2" => 1,
        "mapa" => array(),
        "chat" => array()
    );
    $arrA = array();
    $arrV = array();
    $map = array();
    if ($gsize == 1) {
        $game["f1"] = 8;
        $game["f2"] = 8;
        for ($i=0; $i < 5; $i++) { 
            $f = array();
            for ($j=0; $j < 5; $j++) { 
                array_push($f, 0);
            }
            array_push($map,$f);
        }
    } elseif ($gsize == 2) {
        $game["f1"] = 30;
        $game["f2"] = 30;
        for ($i=0; $i < 9; $i++) { 
            $f = array();
            for ($j=0; $j < 9; $j++) { 
                array_push($f, 0);
            }
            array_push($map,$f);
        }
    } elseif ($gsize == 3) {
        $game["f1"] = 45;
        $game["f2"] = 45;
        for ($i=0; $i < 11; $i++) { 
            $f = array();
            for ($j=0; $j < 11; $j++) { 
                array_push($f, 0);
            }
            array_push($map,$f);
        }
    }
    $game["mapa"] = $map;
    // guardando $game en su json
    if (fwrite($fp, json_encode($game)) === FALSE) {
        $r = array(
            "error" => 'Codigo error 2, contacta al creador y dile este codigo.'
        );
        echo json_encode($r);
        exit;
    }
    $r = array(
        "msg" => 'hecho',
        "game" => $gamename
    );
    echo json_encode($r);
    fclose($fp);
}