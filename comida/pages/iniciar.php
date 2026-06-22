<?php
    include_once("../components/header.php");
?>
<main class="container py-5">

    <section class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">🔐 Iniciar Sesión</h2>
                </div>
                <div class="card-body">
                    <form action="../components/log.php" method="post">
            <?php
                if(isset($_GET['datos'])){
                    print "
                        <div class='alert alert-danger' role='alert'>
                            TODOS LOS CAMPOS SON OBLIGATORIOS
                        </div>
                    ";

                }
                if(isset($_GET['usuario'])){
                    print "
                        <div class='alert alert-danger' role='alert'>
                            El usuario no existe
                        </div>
                    ";

                }
                if(isset($_GET['clave'])){
                    print "
                        <div class='alert alert-danger' role='alert'>
                            El usuario o contraseña no coinciden
                        </div>
                    ";

                }
                  if(isset($_GET['banneo'])){
                    print "
                        <div class='alert alert-danger' role='alert'>
                            Tu cuenta ha sido suspendida, contacta con el administrador para más información.
                        </div>
                    ";

                }

            ?>
          
           
            <div>
                <label class="form-label" for="correo">Correo</label>
                <input class="form-control" type="email" name="correo" id="correo" placeholder="ejemplo@davinci.edu.ar" require>
            </div>
            <div>
                <label class="form-label" for="clave">Contraseña</label>
                <input class="form-control" type="password" name="clave" id="clave" placeholder="Contraseña" require>
            </div>

            <div class="mt-3">
                <a href="registrate.php">¿No tienes una cuenta? Regístrate aquí</a>
            </div>
            <div class="mt-4">
                <input class="btn btn-success w-100" type="submit" Value="Iniciar ❤">
            </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

</main>




<?php
    include_once("../components/footer.php");
?>
