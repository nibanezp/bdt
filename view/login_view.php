<?php
/**
 * Vista donde el usuario puede hacer login, o acceder a la vista de recuperación de contraseña, en caso de perdida.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/view/head.php';
$_SESSION['logged'] = false;
$_SESSION['usuario'] = null;

?>
<main>
    <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
    <input type="hidden" id="origen" value="login"/>

    <div class="centerForm">
        <form action="?action=ctl&option=login" method="post">
                <!-- Email input -->
                <div class="form-outline mb-1" style="width: 300px; ">
                    <label class="form-label inputText" for="user" style="margin-left: 0px;">Username</label>
                    <input type="text" name="user" class="form-control" placeholder="Username">
                </div>
                <!-- Password input -->
                <div class="form-outline mb-4 " style="width: 300px;">
                    <label class="form-label inputText" for="password" style="margin-left: 0px;">Password<br></label>
                    <label class="swtich-container">
                       <input type="checkbox" id="switch" onclick="checker();">---<!--guiones para centrar palabra Password-->
                        <div class="slider">
                            <span class="off">SHOW</span>
                            <span class="on">HIDE</span>
                        </div>
                    </label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="password">
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                    <div class="col d-flex justify-content-center inputText">
                        <!-- Simple link -->
                        <a href="?action=view&option=recuperarPass">Forgot password?</a>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="text-center inputText">
                    <button type="submit" name="btnSignIn" class="btn btn-primary btn-block mb-4">Sign in</button>
                </div>
            </form>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php'; ?>
