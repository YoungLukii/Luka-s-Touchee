<?php
session_start();
include_once("../config/config.php");

// Validar que sea admin
if(!isset($_SESSION['fk_tipo_usuario']) || $_SESSION['fk_tipo_usuario'] != 1) {
    header("Location: ../pages/inicio.php");
    exit;
}

// Procesar actualización de descripción
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_comida']) && isset($_POST['descripcion'])) {
    $id_comida = mysqli_real_escape_string($con, $_POST['id_comida']);
    $descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
    
    $update_query = "UPDATE `comidas` SET `descripcion` = '$descripcion' WHERE `id_comida` = '$id_comida'";
    
    if(mysqli_query($con, $update_query)) {
        $_SESSION['exito'] = "✓ Descripción actualizada correctamente";
    } else {
        $_SESSION['error'] = "✗ Error al actualizar: " . mysqli_error($con);
    }
    header("Location: editar_descripciones.php");
    exit;
}

// Traer todos los platos
$consulta_platos = "SELECT * FROM `comidas` ORDER BY nombre ASC";
$resultado_platos = mysqli_query($con, $consulta_platos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Descripciones - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .desc-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .desc-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }

        .desc-card-header {
            background: linear-gradient(135deg, #2c2c2c 0%, #3a3a3a 100%);
            color: #f09c0b;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .desc-card-header h5 {
            margin: 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .desc-badge {
            background-color: rgba(240, 156, 11, 0.2);
            color: #f09c0b;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .desc-card-body {
            padding: 20px;
        }

        .plato-info {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .plato-info small {
            display: block;
            color: #888;
            margin: 5px 0;
        }

        .desc-textarea {
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px;
            font-size: 0.95rem;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .desc-textarea:focus {
            border-color: #f09c0b;
            box-shadow: 0 0 0 0.2rem rgba(240, 156, 11, 0.15);
            outline: none;
        }

        .char-counter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
            font-size: 0.85rem;
        }

        .char-count {
            color: #888;
        }

        .char-count.warning {
            color: #ff9800;
            font-weight: 600;
        }

        .char-count.danger {
            color: #dc3545;
            font-weight: 600;
        }

        .btn-save-desc {
            background-color: #f09c0b;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-save-desc:hover {
            background-color: #e68a00;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(240, 156, 11, 0.3);
            color: white;
            text-decoration: none;
        }

        .page-header {
            background: linear-gradient(135deg, #2c2c2c 0%, #3a3a3a 100%);
            color: #f09c0b;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 8px;
            text-align: center;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .platos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
            gap: 20px;
        }

        @media (max-width: 768px) {
            .platos-grid {
                grid-template-columns: 1fr;
            }

            .desc-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body class="admin-body">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../pages/inicio.php">👨🏻‍🍳 Luka´s Touchee</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/inicio.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Panel Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger ms-2" href="../components/logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        <div class="page-header">
            <h1>📝 Editar Descripciones de Platos</h1>
        </div>

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

        <div class="platos-grid">
            <?php while($plato = mysqli_fetch_array($resultado_platos)): ?>
                <div class="desc-card">
                    <div class="desc-card-header">
                        <h5><?php echo htmlspecialchars($plato['nombre']); ?></h5>
                        <span class="desc-badge">ID: <?php echo $plato['id_comida']; ?></span>
                    </div>
                    <div class="desc-card-body">
                        <div class="plato-info">
                            <small><strong>Precio:</strong> $<?php echo $plato['precio']; ?></small>
                            <?php if($plato['imagen']): ?>
                                <small><strong>Imagen:</strong> <?php echo htmlspecialchars($plato['imagen']); ?></small>
                            <?php endif; ?>
                        </div>

                        <form method="POST" action="">
                            <input type="hidden" name="id_comida" value="<?php echo $plato['id_comida']; ?>">
                            
                            <textarea 
                                name="descripcion" 
                                class="desc-textarea"
                                placeholder="Describe los ingredientes, preparación, sabor, etc. del plato..."
                                maxlength="500"
                                data-counter="counter_<?php echo $plato['id_comida']; ?>"
                            ><?php echo htmlspecialchars($plato['descripcion'] ?? ''); ?></textarea>

                            <div class="char-counter">
                                <span>Descripción detallada:</span>
                                <span class="char-count" id="counter_<?php echo $plato['id_comida']; ?>">
                                    <?php echo strlen($plato['descripcion'] ?? ''); ?>/500
                                </span>
                            </div>

                            <div style="margin-top: 15px;">
                                <button type="submit" class="btn-save-desc">💾 Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if(mysqli_num_rows($resultado_platos) == 0): ?>
            <div class="alert alert-info text-center py-5">
                <h5>No hay platos registrados</h5>
                <p class="mb-0">Agrega platos desde el panel de gestión</p>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Contador de caracteres
        document.querySelectorAll('.desc-textarea').forEach(textarea => {
            const counterId = textarea.dataset.counter;
            
            textarea.addEventListener('input', function() {
                const counter = document.getElementById(counterId);
                const count = this.value.length;
                
                if(count > 450) {
                    counter.classList.add('warning');
                } else {
                    counter.classList.remove('warning', 'danger');
                }
                
                if(count > 490) {
                    counter.classList.add('danger');
                }
                
                counter.textContent = count + '/500';
            });

            // Inicializar
            textarea.dispatchEvent(new Event('input'));
        });
    </script>
</body>
</html>
