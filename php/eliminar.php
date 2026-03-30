<?php 
include("conexion.php");

$id=$_POST['id_archivo'];


$query= $conexion->query("DELETE FROM actividades WHERE id_archivo=$id");

?>