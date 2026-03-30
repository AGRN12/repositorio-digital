<?php
include("conexion.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proyecto = $_POST['pro2'];
   
    $archivo = $_FILES['archivo2'];
    $user_id = $_POST['user_id'];

    $consulta_n = "SELECT usuario FROM `usuarios` WHERE `id`=$user_id";
    $nombre = mysqli_query($conexion,$consulta_n);
    if ($nombre) {
        // Verifica si se obtuvo algún resultado
        if (mysqli_num_rows($nombre) > 0) {
            // Extrae el resultado como un array asociativo
            $fila = mysqli_fetch_assoc($nombre);
            $nombre_r = $fila['usuario'];
        } }
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
        $insertar = "INSERT INTO contribuciones (id_usuario, proyecto, autor, archivo) VALUES ('$user_id', '$proyecto', '$nombre_r', '$archivo_db_path')";
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
