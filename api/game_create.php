<?php
require_once("funcs.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gamename = generateRandomString(6);
    $filename = '../games/' . $gamename . '.json';
    // Let's make sure the file exists and is writable first.
    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$fp = fopen($filename, 'w')) {
        $r = array(
            "error" => 'Codigo de error 1, contacta al creador y dile este codigo.'
        );
        echo json_encode($r);
        exit;
    } else {
        $games = "games.json";
        $lns = file("games.json");
        $data = '';
        foreach($lns as $l)
        {
            $data = $data . $l;
        }
        $data = json_decode($data, true);
        array_push($data["currentgames"], $gamename);
        $handle = fopen($games, "c+");
        if (fwrite($handle, json_encode($data)) === FALSE) {
            $r = array(
                "error" => 'Codigo de error 4, contacta al creador y dile este codigo.'
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
        "mapa" => array()
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
    /*
            "f1" => 8,
            "f2" => 8,
            "mapa" => array(
                array(0,0,0,0,0),
                array(0,0,0,0,0),
                array(0,0,0,0,0),
                array(0,0,0,0,0),
                array(0,0,0,0,0)
            ) */
    // guardando $game en su json
    if (fwrite($fp, json_encode($game)) === FALSE) {
        $r = array(
            "error" => 'Codigo de error 2, contacta al creador y dile este codigo.'
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

?>