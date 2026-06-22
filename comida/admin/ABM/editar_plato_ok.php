<?php
session_start();
include_once("../../config/config.php");

// Validar que sea admin
if(!isset($_SESSION['fk_tipo_usuario']) || $_SESSION['fk_tipo_usuario'] != 1) {
    header("Location: ../../pages/inicio.php");
    exit;
}

// Validar datos
if(!isset($_POST['id_comida']) || !isset($_POST['nombre']) || !isset($_POST['precio'])) {
    $_SESSION['error'] = "Datos inválidos";
    header("Location: ../index.php");
    exit;
}

$id_comida = mysqli_real_escape_string($con, $_POST['id_comida']);
$nombre = mysqli_real_escape_string($con, $_POST['nombre']);
$precio = mysqli_real_escape_string($con, $_POST['precio']);
$fk_seccion = !empty($_POST['fk_seccion']) ? mysqli_real_escape_string($con, $_POST['fk_seccion']) : NULL;
$descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);

// Validar que el plato exista
$check = "SELECT id_comida FROM `comidas` WHERE `id_comida` = '$id_comida'";
$resultado_check = mysqli_query($con, $check);

if(mysqli_num_rows($resultado_check) == 0) {
    $_SESSION['error'] = "El plato no existe";
    header("Location: ../index.php");
    exit;
}

// Actualizar plato
$fk_seccion_sql = $fk_seccion !== NULL ? "'$fk_seccion'" : "NULL";
$update = "UPDATE `comidas` SET 
           `nombre` = '$nombre',
           `precio` = '$precio',
           `fk_seccion` = $fk_seccion_sql,
           `descripcion` = '$descripcion'
           WHERE `id_comida` = '$id_comida'";

if(mysqli_query($con, $update)) {
    $_SESSION['exito'] = "✓ Plato actualizado correctamente";
} else {
    $_SESSION['error'] = "✗ Error al actualizar: " . mysqli_error($con);
}

header("Location: ../index.php");
exit;
?>
