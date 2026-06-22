<?php
include_once("../../config/config.php");

if($con != NULL){
    $seccion;

    if(isset($_GET['seccion'])  ){
        $seccion = mysqli_real_escape_string($con, $_GET['seccion']);
        
     
                $consulta = "INSERT INTO `secciones`( `nombre`) VALUES ('$seccion')";

                $resultado = mysqli_query($con,$consulta);

                header("Location: ../index.php");


                
    }else{

        header("Location: ../index.php");

    }

}





?>