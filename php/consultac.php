<?php
// Se incluye la conexión
include("conexion.php");

// Creamos variable de salida para poder utilizar como respuesta de JavaScript
$salida = "";

// Recoger el valor de 'user_id' y 'consulta' enviados por la solicitud AJAX
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$consulta = isset($_POST['consulta']) ? $_POST['consulta'] : '';

// Aquí hacemos una consulta SQL en un orden por id
$consulta1 = "SELECT * FROM actividades WHERE id_usuario = '$user_id'";

// Aquí preguntamos si nos llegó algún valor desde el archivo JavaScript por el método POST
if (!empty($consulta)) {
    // Aquí convertimos el valor del método POST en un string para poder usarlo en consultas SQL
    $q = $conexion->real_escape_string($consulta);
    // Aquí sustituimos la primera consulta; esta consulta es la que hará la consulta dinámica
    $consulta1 = "SELECT id_usuario, materia, titulo, archivo, id_archivo 
                  FROM actividades 
                  WHERE (materia LIKE '%$q%' OR titulo LIKE '%$q%') 
                  AND id_usuario = '$user_id'";
}

// Aquí guardamos la variable resultado de la consulta nueva de consulta1 para la caja de texto
$resultado = $conexion->query($consulta1);

// Aquí preguntamos si la consulta tiene contenido en su tabla, o sea, si el contenido es mayor a 0
if ($resultado->num_rows > 0) {
    // En caso que sí tenga contenido
    // En la variable salida es la que nos redigirá al JavaScript para hacer la función
    // Y se guarda todo el HTML de la tabla que se va mostrar 
    $salida .= "<table class='datos1'>
    <tr>
        <td>Materia</td>
        <td>Título</td>
        <td>Archivo</td>
        <td>Modificar</td>
        <td>Eliminar</td>
    </tr>";
    
    // Aquí hacemos un while para pedir todos los datos de la base de datos    
    while ($fila = $resultado->fetch_assoc()) {    
        $salida .= "<tr>
        <td>".$fila['materia']."</td>
        <td>".$fila['titulo']."</td>
        <td><a href='".$fila['archivo']."' download>Descargar</a></td>
        <td><img src='iconos/editar.png' class='edit' onclick='editar(\"".$fila['materia']."\", \"".$fila['titulo']."\", \"".$fila['id_usuario']."\", ".$fila['id_archivo'].")'></td>
        <td><img src='iconos/borrar.png' class='edit' onclick='eliminar(".$fila['id_archivo'].")'></td>
        </tr>";
    }
    
    // Aquí terminamos y cerramos la etiqueta de table
    $salida .= "</table>";
} else {
    // En caso que no encuentre datos la variable salida va a ser igual a este mensaje
    $salida .= "<p class='datos'>NO HAY DATOS QUE MOSTRAR</p>";
}

// Para enviar el valor de salida lo hacemos con un echo 
echo $salida;
?>
