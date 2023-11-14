<?php
$file = 'coords.txt';

if (file_exists($file)) {
    $strings = file($file, FILE_IGNORE_NEW_LINES);
    if ($strings !== false) {
        $cant = count($strings);
        if ($cant > $_POST["last"]) {
            $strings = array_slice($strings, $cant -1);
            $r = array(
                "cant" => $cant,
                "move" => $strings
            );
            echo json_encode($r);
            exit;
        } else {
            $r = array(
                "text" => "No hay nuevo click"
            );
            echo json_encode($r);
            exit;    
        }
    } else {
        $r = array(
            "text" => "Error al abrir el archivo"
        );
        echo json_encode($r);
        exit;
    }
} else {
    $r = array(
            "text" => "Error, no se encontro el archivo"
        );
        echo json_encode($r);
        exit;
}
?>
