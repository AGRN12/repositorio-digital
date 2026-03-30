<?php 
include("conexion.php");

$id=$_POST['id_ar'];


$query= $conexion->query("DELETE FROM contribuciones WHERE id_ar=$id");

?>