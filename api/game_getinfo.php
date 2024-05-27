<?php
require_once("db_connection.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["id"])) {
        $game = $_POST["game"];
        $filename = '../games/' . $game . '.json';
        if (is_readable($filename)) {
            if ($fp = fopen($filename, 'r')) {
                $r = array();
                $gdata = json_decode(fread($fp, filesize($filename)), true);
                if ($gdata["pl1"] != $_SESSION["id"] && $gdata["pl2"] != $_SESSION["id"]) {
                    $r = array(
                        "error" => 0
                    );
                    echo json_encode($r);
                    exit;
                } 
                $arrA = array();
                $arrV = array();
                array_push($arrA,"name");
                array_push($arrV,$gdata["name"]);
                array_push($arrA,"rival");
                $rivalid = -1;
                if ($gdata["pl1"] != $_SESSION["id"]) {
                    $rivalid = $gdata["pl1"];
                } else {
                    $rivalid = $gdata["pl2"];
                }
                if ($rivalid != -1) {
                    $sql = "SELECT username FROM users WHERE id = $rivalid";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            array_push($arrV,$row["username"]);
                        }
                    } else {
                        array_push($arrV, null);
                    }
                } else {
                    array_push($arrV, null);
                }
                array_push($arrA,"move");
                array_push($arrV,$gdata["move"]);
                array_push($arrA,"myid");
                array_push($arrV,$_SESSION["id"]);
                array_push($arrA,"myf");
                array_push($arrV, $gdata["pl1"] == $_SESSION["id"] ? $gdata["f1"] : $gdata["f2"]);
                array_push($arrA,"turno");
                array_push($arrV,$gdata["turno"] === $_SESSION["id"] ? true : false);
                array_push($arrA,"mapa");
                $gs = count($gdata["mapa"]);
                if ($gs === 5) {
                    array_push($arrV, 1);
                } elseif($gs === 9) {
                    array_push($arrV,2);
                } elseif($gs === 11) {
                    array_push($arrV,3);
                }
                array_push($arrA,"mapinfo");
                array_push($arrV,$gdata["mapa"]);
                $r = array_combine($arrA,$arrV);
                echo json_encode($r);
            }
        } else {
            $r = array(
                "error" => 1
            );
            echo json_encode($r);
        }
    }
}
?>