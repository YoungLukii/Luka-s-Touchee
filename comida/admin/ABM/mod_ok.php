<?php
include_once("../../config/config.php");

if($con != NULL){
    $seccion;
    $id;

    if(isset($_GET['seccion']) and isset($_GET['id'])   ){
        $seccion = mysqli_real_escape_string($con, $_GET['seccion']);
        $id = mysqli_real_escape_string($con, $_GET['id']);
        
     
                $consulta = "UPDATE `secciones` SET `nombre`='$seccion' WHERE `id_seccion`='$id'";

                $resultado = mysqli_query($con,$consulta);

                header("Location: ../index.php");


                
    }else{

        header("Location: ../index.php");

    }

}





?>