<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['data'])) {
        $data = $_POST['data'];

        // Nombre del archivo en el que se guardará el string
        $file = 'coords.txt';
        
        if (!file_exists($file)) {
            touch($file);
        }
        // Abre el archivo en modo escritura, creándolo si no existe
        $fileHandle = fopen($file, 'a');

        if ($fileHandle) {
            // Escribe el string en el archivo
            fwrite($fileHandle, $data . PHP_EOL);

            // Cierra el archivo
            fclose($fileHandle);

            $r = array(
                "text" => "Guardado exitoso"
            );
            echo json_encode($r);
            exit;
        } else {
            $r = array(
                "text" => "Error al abrir el archivo"
            );
            echo json_encode($r);
            exit;
        }
    } else {
        $r = array(
            "text" => "No se envio informacion"
        );
        echo json_encode($r);
        exit;
    }
}
?>