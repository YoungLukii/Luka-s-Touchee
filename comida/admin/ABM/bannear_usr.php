<?php
include_once("../../config/config.php");

if($con != NULL){
   
    $id;

    if( isset($_GET['id'])   ){
       
        $id = mysqli_real_escape_string($con, $_GET['id']);
        
     
                $consulta = "UPDATE `usuarios` SET `fk_estado`='2' WHERE `id_usuario`='$id'";

                $resultado = mysqli_query($con,$consulta);

                header("Location: ../usuarios.php");


                
    }else{

        header("Location: ../index.php");

    }

}





?>