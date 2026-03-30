<?php
include("conexion.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materia = $_POST['materia'];
    $tarea = $_POST['tarea'];
    $archivo = $_FILES['archivo'];
    $user_id = $_POST['user_id'];

    // Verifica que el archivo se haya subido sin errores
    if (!isset($archivo) || $archivo['error'] != UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Error al subir el archivo"]);
        exit();
    }

    // Asegúrate de que el directorio de destino existe
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Obtener la ruta del archivo a guardar
    $target_file = $target_dir . basename($archivo["name"]);

    if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
        // Insertar los datos en la base de datos con la ruta completa
        $archivo_db_path = '/icel/php/' . $target_file; // Ruta completa desde la raíz del servidor
        $insertar = "INSERT INTO actividades (id_usuario, materia, titulo, archivo) VALUES ('$user_id', '$materia', '$tarea', '$archivo_db_path')";
        $resultag = mysqli_query($conexion, $insertar);

        if ($resultag) {
            echo json_encode(["status" => "success", "message" => "Tarea enviada correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al insertar en la base de datos: " . mysqli_error($conexion)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al mover el archivo al directorio de destino"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
