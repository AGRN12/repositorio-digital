<?php
// Se incluye la conexión
include("conexion.php");

$salida = "";

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';

$consulta1 = "SELECT * FROM contribuciones WHERE id_usuario = '$user_id'";

if (!empty($consulta)) {
    $q = $conexion->real_escape_string($consulta);
    $consulta1 = "SELECT id_usuario, proyecto, autor, archivo,id_ar 
                  FROM contribuciones 
                  WHERE id_usuario = '$user_id' AND (proyecto LIKE '%$q%' OR autor LIKE '%$q%')";
}

$resultado = $conexion->query($consulta1);

if ($resultado->num_rows > 0) {
    $salida .= "<table class='datos1'>
    <tr>
        <td>Proyecto</td>
        <td>Usuario</td>
        <td>Archivo</td>
        <td>Editar</td>
        <td>Eliminar</td>
    </tr>";
    
    while ($fila = $resultado->fetch_assoc()) {    
        $salida .= "<tr>
        <td>".$fila['proyecto']."</td>
        <td>".$fila['autor']."</td>
        <td><a href='".$fila['archivo']."' download>Descargar</a></td>
        <td><img src='iconos/editar.png' class='edit' onclick='editarap(\"".$fila['proyecto']."\", \"".$fila['id_ar']."\", \"".$fila['id_usuario']."\")'></td>
        <td><img src='iconos/borrar.png' class='edit' onclick='eliminarap(".$fila['id_ar'].")'></td>
        </tr>";
    }
    $salida .= "</table>";
} else {
    $salida .= "<p class='datos'>NO HAY DATOS QUE MOSTRAR</p>";
}

echo $salida;
?>
