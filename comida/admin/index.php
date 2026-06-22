<?php
session_start();
include_once("../config/config.php");

// Validar que el usuario sea admin
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['fk_tipo_usuario']) || $_SESSION['fk_tipo_usuario'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel ABM - Platos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="admin-body">

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../pages/inicio.php">👨🏻‍🍳 Luka´s Touchee</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/inicio.php">Inicio</a>
                        </li>
                        <?php if(isset($_SESSION['fk_tipo_usuario']) && $_SESSION['fk_tipo_usuario'] == 1){ ?>
                        <li class="nav-item">
                                <a class="nav-link" href="../pages/platos_detallados.php">Platos Detallados</a>
                            
                            </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="usuarios.php">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Secciones</a>
                        </li>
                        <?php } ?>
                        <?php if(isset($_SESSION['id_usuario'])){ ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger ms-2" href="../components/logout.php">Cerrar Sesión</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <?php 
        if(isset($_SESSION['exito'])) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    " . $_SESSION['exito'] . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
            unset($_SESSION['exito']);
        }
        if(isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    " . $_SESSION['error'] . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
            unset($_SESSION['error']);
        }
        ?>
        
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="admin-title">🍽️ Gestión de Platos</h1>
            </div>
        </div>

        <div class="row">
            <!-- Formulario para agregar plato -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm admin-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">➕ Agregar Nuevo Plato</h5>
                    </div>
                    <div class="card-body">
                        <form action="ABM/alta_comida.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Plato</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">💲Precio</label>
                                <input type="number" class="form-control" name="precio" id="precio" placeholder="0.00" step="0.01" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label for="fk_seccion" class="form-label">Sección</label>
                                <select class="form-control" name="fk_seccion" id="fk_seccion" required>
                                    <option value=""> 📂 Elegir sección </option>
                                    <?php
                                    $consulta_sec = "SELECT * FROM `secciones` ORDER BY nombre ASC";
                                    $resultado_sec = mysqli_query($con, $consulta_sec);
                                    while($sec = mysqli_fetch_array($resultado_sec)){
                                        print "<option value='$sec[id_seccion]'>$sec[nombre]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="imagen" class="form-label">🖼️Imagen del Plato</label>
                                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" required>
                                <small class="text-muted">Se convertirá automáticamente a formato WebP</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Crear Plato</button>
                        </form>
                    </div>
                </div>

                <!-- Formulario para agregar sección -->
                <div class="card shadow-sm admin-card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">📂 Agregar Sección</h5>
                    </div>
                    <div class="card-body">
                        <form action="ABM/alta_sec.php" method="get">
                            <div class="mb-3">
                                <label for="seccion" class="form-label">Nombre de la Sección</label>
                                <input type="text" class="form-control" name="seccion" id="seccion" placeholder="ej. Bebidas" required>
                            </div>
                            <button type="submit" class="btn btn-secondary w-100">Crear Sección</button>
                        </form>
                    </div>
                </div>

                <!-- Tabla de secciones existentes -->
                <div class="card shadow-sm admin-card mt-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">📋 Secciones</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th colspan="2" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $consulta_secs = "SELECT * FROM `secciones` ORDER BY nombre ASC";
                                    $resultado_secs = mysqli_query($con, $consulta_secs);
                                    if(mysqli_num_rows($resultado_secs) > 0){
                                        while($fila_sec = mysqli_fetch_array($resultado_secs)){
                                            print "
                                                <tr>
                                                    <td class='align-middle'><strong>$fila_sec[nombre]</strong></td>
                                                    <td class='text-center'><a class='btn btn-sm btn-warning' href='ABM/mod_sec.php?id=$fila_sec[id_seccion]'>✏️ Editar</a></td>
                                                    <td class='text-center'><a class='btn btn-sm btn-danger' href='ABM/baja_sec.php?id=$fila_sec[id_seccion]' onclick='return confirm(\"¿Seguro que deseas borrar esta sección?\")'>🗑️ Borrar</a></td>
                                                </tr>
                                            ";
                                        }
                                    } else {
                                        print "<tr><td colspan='3' class='text-center text-muted py-4'>No hay secciones registradas</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de platos -->
            <div class="col-lg-7">
                <div class="card shadow-sm admin-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">📋 Platos Disponibles</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Sección</th>
                                        <th>Precio</th>
                                        <th colspan="2" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $consulta = "SELECT c.*, s.nombre AS nombre_seccion FROM `comidas` c LEFT JOIN `secciones` s ON c.fk_seccion = s.id_seccion ORDER BY s.nombre ASC, c.nombre ASC";
                                    $resultado = mysqli_query($con, $consulta);

                                    if(mysqli_num_rows($resultado) > 0) {
                                        while ($fila = mysqli_fetch_array($resultado)) {
                                            $seccion_label = $fila['nombre_seccion'] ? "<span class='badge bg-secondary'>$fila[nombre_seccion]</span>" : "<span class='badge bg-light text-dark'>Sin sección</span>";
                                            print "
                                                <tr>
                                                    <td class='align-middle'><img src='../imgs/$fila[id_comida].webp' alt='$fila[nombre]' style='width: 50px; height: 50px; object-fit: cover; border-radius: 4px;' onerror=\"this.src='../imgs/default.webp'\"></td>
                                                    <td class='align-middle'><strong>$fila[nombre]</strong></td>
                                                    <td class='align-middle'>$seccion_label</td>
                                                    <td class='align-middle'><span class='badge bg-success'>$ $fila[precio]</span></td>
                                                    <td class='text-center'><a class='btn btn-sm btn-warning' href='ABM/editar_plato.php?id=$fila[id_comida]'>✏️ Editar</a></td>
                                                    <td class='text-center'><a class='btn btn-sm btn-danger' href='ABM/baja_comida.php?id=$fila[id_comida]' onclick='return confirm(\"¿Seguro que deseas borrar este plato?\")'>🗑️ Borrar</a></td>
                                                </tr>
                                            ";
                                        }
                                    } else {
                                        print "<tr><td colspan='6' class='text-center text-muted py-4'>No hay platos registrados</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
<footer class="footer">
        <div class="footer-content">
            <p>&copy; 2026 <strong>Luka´s Touchee</strong> - Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>