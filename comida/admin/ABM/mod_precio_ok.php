<?php
include_once("../../config/config.php");

if($con != NULL){
    $precio;
    $id;

    if(isset($_GET['precio']) and isset($_GET['id'])   ){
        $precio = mysqli_real_escape_string($con, $_GET['precio']);
        $id = mysqli_real_escape_string($con, $_GET['id']);

        $consulta = "UPDATE `comidas` SET `precio`='$precio' WHERE `id_comida`='$id'";
        $resultado = mysqli_query($con,$consulta);

        header("Location: ../index.php");

    }else{
        header("Location: ../index.php");
    }
}
?>