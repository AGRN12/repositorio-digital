<?php
include("conexion.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materia = $_POST['materia'];
    $tarea = $_POST['tarea'];
    $user_id = $_POST['id_usuarioe'];
    $id_Archivo = $_POST['idarchivoe'];

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
        $insertar = "UPDATE actividades SET materia='$materia',titulo='$tarea',archivo='$archivo_db_path' WHERE id_usuario='$user_id' and id_archivo='$id_Archivo'";
    } else {
        $insertar = "UPDATE actividades SET materia='$materia',titulo='$tarea' WHERE id_usuario='$user_id' and id_archivo='$id_Archivo'";
    }

    $resultag = mysqli_query($conexion, $insertar);

    if ($resultag) {
        echo json_encode(["status" => "success", "message" => "Tarea Modificada correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al insertar en la base de datos: " . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
