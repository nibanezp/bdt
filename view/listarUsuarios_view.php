<?php
/**
 * En este fichero se muestra una lista con todos los usuarios (en formato tabla) existentes en la base de datos.
 * Dado que podría llegar a haber un gran número de usuarios registrados,
 * he optado por usar ajax para dar mayor agilidad.
 * Tiene su propio controlador (/bdt/controller/ajax_ctl/listarUsuarios_ctl.php),
 * el cual nos devolverá un json con todos los usuarios existentes.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/logged_ctl.php';

$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;
$sql="SELECT * FROM v_users ORDER BY userId, username;";
$listaUsuarios = $_SESSION['conn']->getRows($sql);
$_SESSION['origen'] = 'listarUsuarios'
?>
<main>
    <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
    <input type="hidden" id="origen" value="listarUsuarios"/>

    <div style="display: flex; justify-content: center;">
        <table id="tblListadoUsers" class="table table-blue table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width: auto">Id</th>
                    <th style="width: auto">Username</th>
                    <th style="width: auto">Pass</th>
                    <th style="width: auto">Email</th>
                    <th style="width: auto">Nombre</th>
                    <th style="width: auto">Apellidos</th>
                    <th style="width: auto">Población</th>
                    <th style="width: auto">Horas</th>
                    <th style="width: auto">roleId</th>
                    <th style="width: auto">Role</th>
                    <th style="width: auto">Valoración</th>
                    <th style="width: auto">Votos</th>
                    <th class="text-center" style="width: auto">Borrar</th >
                    <th class="text-center" style="width: auto">Modificar</th >
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

    $(document).ready(function () {
        $.ajax({
            url: "controller/ajax_ctl/listarUsuarios_ctl.php",
            data: {},
            type: "POST",
            dataType: "json",
            success: function (json) {
                populateUsuarios(json)
            },
            error: function (xhr, textStatus, error) {
                console.log("xhr.responseText-->" + xhr.responseText);
                console.log("xhr.statusText-->" + xhr.statusText);
                console.log("textStatus-->" + textStatus);
                console.log("error-->" + error);
            }
        });
    });
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';

?>
<?php
