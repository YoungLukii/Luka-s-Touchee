<?php
session_start();
include_once("../config/config.php");



//validacion
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
    <title>Panel ABM - Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="admin-body">

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../pages/inicio.php">👨🏻‍🍳 Luka´s Touchee</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/inicio.php">Inicio</a>
                        </li>
                        <?php if (isset($_SESSION['fk_tipo_usuario']) && $_SESSION['fk_tipo_usuario'] == 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/platos_detallados.php">Platos Detallados</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="usuarios.php">Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Secciones</a>
                            </li>
                        <?php } ?>
                        <?php if (isset($_SESSION['id_usuario'])) { ?>
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
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="admin-title">👥 Gestión de Usuarios</h1>
                <p class="text-muted">Bienvenido,
                    <strong><?php print $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?></strong>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm admin-card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">📊 Listado de Usuarios</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Correo</th>
                                        <th>Nombre</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    $consulta = "SELECT * FROM `usuarios` ORDER BY nombre ASC";
                                    $resultado = mysqli_query($con, $consulta);

                                    if (mysqli_num_rows($resultado) > 0) {
                                        while ($fila = mysqli_fetch_array($resultado)) {
                                            $estado = ($fila['fk_estado'] == 1) ? '<span class="badge bg-success">✓ Activo</span>' : '<span class="badge bg-danger">✗ Banneado</span>';
                                            $tipo = ($fila['fk_tipo_usuario'] == 1) ? '<span class="badge bg-warning text-dark">👨‍💼 Admin</span>' : '<span class="badge bg-info">👤 Usuario</span>';

                                            print "
                                                <tr>
                                                    <td class='align-middle'>$fila[correo]</td>
                                                    <td class='align-middle'>$fila[nombre] $fila[apellido]</td>
                                                    <td class='align-middle text-center'>$estado</td>
                                                    <td class='align-middle text-center'>$tipo</td>
                                                    <td class='text-center align-middle'>
                                                        <div class='btn-group btn-group-sm' role='group'>
                                            ";

                                            if ($fila['fk_estado'] == 1) {
                                                print "<a class='btn btn-danger' href='ABM/bannear_usr.php?id=$fila[id_usuario]' title='Banear usuario'>🚫 Banear</a>";
                                            } else {
                                                print "<a class='btn btn-warning' href='ABM/activar_usr.php?id=$fila[id_usuario]' title='Activar usuario'>✓ Activar</a>";
                                            }

                                            if ($fila['fk_tipo_usuario'] == 1) {
                                                print "<a class='btn btn-primary' href='ABM/usr_usr.php?id=$fila[id_usuario]' title='Convertir a usuario'>👤 User</a>";
                                            } else {
                                                print "<a class='btn btn-success' href='ABM/admin_usr.php?id=$fila[id_usuario]' title='Convertir a admin'>👨‍💼 Admin</a>";
                                            }

                                            print "
                                                        </div>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                    } else {
                                        print "<tr><td colspan='5' class='text-center text-muted py-4'>No hay usuarios registrados</td></tr>";
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>


</html>