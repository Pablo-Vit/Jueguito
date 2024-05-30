<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["id"])) {
        if (isset($_POST["cont"]) && isset($_POST["game"])) {
            $game = $_POST["game"];
            $filename = '../games/' . $game . '.json';
            if (file_exists($filename)) {
                if ($fp = fopen($filename, 'r+')) {
                    $r = array();
                    $gdata = json_decode(fread($fp, filesize($filename)), true);
                    if (($_SESSION["id"] == $gdata["pl1"]) || ($_SESSION["id"] == $gdata["pl2"])) {
                        if (!isset($gdata['chat'])) {
                            array_push($gdata, array_combine(array('chat'), array(array())));
                        }
                        $msg = array(
                            'user' => (int) $_SESSION["id"],
                            'cont' => $_POST['cont']
                        );
                        array_push($gdata["chat"], $msg);
                        ftruncate($fp,0);
                        fseek($fp, 0);
                        fwrite($fp,json_encode($gdata));
                        $r = array(
                            "error" => null
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
