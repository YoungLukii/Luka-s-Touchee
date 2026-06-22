<?php
    session_start();
    include_once("../../config/config.php");

    // Validar que sea admin
    if(!isset($_SESSION['fk_tipo_usuario']) || $_SESSION['fk_tipo_usuario'] != 1) {
        header("Location: ../../pages/inicio.php");
        exit;
    }

    // Obtener el ID del plato
    if(!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../index.php");
        exit;
    }

    $id_plato = mysqli_real_escape_string($con, $_GET['id']);

    // Traer datos del plato
    $consulta = "SELECT * FROM `comidas` WHERE `id_comida` = '$id_plato'";
    $resultado = mysqli_query($con, $consulta);

    if(mysqli_num_rows($resultado) == 0) {
        header("Location: ../index.php");
        exit;
    }

    $plato = mysqli_fetch_array($resultado);

    // Traer secciones
    $consulta_sec = "SELECT * FROM `secciones` ORDER BY nombre ASC";
    $resultado_sec = mysqli_query($con, $consulta_sec);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Plato - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .edit-container {
            max-width: 800px;
            margin: 40px auto;
        }

        .edit-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .edit-card-header {
            background: linear-gradient(135deg, #2c2c2c 0%, #3a3a3a 100%);
            color: #f09c0b;
            padding: 25px;
            border-bottom: 3px solid #f09c0b;
        }

        .edit-card-header h3 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .edit-card-body {
            padding: 30px;
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 8px;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #f09c0b;
            box-shadow: 0 0 0 0.2rem rgba(240, 156, 11, 0.15);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .plato-preview {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f5f5f5;
            border-left: 4px solid #f09c0b;
            border-radius: 4px;
        }

        .plato-preview img {
            width: 100%;
            max-width: 200px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .preview-info {
            font-size: 0.95rem;
            color: #555555;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-save {
            background: linear-gradient(135deg, #f09c0b 0%, #e68a00 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(240, 156, 11, 0.3);
            color: white;
        }

        .btn-cancel {
            background-color: #d9d9d9;
            color: #2c2c2c;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        .btn-cancel:hover {
            background-color: #bfbfbf;
            color: #2c2c2c;
            text-decoration: none;
        }

        .section-divider {
            margin: 30px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .section-title {
            color: #8a6f4e;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-prefix {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8a6f4e;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .input-with-icon .form-control {
            padding-left: 40px;
        }
    </style>
</head>
<body class="admin-body">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../../pages/inicio.php">👨🏻‍🍳 Luka´s Touchee</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/inicio.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">Panel Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger ms-2" href="../../components/logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="edit-container">
        <div class="edit-card">
            <div class="edit-card-header">
                <h3>✏️ Editar Plato:</h3>
            </div>
            <div class="edit-card-body">
                <!-- Vista previa del plato -->
                <div class="plato-preview">
                    <img src="../../imgs/<?php echo $plato['id_comida']; ?>.webp" alt="<?php echo htmlspecialchars($plato['nombre']); ?>" onerror="this.src='../../imgs/default.webp'">
                    <div class="preview-info">
                        <strong>ID:</strong> <?php echo $plato['id_comida']; ?> | 
                        <strong>Producto:</strong> <?php echo $plato['nombre']; ?>
                    </div>
                </div>

                <form method="POST" action="editar_plato_ok.php">
                    <input type="hidden" name="id_comida" value="<?php echo $plato['id_comida']; ?>">

                    <!-- Información básica -->
                    <div class="section-title">Información Básica</div>

                    <div class="form-group">
                        <label for="nombre" class="form-label">Nfombre del Plato</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($plato['nombre']); ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio" class="form-label">Precio ($)</label>
                                <div class="input-with-icon">
                                    <span class="input-prefix">$</span>
                                    <input type="number" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($plato['precio']); ?>" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fk_seccion" class="form-label">Sección</label>
                                <select class="form-select" id="fk_seccion" name="fk_seccion">
                                    <option value="">-- Sin sección --</option>
                                    <?php while($sec = mysqli_fetch_array($resultado_sec)): ?>
                                        <option value="<?php echo $sec['id_seccion']; ?>" <?php echo ($plato['fk_seccion'] == $sec['id_seccion']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($sec['nombre']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="section-divider"></div>
                    <div class="section-title">Descripción Detallada</div>

                    <div class="form-group">
                        <label for="descripcion" class="form-label">Descripción del Plato</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Describe los ingredientes, preparación, sabor, etc. del plato..."><?php echo htmlspecialchars($plato['descripcion'] ?? ''); ?></textarea>
                        <small class="text-muted d-block mt-2">
                            <span id="char_count">0</span> / 500 caracteres
                        </small>
                    </div>

                    <!-- Botones de acción -->
                    <div class="button-group">
                        <button type="submit" class="btn-save">💾 Guardar Cambios</button>
                        <a href="../index.php" class="btn-cancel">❌ Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Contador de caracteres para la descripción
        const descTextarea = document.getElementById('descripcion');
        const charCount = document.getElementById('char_count');
        
        descTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            if(this.value.length > 500) {
                this.value = this.value.substring(0, 500);
                charCount.textContent = 500;
            }
        });

        // Inicializar contador
        charCount.textContent = descTextarea.value.length;
    </script>
</body>
</html>
