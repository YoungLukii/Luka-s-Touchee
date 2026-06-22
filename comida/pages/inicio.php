<?php
    session_start();
    include_once("../components/header.php");
?>

<div class="hero">
    <h1 class="welcome">Bienvenido</h1>
    <h2 class="cartelbienvenida">Cocina casera con ingredientes frescos, preparada con amor cada día.</h2>
    <p class="hero-bienvenida">
        <?php 
            if(isset($_SESSION['nombre'])) {
                print "  <h2 class='d-inline cartelbienvenida'> Hola, <span class='textito'>" . $_SESSION['nombre'] ."</span> ¿Que se te antoja hoy?</h2>";
            } else {
                print "<h2 class='d-inline cartelbienvenida'>Bienvenido a nuestro restaurante 🤍.</h2><h2 class='textito'><a href='iniciar.php' class='enlacelogin'>inicia sesión</a> o <a href='registrate.php' class='enlacelogin'>regístrate</a> para descubrir beneficios extras.</h2>";
            }
        ?>
    </p>
</div>

<?php
// Traer todas las secciones que tengan al menos un plato
$consulta_secs = "SELECT s.* FROM `secciones` s INNER JOIN `comidas` c ON c.fk_seccion = s.id_seccion GROUP BY s.id_seccion ORDER BY s.nombre ASC";
$resultado_secs = mysqli_query($con, $consulta_secs);
$secciones = [];
while($s = mysqli_fetch_array($resultado_secs)){
    $secciones[] = $s;
}
?>

<!-- Navbar de secciones dinámico -->
<nav class="menu-nav-secciones">
    <ul class="menu-list-secciones">
        <?php foreach($secciones as $s){ ?>
            <li><a href="#seccion-<?php print $s['id_seccion']; ?>"><?php print $s['nombre']; ?></a></li>
        <?php } ?>
        <?php
        // Si hay platos sin sección, agregar enlace
        $sin_sec = mysqli_query($con, "SELECT COUNT(*) as total FROM `comidas` WHERE fk_seccion IS NULL");
        $fila_sin = mysqli_fetch_array($sin_sec);
        if($fila_sin['total'] > 0){
            print "<li><a href='#seccion-sin'>Otros</a></li>";
        }
        ?>
    </ul>
</nav>

<main class="container">

    <p class="menu-title">— Nuestro Menú —</p>

    <?php
    // Mostrar platos agrupados por sección
    foreach($secciones as $s){
        $id_sec = $s['id_seccion'];
        $nombre_sec = $s['nombre'];
        $consulta_platos = "SELECT * FROM `comidas` WHERE `fk_seccion` = '$id_sec' ORDER BY nombre ASC";
        $resultado_platos = mysqli_query($con, $consulta_platos);

        if(mysqli_num_rows($resultado_platos) > 0){
            print "<h2 class='seccion-titulo' id='seccion-$id_sec'>$nombre_sec</h2>";
            print "<section class='row row-cols-1 row-cols-md-2 g-4 pb-4'>";
            while($fila = mysqli_fetch_array($resultado_platos)){
                print "
                    <article class='col'>
                        <div class='card-plato'>
                            <img src='../imgs/$fila[id_comida].webp' alt='$fila[nombre]' onerror=\"this.src='../imgs/default.webp'\">
                            <div class='card-body'>
                                <h5 class='card-title'>$fila[nombre]</h5>
                                <p class='precio-grande'>$ $fila[precio]</p>
                            </div>
                        </div>
                    </article>
                ";
            }
            print "</section>";
        }
    }

    // Platos sin sección
    $consulta_sin = "SELECT * FROM `comidas` WHERE `fk_seccion` IS NULL ORDER BY nombre ASC";
    $resultado_sin = mysqli_query($con, $consulta_sin);
    if(mysqli_num_rows($resultado_sin) > 0){
        print "<h2 class='seccion-titulo' id='seccion-sin'>Otros</h2>";
        print "<section class='row row-cols-1 row-cols-md-2 g-4 pb-4'>";
        while($fila = mysqli_fetch_array($resultado_sin)){
            print "
                <article class='col'>
                    <div class='card-plato'>
                        <img src='../imgs/$fila[id_comida].webp' alt='$fila[nombre]' onerror=\"this.src='../imgs/default.webp'\">
                        <div class='card-body'>
                            <h5 class='card-title'>$fila[nombre]</h5>
                            <p class='precio-grande'>$ $fila[precio]</p>
                        </div>
                    </div>
                </article>
            ";
        }
        print "</section>";
    }
    ?>


</main>

<?php
    include_once("../components/footer.php");
?>