<?php
/**
 * Vista de registro de usuario, en la cual  ademas, nos hacen aceptar unas condiciones de eso de nuestros datos
 * personales.
 * Su controlador es /bdt/controller/register_ctl.php
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/view/head.php';
$_SESSION['logged'] = false;
$_SESSION['usuario'] = null;
?>
<main>
    <div class="centerForm" style="top: 40%;">
        <form action="?action=ctl&option=register" method="post">
<!-- ########################################### DATOS DE REGISTRO ################################################# -->
            <div class="container lightBorder" style="height:190px;">
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <label class="form-label inputText" for="userName">Username</label>
                    <input type="text" name="userName" class="form-control" placeholder="Username" required>
                </div>
                <!-- Email input -->
                <div class="form-outline mb-4" style="float: left; margin-right: 15px;">
                    <label class="form-label inputText" for="emailReg">Email address</label>
                    <input type="email" name="emailReg" class="form-control" placeholder="email address" required>
                </div>
                <!-- Password input -->
                <div class="form-outline mb-4" style="float: left;">
                    <label class="form-label inputText" for="passwordReg">Password<br></label>
                    <label class="swtich-container">
                        <input type="checkbox" id="switch" onclick="checker();">---<!--guiones para centrar palabra Password-->
                        <div class="slider">
                            <span class="off">SHOW</span>
                            <span class="on">HIDE</span>
                        </div>
                    </label>
                    <input type="password" name="passwordReg" class="form-control" id="password" placeholder="password" required>
                </div>

            </div>

<!-- ############################################ DATOS PERSONALES ################################################# -->
            <div class="container lightBorder" style="height:190px;">
                <!-- Nombre input -->
                <div class="form-outline mb-4" style="float: left; margin-right: 15px;">
                    <label class="form-label inputText" for="nombreReg">Nombre</label>
                    <input type="text" name="nombreReg" class="form-control" placeholder="Nombre" required>
                </div>
                <!-- Apellidos input -->
                <div class="form-outline mb-4" style="float: left">
                    <label class="form-label inputText" for="apellidosReg">Apellidos</label>
                    <input type="text" name="apellidosReg" class="form-control" placeholder="Apellidos" required>
                </div>
                <!-- Población input -->
                <div class="form-outline mb-4">
                    <label class="form-label inputText" for="poblacionReg">Población</label>
                    <input type="text" name="poblacionReg" class="form-control" placeholder="Población" required>
                </div>
            </div>
            <div class="container" style="height:120px;">
                <input type="checkbox" onclick="checkerAceptar(this);">
                <label class="form-label inputText">
                    Acepto compartir mis datos con el resto de usuarios.</label>
                <p> Y que reciban mi email, a través de la plataforma para <br>
                    ponerse en contacto conmigo cuando estén interesados<br>
                    en una de mis ofertas.
                </p>
            </div>
            <button class="btn btn-primary mb-4 centerButton" type="submit" name="btnRegister" id="btnRegister" disabled>Aceptar</button>
        </form>
    </div>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php'; ?>
