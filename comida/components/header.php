<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($con)) {
    include_once("../config/config.php");
}

// Función para determinar si un link es activo
function isActive($page) {
    $current_page = basename($_SERVER['PHP_SELF']);
    return $current_page === $page ? 'active' : '';
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luka´s Touchee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css" >
  </head>
  <body>
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
          <a class="nav-link <?php echo isActive('inicio.php'); ?>" href="../pages/inicio.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo isActive('platos_detallados.php'); ?>" href="../pages/platos_detallados.php">Platos Detallados</a>
        </li>
        <?php if(isset($_SESSION['fk_tipo_usuario']) && $_SESSION['fk_tipo_usuario'] == 1){ ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Panel Admin
          </a>
          <ul class="dropdown-menu" aria-labelledby="adminDropdown">
            <li><a class="dropdown-item" href="../admin/usuarios.php">Usuarios</a></li>
            <li><a class="dropdown-item" href="../admin/index.php">Secciones</a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if(!isset($_SESSION['id_usuario'])){ ?>
        <li class="nav-item">
          <a class="nav-link <?php echo isActive('registrate.php'); ?>" href="../pages/registrate.php">Registrate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo isActive('iniciar.php'); ?>" href="../pages/iniciar.php">Ingresa</a>
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