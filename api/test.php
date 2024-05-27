<?php
$todo = json_decode('{"a":["1"],"b":["2"],"c":[]}', true);
$pos = array_search('1',$todo["a"]);
unset($todo["a"][$pos]);
$todo["a"] = array_values($todo["a"]);
array_push($todo["c"],'x');
echo json_encode($todo);
