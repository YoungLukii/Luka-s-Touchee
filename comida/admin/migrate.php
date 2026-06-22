<?php
session_start();
include_once("../config/config.php");

// Validar que el usuario sea admin
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['fk_tipo_usuario']) || $_SESSION['fk_tipo_usuario'] != 1) {
    header("Location: ../index.php");
    exit();
}

// Verificar si el campo imagen ya existe
$consulta = "SHOW COLUMNS FROM `comidas` LIKE 'imagen'";
$resultado = mysqli_query($con, $consulta);

if (mysqli_num_rows($resultado) == 0) {
    // El campo no existe, agregarlo
    $sql = "ALTER TABLE `comidas` ADD COLUMN `imagen` varchar(255) DEFAULT NULL";
    
    if (mysqli_query($con, $sql)) {
        echo "✓ Campo 'imagen' agregado correctamente a la tabla 'comidas'";
    } else {
        echo "✗ Error al agregar el campo 'imagen': " . mysqli_error($con);
    }
} else {
    echo "✓ El campo 'imagen' ya existe en la tabla 'comidas'";
}

echo "<br><br><a href='../index.php'>Volver al panel de administración</a>";
?>
