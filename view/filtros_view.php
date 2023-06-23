<?php
/**
 * He creado este fichero, el cual contiene 2 selectores.
 * uno con las categorías y otro con las subcategorías.
 * Dado que estos selectores se usan en distintas paginas, será mas cómodo importarlos.
 * Y como la cantidad de categorias que vamos trabajar es menor, no veo necesario usar ajax,
 * basta con una llamada a la función del DAOController que nos devolverá la lista de las mismas.
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Categoria.php';

$categorias = (new class { use Categoria; })->getCategorias();
$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;
$origen = $_SESSION['origen'];

?>
    <!-- Categoría select -->
    <div class="form-outline mb-4" style="float: left; margin-right: 15px;">
        <label class="form-label inputText" for="selCat"  style="margin-left: 0px;">Categorías</label>
        <select class="form-select"  name="selCat" id="selCat">
            <option value="%">Seleccione una opción</option>
            <?php
            foreach ($categorias as $data):?>
                <option value="<?php echo $data['id'];?>"><?php echo $data['nombre'];?></option>
            <?php endforeach;?>
        </select>
    </div>
    <!-- Sub-Categoría select -->
    <div class="form-outline mb-4" style="float: left">
        <label class="form-label inputText" for="selSubCat" style="margin-left: 0px;">Sub-categorías</label>
        <select class="form-select" name="selSubCat" id="selSubCat">
            <option value="%">Seleccione una opción</option>
        </select>
    </div>

<script>
    let selCat = document.getElementById("selCat");
    let selSubCat = document.getElementById("selSubCat");
    let userId = '<?php echo $usuario->id;?>';
    let origen = '<?php echo $origen;?>';
    let role = '<?php echo $role;?>';


    // Cargamos el selector de subcategorías en función de la categoría seleccionada
    $('#selCat').on('change', function () {
        $.ajax({
            url: "controller/ajax_ctl/reloadSubCats_ctl.php",
            data: {categoria: selCat.value},
            type: "POST",
            dataType: "json",
            success: function (json) {
                reloadSubCat(json)
            },
            error: function (xhr, textStatus, error) {
                console.log("xhr.responseText-->" + xhr.responseText);
                console.log("xhr.statusText-->" + xhr.statusText);
                console.log("textStatus-->" + textStatus);
                console.log("error-->" + error);
            }
        });
    });


    // Cargamos la dataTable en función de la categoría y la categoría seleccionadas.
    $('#selSubCat').on('change', function () {
        $.ajax({
            url: "controller/ajax_ctl/reloadTable_ctl.php",
            data: {userId: userId, origen: origen,
                categoria: selCat.value, subcategoria: selSubCat.value},
            type: "POST",
            dataType: "json",
            success: function (json) {
                populateTable(json, role)
            },
            error: function (xhr, textStatus, error) {
                console.log("xhr.responseText-->" + xhr.responseText);
                console.log("xhr.statusText-->" + xhr.statusText);
                console.log("textStatus-->" + textStatus);
                console.log("error-->" + error);
            }
        });
    });

    $(document).ready(function () {
        $('#selCat').val('%').trigger('change');
    });
</script>
