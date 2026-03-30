<?php
session_start();
include("conexion.php");

// Verificar si hay una sesión iniciada
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    // Consulta SQL para verificar el usuario
    $sql4="SELECT id, usuario From usuarios where usuario=?";
    $stmt = $conexion->prepare($sql4);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si el usuario existe
    if ($resultado->num_rows > 0) {
        // Redirigir al usuario según su permiso
        header("Location: usuarios.php");
        exit;
    } else {
        // Si el usuario no existe, destruir la sesión y redirigir al login
        session_destroy();
        header("Location: index.php");
        exit;
    }
} 
?>
