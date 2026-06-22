<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<main class="container" >

<form action="mod_ok.php" method="get" >
    <label for="mod" >Modificar Sección</label>
    <?php
include_once("../../config/config.php");

if($con != NULL){
    $id;

    if(isset($_GET['id'])  ){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        
     
                $consulta = "SELECT * FROM `secciones` WHERE `id_seccion`='$id'";

                $resultado = mysqli_query($con,$consulta);

                while($fila = mysqli_fetch_array($resultado)){

                    print "
                            <input type='text' id='seccion' name='seccion' placeholder=$fila[nombre] >
                            <input type='hidden' id='id' name='id' value=$fila[id_seccion] >
                    
                    ";

                }

               


                
    }else{

        header("Location: ../index.php");

    }

}





?>
<input type="submit" value="Modificar" >


</form>

 

</main>
   
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>