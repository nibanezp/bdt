<?php
/**Fichero que contiene la vista para la inserción de nuevas categorías y subcategorías.
 * Tiene su propio controlador para inserción de nuevos datos (/bdt/controller/insertarCategoria_ctl.php)
 */
require_once $_SERVER['DOCUMENT_ROOT'] .'/controller/logged_ctl.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Categoria.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/subCategoria.php';

$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;
$categorias = (new class { use Categoria; })->getCategorias();
$subCategorias = (new class { use subCategoria; })->getSubCategorias();
?>


<main class="centerForm ">
    <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
    <input type="hidden" id="origen" value="insertarCategoria"/>

    <form class="" action="?action=ctl&option=insertarCategoria" method="post" >
        <div class="lightBorder" style="height:100px; width: 100%;">
            <div class="form-outline mb-4 " style="float: left; margin-right: 15px;">
                <label class="form-label inputText" for="categoria" style="margin-left: 0px;">Categoría</label>
                <textarea class="form-control" rows="1"  name="categoria" id="categoria"></textarea>
            </div>
            <div class="form-outline mb-4" style="float: left">
                <label class="form-label inputText" for="subCat" style="margin-left: 0px;">subCategoría</label>
                <textarea class="form-control" rows="1"  name="subCat" id="subCat" maxlength="120"></textarea>
            </div>
        </div>
        <button type="submit" name="btnInsertarSubCat" class="btn btn-primary mb-4 centerButton">Insertar</button>
    </form>
</main>


<script type="text/javascript">
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogged(<?php echo $role;?>);

    $(document).ready(function () {
        $('#tblListadoCategorias').DataTable({
            order: [[0, 'asc'], [1, 'asc'], [2, 'asc']], // Columnas por las que queremos ordenar
            ordering:true,  // Permite que las columnas sean ordenadas haciendo clic en la cabecera
            lengthMenu: [5, 10, 15, 20, 50, 100, 500], // Menu desplegable "Show entries"
            pageLength: 10, // Valor inicial del menu desplegable "Show entries"
            oLanguage: {"sInfo" : "Mostrando _START_ de _END_ de _TOTAL_ entradas"},//Texto a mostrar en la sección info
            info: true, // Muestra(true) u oculta(false) la sección info: "Showing 1 to 10 of 16 entries paging: true,
            scrollY: true,
            scrollX: true,

        });
    });
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';

?>
