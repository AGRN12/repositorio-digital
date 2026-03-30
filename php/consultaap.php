<?php
// Se incluye la conexión
include("conexion.php");

$salida = "";

$consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';
$consulta1 = "SELECT * FROM contribuciones";

if (!empty($consulta)) {
    $q = $conexion->real_escape_string($consulta);
    $consulta1 = "SELECT id_usuario, proyecto, autor, archivo 
                  FROM contribuciones 
                  WHERE (proyecto LIKE '%$q%' OR autor LIKE '%$q%')";
}

$resultado = $conexion->query($consulta1);

if ($resultado->num_rows > 0) {
    $salida .= "<table class='datos1'>
    <tr>
        <td>Proyecto</td>
        <td>Usuario</td>
        <td>Archivo</td>
    </tr>";
    
    while ($fila = $resultado->fetch_assoc()) {    
        $salida .= "<tr>
        <td>".$fila['proyecto']."</td>
        <td>".$fila['autor']."</td>
        <td><a href='".$fila['archivo']."' download>Descargar</a></td>
        </tr>";
    }
    $salida .= "</table>";
} else {
    $salida .= "<p class='datos'>NO HAY DATOS QUE MOSTRAR</p>";
}

echo $salida;
?>
