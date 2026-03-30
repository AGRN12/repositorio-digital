<?php
include("conexion.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proyecto = $_POST['proyecto'];
    $user_id = $_POST['id_usuarioe'];
    $id_ar = $_POST['idarchivoe'];
    // Inicializar la variable de archivo
    $archivo_db_path = null;

    // Verifica si se ha subido un archivo sin errores
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $archivo = $_FILES['archivo'];

        // Asegúrate de que el directorio de destino existe
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Obtener la ruta del archivo a guardar
        $target_file = $target_dir . basename($archivo["name"]);

        if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
            // Ruta completa desde la raíz del servidor
            $archivo_db_path = '/icel/php/' . $target_file;
        } else {
            echo json_encode(["status" => "error", "message" => "Error al mover el archivo al directorio de destino"]);
            exit();
        }
    }

    // Insertar los datos en la base de datos
    if ($archivo_db_path) {
        $update_query = "UPDATE contribuciones SET proyecto='$proyecto', archivo='$archivo_db_path' WHERE id_usuario='$user_id' AND id_ar='$id_ar'";
    } else {
        $update_query = "UPDATE contribuciones SET proyecto='$proyecto' WHERE id_usuario='$user_id' AND id_ar='$id_ar'";
    }

    // Depuración: Imprimir la consulta SQL
    error_log("SQL Query: " . $update_query);

    $resultag = mysqli_query($conexion, $update_query);

    if ($resultag) {
        if (mysqli_affected_rows($conexion) > 0) {
            echo json_encode(["status" => "success", "message" => "Tarea Modificada correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontraron registros que coincidan con los criterios"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar en la base de datos: " . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
