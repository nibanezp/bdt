<?php
/**
 * En esta vista se mostraran las ofertas propias del usuario logueado.
 * Desde esta vista el usuario ademas podrá insertar nuevas ofertas.
 * Tiene su propio controlador para la inserción de ofertas (/bdt/controller/insertarOferta_ctl.php).
 * La carga de las ofertas propias se hace mediante el DAOCOntroller.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/logged_ctl.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Categoria.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/subCategoria.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';

$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;
$categorias = (new class { use Categoria; })->getCategorias();
$subCategorias = (new class { use subCategoria; })->getSubCategorias();
// Creamos una query teniendo en cuenta el rol del usuario conectado, y en caso que el usuario sea un admin, se pedirán
// todas las ofertas. Sin embargo, si el usuario no es admin, se piden SOLO las ofertas del usuario conectado.
$sql = "SELECT * FROM v_ofertas WHERE userId = '{$usuario->id}' ORDER BY catNombre, subCatNombre;";
$userOfertas = $_SESSION['conn']->getRows($sql);
$_SESSION['origen'] = "misOfertas"
?>
<main>
    <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
    <input type="hidden" id="origen" value="misOfertas"/>


    <div class="container">
        <form action="?action=ctl&option=insertarOferta" method="post"  style="top: 52%;">
            <div class="lightBorder" style="height:100px; display: flex; margin-left: 25%;">
                <?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/filtros_view.php';?>
            </div>

            <!-- Descripción textarea -->
            <div class="form-outline mb-4 centerButton" style="width: 50%;">
                <label class="form-label inputText" for="descr" style="margin-left: 0px;">Descripción (max. 220 caracteres)</label>
                <textarea class="form-control" rows="2"  name="desc" id="desc" maxlength="120"></textarea>
            </div>
            <button type="submit" name="btnInsertarOferta" class="btn btn-primary mb-4 centerButton">Insertar</button>
        </form>
        <table id="tblListado" class="table table-blue table-striped table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 4%">Oferta</th>
                    <th style="width: 11%">Categoría</th>
                    <th style="width: 20%">Sub categoría</th>
                    <th style="width: 45%">Descripción</th>
                    <th style="width: 4%">Valoración</th>
                    <th style="width: 4%">Votos</th>
                    <th class="text-center" style="width: 4%">Borrar</th >
                    <th class="text-center" style="width: 4%">Modificar</th >
                </tr>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>

    </div>
</main>
<script type="text/javascript">
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogged(<?php echo $role;?>);
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php'; ?>

