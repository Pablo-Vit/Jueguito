<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (file_exists("games.json")) {
        if (isset($_SESSION["id"])) {
            $lns = file("games.json");
            $data = '';
            foreach ($lns as $l) {
                $data = $data . $l;
            }
            $data = json_decode($data, true);
            $r = array();
            if (count($data["endedgames"]) > 0) {
                for ($i = 0; $i < count($data["endedgames"]); $i++) {
                    $x = $data["endedgames"][$i];
                    $filename = '../games/' . $x . '.json';
                    if ($fp = fopen($filename, 'r')) {
                        $gdata = json_decode(fread($fp, filesize($filename)), true);
                        if ($gdata["pl1"] === $_SESSION["id"] || $gdata["pl2"] === $_SESSION["id"]) {
                            $arrA = array();
                            $arrV = array();
                            array_push($arrA, "name");
                            array_push($arrV, $gdata["name"]);
                            array_push($arrA, "id");
                            array_push($arrV, $x);
                            array_push($r, array_combine($arrA, $arrV));
                        }
                    }
                }
            }
            echo json_encode($r);
        }
    }
}
