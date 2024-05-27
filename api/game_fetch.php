<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(file_exists("games.json"))
    {
        $lns = file("games.json");
        $data = '';
        foreach($lns as $l)
        {
            $data = $data . $l;
        }
        $data = json_decode($data, true);
        $r = array();
        for($i = 0; $i < count($data["currentgames"]); $i++)
        {
            $x = $data["currentgames"][$i];
            $filename = '../games/' . $x . '.json';
            if ($fp = fopen($filename, 'r')) {
                $gdata = json_decode(fread($fp, filesize($filename)), true);
                if ($gdata["pl1"] === -1 || $gdata["pl2"] === -1) {
                    $arrA = array();
                    $arrV = array();
                    array_push($arrA,"name");
                    array_push($arrV,$gdata["name"]);
                    array_push($arrA,"id");
                    array_push($arrV,$x);
                    array_push($arrA,"priv");
                    array_push($arrV,false);
                    if (strlen($gdata["pass"]) > 0) {
                        $arrV[2] = true;
                    }
                    array_push($arrA,"mapa");
                    $gs = count($gdata["mapa"]);
                    if ($gs === 5) {
                        array_push($arrV, 1);
                    } elseif($gs === 9) {
                        array_push($arrV,2);
                    } elseif($gs === 11) {
                        array_push($arrV,3);
                    }
                    
                    
                    array_push($r,array_combine($arrA,$arrV));
                }
            }
        }
        echo json_encode($r);
    }
}
