<?php
session_start();
require_once("funcs.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["id"])) {
        $game = $_POST["game"];
        $filename = '../games/' . $game . '.json';
        if(file_exists($filename)){
            if ($fp = fopen($filename, 'r+')) {
                $r = array();
                $gdata = json_decode(fread($fp, filesize($filename)), true);
                if (($_SESSION["id"] == $gdata["pl1"]) || ($_SESSION["id"] == $gdata["pl2"])) {
                    if ($gdata["turno"] == $_SESSION["id"]) {
                        $posi = $_POST["posi"];
                        $posj = $_POST["posj"];
                        $rival = $_SESSION["id"] == $gdata["pl1"] ? '2' : '1';
                        $me = $rival == '1' ? '2' : '1';
                        if ($gdata["f".$me] > 0) {
                            if ($gdata["mapa"][$posi][$posj] == 0) {
                                $gdata["turno"] = $gdata["turno"] == $gdata["pl1"] ? $gdata["pl2"] : $gdata["pl1"];
                                $gdata["move"]++; 
                                $gdata["f". $me]--;
                                $gdata["mapa"][$posi][$posj] = $_SESSION["id"];
                                $moves = array();
                                $move = json_decode(searchEnemy($gdata["mapa"], (int) $gdata["pl". $me], (int) $gdata["pl". $rival], $posi, $posj), true);
                                if (count($move) > 0) {
                                    $gdata["mapa"][$move[0]["y"]][$move[0]["x"]] = $move[0]["now"];
                                    while (count($move) != 0) {
                                        if (count($move) != 0) {
                                            array_push($moves, $move);
                                            $gdata["mapa"][$move[0]["y"]][$move[0]["x"]] = $move[0]["now"];
                                        }
                                        $move = json_decode(searchEnemy($gdata["mapa"], (int) $gdata["pl". $me], (int) $gdata["pl". $rival], $move[0]["y"], $move[0]["x"]), true);
                                    }
                                }
                                if (($gdata["f1"] == 0) && ($gdata["f2"] == 0)) {
                                    $gdata["move"] = -255;
                                    $gdata["turno"] = -1;
                                    if ($hg = fopen('games.json', 'r+')) {
                                        $g = json_decode(fread($hg, filesize('games.json')), true);
                                        if ($ub = array_search((string) $game,$g["oldgames"])) {
                                            unset($g["oldgames"][$ub]);
                                            $g["oldgames"] = array_values($g["oldgames"]);
                                            array_push($g["endedgames"], $game);
                                        }
                                        ftruncate($hg,0);
                                        fseek($hg, 0);
                                        fwrite($hg, json_encode($g));
                                        fclose($hg);
                                    }
                                }
                                ftruncate($fp,0);
                                fseek($fp, 0);
                                fwrite($fp,json_encode($gdata));
                                $r = array(
                                    "map" => $gdata["mapa"],
                                    "move" => $gdata["move"],
                                    "myf" => $gdata["pl1"] == $_SESSION["id"] ? $gdata["f1"] : $gdata["f2"]
                                );
                            } else {
                                $r = array(
                                    "error" => 2
                                );
                            }
                        }
                    } else {
                        $r = array(
                            "error" => 1
                        );
                    }
                } else{
                    $r = array(
                        "error" => 0
                    );
                }
                echo json_encode($r);
                fclose($fp);
            }
        }
    }
}
