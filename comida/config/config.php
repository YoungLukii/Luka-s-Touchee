<?php
//conexión a la base de datos

$servidor = 'localhost'; // nombre del servidor (dirección - URL)
$usuario = 'root'; //usuario con permisos en ese servidor
$clave = ''; //clave/password de ese usuario con permisos
$base_de_datos = 'comida'; //que base de datos quiero
$puerto = '3306'; //puerto de conexión


//creo una variable para poder trabajar en todo el sitio
$con = mysqli_connect($servidor,$usuario,$clave,$base_de_datos,$puerto);



?>