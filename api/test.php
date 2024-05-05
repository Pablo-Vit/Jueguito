<?php

$moves = ['a','b','c'];
array_slice($moves,0);
$pos = array_search('b',$moves);
$ult = count($moves)-1;
$a = $moves[$pos];
$moves[$pos] = $moves[$ult];
$moves[$ult] = $a;
array_pop($moves);
array_push($moves,'x');
echo json_encode($moves);

?>
