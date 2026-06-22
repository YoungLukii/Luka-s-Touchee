<?php
include_once("../../config/config.php");

if($con != NULL){
    $id;

    if(isset($_GET['id'])  ){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        
     
                $consulta = "DELETE FROM `secciones` WHERE `id_seccion`='$id'";

                $resultado = mysqli_query($con,$consulta);

                header("Location: ../index.php");


                
    }else{

        header("Location: ../index.php");

    }

}





?>