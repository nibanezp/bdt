<?php
/**
 * Esta vista nos muestra el usuario seleccionado,
 * desde ella podemos contactar para indicar nuestro interés por alguna de sus ofertas,
 * puntuar y pagar las horas pendientes, si las hubiera.
 * Su controlador es /bdt/controller/valorar_ctl.php
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/logged_ctl.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Oferta.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';

$origen = $_SESSION['origen'];
$selectedUser = new Usuario();
$oferta = new Oferta();
$ofertaId = $_REQUEST['ofertaId'];
$oferta->autoFillOferta($ofertaId);
$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;

$userId = $_REQUEST['userId'];
$selectedUser->getUserByUserId($userId);

$sql = "SELECT * FROM role ORDER BY id, roleName;";
$roles = $_SESSION['conn']->getRows($sql);

?>

<main>
    <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
    <input type="hidden" id="origen" value="ofertante"/>
    <div class="centerForm" style="top: 12%;">
        <h3>Información del ofertante</h3>
    </div>
    <div class="centerForm" style="top: 25%;">
        <div class="lightBorder" style="height:190px; float:left">
            <!-- Username label -->
            <label class="form-label inputText">Username: <?php echo $selectedUser->username;?></label><br>
            <!-- Nombre label -->
            <label class="form-label inputText">Nombre: <?php echo $selectedUser->nombre;?></label><br>
            <!-- Apellidos label -->
            <label class="form-label inputText">Apellidos: <?php echo $selectedUser->apellidos;?></label><br>
            <!-- Población label -->
            <label class="form-label inputText">Población: <?php echo $selectedUser->poblacion;?></label><br>
            <!-- Contactar href -->
            <?php if($usuario->horas > 0){?>
                <a href="?action=ctl&option=contactar&userId=<?php echo $selectedUser->id;?>&ofertaId=<?php echo $ofertaId?>">Contactar</a>
            <?php }else{ ?>
                <label class="form-label inputText" style="color: red;">
                    No tienes horas para contactar con este usuario. <br>
                    Deberias compartir tus habilidades con el resto de usuarios para poder seguir aprendiendo. <br>
                </label><br>
            <?php } ?>
        </div>

        <div class="lightBorder" style="height:190px; float:left; margin-left: 10px;">
            <!-- Valoracion label -->
            <label class="form-label inputText">Valoración sobre 10: <?php echo $selectedUser->valoracion;?></label><br>
            <!-- Votos label -->
            <label class="form-label inputText">Votos: <?php echo $selectedUser->votos;?></label><br>
            <!-- Horas label -->
            <label class="form-label inputText">Horas: <?php echo $selectedUser->horas;?></label><br>
            <!-- Role label -->
            <label class="form-label inputText">Role: <?php echo $selectedUser->roleName;?></label><br>
        </div>
    </div>

    <form class="centerForm" style="top: 50%;" action="?action=ctl&option=valorar&id=<?php echo $selectedUser->id;?>"
          method="post" id="userForm">
        <div class="lightBorder" style="height:190px; float:left">
            <!-- Username label -->
            <label class="form-label inputText">Id oferta: <?php echo $oferta->getId();?></label><br>
            <!-- Nombre label -->
            <label class="form-label inputText">Categoría: <?php echo $oferta->getCatNombre();?></label><br>
            <!-- Apellidos label -->
            <label class="form-label inputText">Sub categoía: <?php echo $oferta->getSubCatNombre();?></label><br>
            <!-- Población label -->
            <label class="form-label inputText">Descripcíon: <?php echo $oferta->getDescripcion();?></label><br>
        </div>

        <div class="lightBorder" style="height:190px; float:left; margin-left: 10px;">
            <!-- Votar input -->
            <label class="inputText" for="voto"">Votar:
                <input class="form-control" type="number" min="0" max="10" step="0.1" name="voto" id="voto" required
                       value="<?php echo $selectedUser->valoracion;?>">
            </label><br>

            <!-- Pagar horas input -->
            <label class="form-label inputText" for="pHoras">Pagar horas:
                <input class="form-control" type="number" min="0" max="<?php echo $usuario->horas;?>"
                       name="pHoras" id="pHoras" required value="0">
            </label>
        </div>
        <div>
        <button type="submit" name="btnRegister" id="btnRegister" class="btn btn-primary">Aceptar</button>
        <button class="btn btn-primary " type="button" id="btnCancelar" name="btnCancelar"
                onclick="volverAtras(<?php echo $origen; ?>)">Cancelar</button>
        </div>
    </form>




</main>

<script type="text/javascript">
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogged(<?php echo $role;?>);

</script>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php'; ?>
