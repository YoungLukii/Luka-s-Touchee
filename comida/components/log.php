<?php
//inicio datos de secion en el server
session_start();
include_once("../config/config.php");
$usuario;
$clave;


if($con != NULL){
    if(isset($_POST['correo']) and isset($_POST['clave'])  ){
        $usuario = mysqli_real_escape_string($con,$_POST['correo']) ;
        $clave = mysqli_real_escape_string($con,$_POST['clave']) ;

        if($usuario != "" and $clave != ""){
            $consulta = "SELECT * FROM `usuarios` WHERE `correo`='$usuario'";

            $resultado = mysqli_query($con,$consulta);

            $fila = mysqli_fetch_array($resultado);

            if(mysqli_num_rows($resultado) > 0 ){

                if($fila['fk_estado'] == 1){
                     $consulta_clave = "SELECT * FROM `usuarios` WHERE `correo`='$usuario' AND `clave`=SHA1('$clave')";

                $resultado_dos = mysqli_query($con,$consulta_clave);

                if(mysqli_num_rows($resultado_dos) > 0 ){
                    //preguntamos si es un admin o un usuario normal
                    //print "logueado 😘";
                    $datos = mysqli_fetch_array( $resultado_dos);

                    if($datos['fk_tipo_usuario'] == 1 ){
                        //guardo los datos en la variable de secion
                        $_SESSION = $datos;

                        header("Location: ../admin/index.php");

                    }else{
                         $_SESSION = $datos;

                        header("Location: ../pages/inicio.php");
                    }
                }else{
                    header("Location: ../pages/iniciar.php?clave=no");
                }

               




                    
                }else{
                    header("Location: ../pages/iniciar.php?banneo=si");
                }



            }else{
                header("Location: ../pages/iniciar.php?usuario=no");
            }
        }else{
            header("Location: ../pages/iniciar.php?datos=no");
        }

    }

}

?>