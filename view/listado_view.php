<?php
/**
 * Fichero que contiene el listado principal de las ofertas.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/logged_ctl.php';

$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;
$_SESSION['origen'] = 'listado';

?>
<main>
    <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
    <input type="hidden" id="origen" value="listado"/>


    <div class="container">
        <div class="lightBorder" style="height:100px; display: flex; margin-left: 25%;">
            <?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/filtros_view.php';?>
        </div>
        <table id="tblListado" class="table table-blue table-striped table-bordered" style="width: 100%;">
            <thead>
            <tr>
                <th style="width: 1%">Id</th>
                <th style="width: 13%">Categoría</th>
                <th style="width: 20%">Sub categoría</th>
                <th style="width: 55%">Descripción</th>
                <th style="width: 3%">Valoración</th>
                <th style="width: 4%">Votos</th>
                <th style="width: 3%">Ofertante</th>
                <?php if($role == 1){?>
                        <th class="text-center" style="width: 4%">Borrar</th >
                        <th class="text-center" style="width: 4%">Modificar</th >
                <?php } ?>
            </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
</main>

<script>
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogged(<?php echo $role;?>);
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';
?>
