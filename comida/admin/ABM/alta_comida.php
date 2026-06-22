<?php
session_start();
include_once("../../config/config.php");

// Validar que el usuario sea admin
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['fk_tipo_usuario']) || $_SESSION['fk_tipo_usuario'] != 1) {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $fk_seccion = isset($_POST['fk_seccion']) && $_POST['fk_seccion'] != '' ? intval($_POST['fk_seccion']) : 'NULL';

    // Validar que el nombre y precio no estén vacíos
    if (empty($nombre) || empty($precio) || $precio <= 0) {
        $_SESSION['error'] = "El nombre y precio son requeridos, y el precio debe ser mayor a 0";
        header("Location: ../index.php");
        exit();
    }

    // Insertar primero en la base de datos para obtener el ID
    if ($fk_seccion === 'NULL') {
        $consulta = "INSERT INTO `comidas` (nombre, precio, fk_seccion) VALUES ('$nombre', $precio, NULL)";
    } else {
        $consulta = "INSERT INTO `comidas` (nombre, precio, fk_seccion) VALUES ('$nombre', $precio, $fk_seccion)";
    }

    if (!mysqli_query($con, $consulta)) {
        $_SESSION['error'] = "Error al agregar el plato: " . mysqli_error($con);
        header("Location: ../index.php");
        exit();
    }

    // Obtener el ID del plato recién creado
    $id_comida = mysqli_insert_id($con);

    // Procesar la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Usar el ID del plato como nombre: id_comida.webp
        $imagen_nombre = $id_comida . ".webp";
        $ruta_destino = "../../imgs/" . $imagen_nombre;

        // Crear directorio si no existe
        if (!is_dir("../../imgs")) {
            mkdir("../../imgs", 0777, true);
        }

        // Cargar la imagen y convertirla a webp
        $imagen_original = $_FILES['imagen']['tmp_name'];
        $tipo_mime = mime_content_type($imagen_original);
        $extension_archivo = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        // Si ya es WebP, simplemente copiar
        if ($tipo_mime == 'image/webp' || $extension_archivo == 'webp') {
            if (!copy($imagen_original, $ruta_destino)) {
                $_SESSION['error'] = "No se pudo guardar la imagen";
                header("Location: ../index.php");
                exit();
            }
        } else {
            // Convertir otros formatos a WebP
            switch ($tipo_mime) {
                case 'image/jpeg':
                    $img = imagecreatefromjpeg($imagen_original);
                    break;
                case 'image/png':
                    $img = imagecreatefrompng($imagen_original);
                    break;
                case 'image/gif':
                    $img = imagecreatefromgif($imagen_original);
                    break;
                default:
                    $_SESSION['error'] = "Formato de imagen no válido. Use JPG, PNG, GIF o WebP";
                    header("Location: ../index.php");
                    exit();
            }

            if (!$img) {
                $_SESSION['error'] = "No se pudo procesar la imagen";
                header("Location: ../index.php");
                exit();
            }

            // Guardar como webp
            if (!imagewebp($img, $ruta_destino, 80)) {
                $_SESSION['error'] = "No se pudo guardar la imagen";
                header("Location: ../index.php");
                exit();
            }
            imagedestroy($img);
        }
    } else {
        $_SESSION['error'] = "Debes subir una imagen";
        // Eliminar el registro de la BD si no se guardó la imagen
        $consulta_delete = "DELETE FROM `comidas` WHERE id_comida = $id_comida";
        mysqli_query($con, $consulta_delete);
        header("Location: ../index.php");
        exit();
    }

    $_SESSION['exito'] = "Plato agregado exitosamente";
    header("Location: ../index.php");
    exit();
}
?>