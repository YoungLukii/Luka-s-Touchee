<?php
    session_start();
    include_once("../components/header.php");
?>

<div class="hero">
    <h1 class="welcome">Platos Detallados</h1>
    <h2 class="cartelbienvenida">Descubre cada uno de nuestros platos con sus descripciones especiales</h2>
</div>

<main class="container mt-5 mb-5">
    <p class="menu-title">— Nuestros Platos —</p>

    <?php
    // Traer todos los platos
    $consulta_todos = "SELECT * FROM `comidas` ORDER BY nombre ASC";
    $resultado_todos = mysqli_query($con, $consulta_todos);
    
    if(mysqli_num_rows($resultado_todos) > 0){
        print "<section class='platos-detallados-grid'>";
        while($plato = mysqli_fetch_array($resultado_todos)){
            $descripcion = isset($plato['descripcion']) && !empty($plato['descripcion']) ? $plato['descripcion'] : ' Sin Descripción';
            print "
                <article class='card-plato-detallado'>
                    <div class='card-detallado-img'>
                        <img src='../imgs/$plato[id_comida].webp' alt='$plato[nombre]' onerror=\"this.src='../imgs/default.webp'\">
                    </div>
                    <div class='card-detallado-body'>
                        <h3 class='card-detallado-title'>$plato[nombre]</h3>
                        <p class='card-detallado-descripcion'>$descripcion</p>
                        <div class='card-detallado-footer'>
                            <p class='precio-grande'>$ $plato[precio]</p>
                        </div>
                    </div>
                </article>
            ";
        }
        print "</section>";
    } else {
        print "<p class='text-center text-muted mt-5'>No hay platos disponibles en este momento.</p>";
    }
    ?>

</main>

<?php
    include_once("../components/footer.php");
?>
