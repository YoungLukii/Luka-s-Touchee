<?php
    include_once("../components/header.php");
?>
<main class="container py-5">

    <section class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">📝 Registrate</h2>
                </div>
                <div class="card-body">
                    <form action="../components/reg.php" method="post">
            <?php
                if(isset($_GET['datos'])){
                    print "
                        <div class='alert alert-danger' role='alert'>
                            TODOS LOS CAMPOS SON OBLIGATORIOS
                        </div>
                    ";

                }
                if(isset($_GET['palabra'])){
                    print "
                        <div class='alert alert-danger' role='alert'>
                            LAS CLAVES DEBEN SER IGUALES
                        </div>
                    ";

                }
                  if(isset($_GET['usuario'])){
                    print "
                        <div class='alert alert-danger' role='alert'>
                            EL USUARIO YA EXISTE
                        </div>
                    ";

                }
                if(isset($_GET['bien'])){
                    print "
                        <div class='alert alert-success' role='alert'>
                            Ya PODES INGRESAR 💕
                        </div>
                    ";

                }
            ?>
            <div>
                <label class="form-label" for="nombre">Nombre</label>
                <input class="form-control"  type="text" name="nombre" id="nombre" placeholder="Nombre" require>
            </div>
            <div>
                <label class="form-label" for="apellido">Apellido</label>
                <input class="form-control" type="text" name="apellido" id="apellido" placeholder="Apellido" require>
            </div>
            <div>
                <label class="form-label" for="correo">Correo</label>
                <input class="form-control" type="email" name="correo" id="correo" placeholder="ejemplo@davinci.edu.ar" require>
            </div>
            <div>
                <label class="form-label" for="clave">Contraseña</label>
                <input class="form-control" type="password" name="clave" id="clave" placeholder="Contraseña" require>
            </div>
             <div>
                <label class="form-label" for="clave_rep">Repetir Contraseña</label>
                <input class="form-control" type="password" name="clave_rep" id="clave_rep" placeholder="Repetir Contraeña" require>
            </div>
            <div class="mt-3">
                <a href="iniciar.php">¿Ya tienes una cuenta? Inicia sesión aquí</a> 
            </div>
            <div class="mt-4">

                <input class="btn btn-primary w-100" type="submit" Value="Registrate ❤">
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
