<?php
session_start();
include_once("../../config/config.php");

// Validar que el usuario sea admin
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['fk_tipo_usuario']) || $_SESSION['fk_tipo_usuario'] != 1) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_comida = intval($_GET['id']);
    
    // Eliminar la imagen usando el ID del plato
    $ruta_imagen = "../../imgs/" . $id_comida . ".webp";
    if (file_exists($ruta_imagen)) {
        unlink($ruta_imagen);
    }
    
    // Eliminar el plato de la base de datos
    $consulta_delete = "DELETE FROM `comidas` WHERE id_comida = $id_comida";
    if (mysqli_query($con, $consulta_delete)) {
        $_SESSION['exito'] = "Plato eliminado correctamente";
    } else {
        $_SESSION['error'] = "Error al eliminar el plato: " . mysqli_error($con);
    }
} else {
    $_SESSION['error'] = "ID de plato no especificado";
}

header("Location: ../index.php");
exit();
?>
