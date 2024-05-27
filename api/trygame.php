<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["id"])) {
        $game = $_POST["game"];
        $pass = $_POST["pass"];
        $filename = '../games/' . $game . '.json';
        if(file_exists($filename)){
            if ($fp = fopen($filename, 'r+')) {
                $r = array();
                $arrA = array();
                $arrV = array();
                $gdata = json_decode(fread($fp, filesize($filename)), true);
                if ($gdata["pass"] === $pass) {
                    if ($_SESSION["id"] != $gdata["pl1"] && $_SESSION["id"] != $gdata["pl2"]) {
                        if ($gdata["pl2"] === -1) {
                            $gdata["pl2"] = $_SESSION["id"];
                            $gdata["turno"] = $gdata["pl".rand(1,2)];
                            ftruncate($fp,0);
                            fseek($fp, 0);
                            fwrite($fp,json_encode($gdata));
                            array_push($arrA,"isin");
                            array_push($arrV,true);
                            $r = array_combine($arrA,$arrV);
                            if ($hg = fopen('games.json', 'r+')) {
                                $g = json_decode(fread($hg, filesize('games.json')), true);
                                if ($ub = array_search((string) $game,$g["currentgames"])) {
                                    unset($g["currentgames"][$ub]);
                                    $g["currentgames"] = array_values($g["currentgames"]);
                                    array_push($g["oldgames"], $game);
                                }
                                ftruncate($hg,0);
                                fseek($hg, 0);
                                fwrite($hg, json_encode($g));
                                fclose($hg);
                            }
                        }
                    } else {
                        array_push($arrA,"isin");
                        array_push($arrV,true);
                        $r = array_combine($arrA,$arrV);
                    }
                } else {
                    array_push($arrA,"error");
                    array_push($arrV,'Contraseña incorrecta');
                    $r = array_combine($arrA,$arrV);
                }
                echo json_encode($r);
                fclose($fp);
            }
        }
    }
}