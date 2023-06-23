<?php
/**
 * Esta es una vista pequeña, la cual mediante la inserción del correo electrónico con el que estamos registrados,
 * podemos obtener nuestra contraseña.
 * Su controlador es /bdt/controller/recuperarPass_ctl.php
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/view/head.php';

?>
<main>
    <div class="centerForm">
        <form action="?action=ctl&option=recuperarPass" method="post">
            <!--    <form style="width: 22rem;">-->
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="email" name="inUser" class="form-control" placeholder="email address" required>
                <label class="form-label" for="user" style="margin-left: 0px;">Email address</label>
                <div class="form-notch">
                    <div class="form-notch-leading" style="width: 9px;"></div>
                    <div class="form-notch-middle" style="width: 88.8px;"></div>
                    <div class="form-notch-trailing"></div>
                </div>
            </div>
            <!-- Submit button -->
            <button type="submit" name="btnSend" class="btn btn-primary btn-block mb-4" style="margin-left: 60px;">Enviar</button>

        </form>
    </div>
</main>
<script type="text/javascript">
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogout();
</script>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php'; ?>
