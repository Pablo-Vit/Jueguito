<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function searchEnemy($map, $plid, $enemyid, $y, $x){
    $r = array();
    for ($i=-1; $i < 2; $i++) { 
        if (($y+$i >= 0) && ($y+$i <= count($map)-1)) {
            for ($j=-1; $j < 2; $j++) { 
                if (($x+$j >= 0) && ($x+$j <= count($map)-1)) {
                    if ($map[$y+$i][$x+$j] == $enemyid) {
                        if(tryConvertEnemy($map, $plid, $y+$i, $x+$j)) {
                            $converted = array(
                                "y" => $y+$i,
                                "x" => $x+$j,
                                "now" => $plid
                            );
                            array_push($r, $converted);
                        }
                    }
                }
            }
        }
    }
    return json_encode($r);
}

function tryConvertEnemy($map, $plid, $y, $x){
    $limit = 0;
    for ($i=-1; $i < 2; $i++) { 
        if (($y+$i >= 0) && ($y+$i <= count($map)-1)) {
            for ($j=-1; $j < 2; $j++) { 
                if (($x+$j >= 0) && ($x+$j <= count($map)-1)) {
                    if ($limit == 4) {
                        return false;
                    }
                    $limit++;
                    $vy = $y+$i;
                    $vx = $x+$j;
                    $cy = $y+posContr($i);
                    $cx = $x+posContr($j);
                    if ((($cy >= 0) && ($cy < count($map))) && (($cx >= 0) && ($cx < count($map)))) {
                        if (($map[$vy][$vx] == $plid) && ($map[$cy][$cx] == $plid)) {
                            return true;
                        }
                    }
                }
            }
        }
    }
}

function posContr($pos){
    return $pos*-1;
}
