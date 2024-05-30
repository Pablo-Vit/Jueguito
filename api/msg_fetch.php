<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["id"])) {
        if (isset($_POST["game"])) {
            $game = $_POST["game"];
            $filename = '../games/' . $game . '.json';
            if (file_exists($filename)) {
                if ($fp = fopen($filename, 'r+')) {
                    $gdata = json_decode(fread($fp, filesize($filename)), true);
                    if (($_SESSION["id"] == $gdata["pl1"]) || ($_SESSION["id"] == $gdata["pl2"])) {
                        if (isset($gdata['chat'])) {
                            $r = array();
                            $max = isset($_POST["max"]) ? $_POST["max"] : 0;
                            for ($i = $max; $i < count($gdata['chat']); $i++) {
                                $x = $gdata['chat'][$i];
                                $msg = array(
                                    'me' => $x['user'] == $_SESSION["id"] ? true : false,
                                    'cont' => (int) $x['cont']
                                );
                                array_push($r, $msg);
                            }
                            echo json_encode($r);
                        } else {
                            array_push($gdata, array_combine(array('chat'), array(array())));
                        }
                    } else {
                        $r = array(
                            "error" => 3
                        );
                        echo json_encode($r);
                        exit;
                    }
                }
            } else {
                $r = array(
                    "error" => 2
                );
                echo json_encode($r);
                exit;
            }
        } else {
            $r = array(
                "error" => 1
            );
            echo json_encode($r);
            exit;
        }
    } else {
        $r = array(
            "error" => 0
        );
        echo json_encode($r);
        exit;
    }
}
