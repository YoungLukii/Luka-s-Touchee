<?php
include_once("../config/config.php");

if ($con != NULL) {
    $nombre;
    $apellido;
    $correo;
    $clave;
    $clave_rep;

    if (isset($_POST['nombre']) and isset($_POST['apellido']) and isset($_POST['correo']) and isset($_POST['clave']) and isset($_POST['clave_rep'])) {
        $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
        $correo = mysqli_real_escape_string($con, $_POST['correo']);
        $clave = mysqli_real_escape_string($con, $_POST['clave']);
        $clave_rep = mysqli_real_escape_string($con, $_POST['clave_rep']);

        if ($nombre != "" and $apellido != "" and $correo != "" and $clave != "" and $clave_rep != "") {
            if ($clave == $clave_rep) {
                $consulta = "SELECT `correo` FROM `usuarios` WHERE `correo`='$correo'";

                $resultado = mysqli_query($con, $consulta);

                if (mysqli_num_rows($resultado) > 0) {
                    header("Location: ../pages/registrate.php?usuario=no");

                } else {
                    $crear_usuario = "INSERT INTO `usuarios`( `nombre`, `apellido`, `correo`, `clave`, `fk_estado`, `fk_tipo_usuario`) VALUES ('$nombre','$apellido','$correo',SHA1('$clave'),1,2)";

                    mysqli_query($con, $crear_usuario);

                    header("Location: ../pages/registrate.php?bien=no");


                }

            } else {
                header("Location: ../pages/registrate.php?palabra=no");
            }

        } else {

            header("Location: ../pages/registrate.php?datos=no");

        }

    }

}



?>