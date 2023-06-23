<?php
/**
 * Vista de la oferta seleccionada, podemos modificar tanto su categoría, subcategoría o la descripción.
 * Su controlador es /bdt/controller/modificarOferta_ctl.php
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/logged_ctl.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Categoria.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Oferta.php';


$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;
$ofertaId = $_REQUEST['ofertaId'];
$oferta = new Oferta();
$oferta->autoFillOferta($ofertaId);

// Aquí no necesitamos que los filtros nos carguen ninguna table, por eso origen es modificarOferta, sin embargo
// una vez modificada la oferta, queremos volver al origen real y por esto primero guardamos el origen real en una
// variable, luego modificamos el origen de session, y al final del código(justo antes de </main>)
// volvemos a poner el origen real.
$realOrigen = $_SESSION['origen'];
$_SESSION['origen'] = 'modificarOferta';
?>

<body>
    <main class="centerForm">
        <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
        <input type="hidden" id="origen" value="modificarOferta"/>

        <form action="?action=ctl&option=modificarOferta&ofertaId=<?php echo $ofertaId;?>" method="post">
            <div class="lightBorder" style="height:100px; width: 100%; ">
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/filtros_view.php';?>
            </div>
            <!-- Descripción textarea -->
            <div class="form-outline mb-4 lightBorder" style="width: 100%;">
                <label class="form-label inputText" for="descr" style="margin-left: 1px;">
                    Descripción (max. 220 caracteres)
                </label>
                <textarea class="form-control" rows="3"  name="desc" id="desc" maxlength="120"></textarea>
            </div>
            <button class="btn btn-primary " type="submit" name="btnModificarOferta" >Modificar</button>
            <button class="btn btn-primary " type="button" id="btnCancelar" name="btnCancelar"
                    onclick="volverAtras(<?php echo $realOrigen; ?>)">Cancelar</button>
        </form>
        <?php $_SESSION['origen'] = $realOrigen; ?>
    </main>
</body>
<script type="text/javascript">
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogged(<?php echo $role;?>);

    $(window).on("load",function () {
        // Rellenamos los campos
        document.getElementById("desc").value = '<?php echo $oferta->getDescripcion(); ?>';
    });

</script>


<?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php'; ?>
