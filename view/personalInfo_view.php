<?php
/**
 * En esta vista vemos nuestra información de usuario. Desde ella el usuario puede cambiar la información personal y
 * la contraseña. El administrador ademas puede cambiar los votos y la valoracion. También puede cambiar el rol del
 * usuario, incluso banearlo si fuera necesario.
 * Su controlador es /bdt/controller/personalInfo_ctl.php
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/logged_ctl.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';

$origen = $_SESSION['origen'];

$enc = new Encriptador();
$selectedUser = new Usuario();

$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;

$userId = $_REQUEST['userId'];
$selectedUser->getUserByUserId($userId);

$sql = "SELECT * FROM role ORDER BY id, roleName;";
$roles = $_SESSION['conn']->getRows($sql);
?>

<main>
    <!-- Con esta "variable" sabemos de donde venimos, asi en una sola función podemos cargar unos campos u otros -->
    <input type="hidden" id="origen" value="personalInfo"/>

    <div style="display: flex;justify-content: center; ">
        <form action="?action=ctl&option=personalInfo" method="post" id="userForm" onSubmit="return checkForm(event)">
            <div style="float: left">
<!-- ########################################### DATOS DE REGISTRO ################################################# -->
                <div class="container lightBorder" style="height:190px;">
                    <!-- Username input -->
                    <div class="form-outline mb-4">
                        <label class="form-label inputText" for="userName">Username</label>
                        <input type="text" name="userName" id="userName" class="form-control" required
                               value="<?php echo $selectedUser->username;?>">
                    </div>
                    <!-- Email input -->
                    <div class="form-outline mb-4" style="float: left;">
                        <label class="form-label inputText" for="emailReg">Email address</label>
                        <input class="form-control" type="email" name="emailReg" id="emailReg" required
                               value="<?php echo $selectedUser->email;?>">
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-4" style="float: left; margin-left: 15px;">
                        <label class="form-label inputText" for="passReg">Contraseña<br></label>
                        <label class="swtich-container">
                            <input type="checkbox" id="switch" onclick="checker();">---<!--guiones para centrar palabra Password-->
                            <div class="slider">
                                <span class="off">SHOW</span>
                                <span class="on">HIDE</span>
                            </div>
                        </label>
                        <input class="form-control" type="password" name="password" id="password" readonly required
                               style=" margin-right: 15px;" value="<?php echo $enc->decrypt($selectedUser->password);?>">
                    </div>
                </div>
<!-- ############################################ NUEVA CONTRASEÑA ################################################# -->
                <div class="container lightBorder" style="height:95px;">
                    <!-- Nuevo password input -->
                    <div class="form-outline mb-4" style="float: left;">
                        <label class="form-label inputText" for="newPass">Nueva contraseña</label>
                        <input type="text" name="newPass" id="newPass" class="form-control">
                    </div>
                    <!-- Repetir nuevo password input -->
                    <div class="form-outline mb-4" style="float: left; margin-left: 15px;">
                        <label class="form-label inputText" for="repeatNewPass"> Repetir contraseña</label>
                        <input type="text" name="repeatNewPass" id="repeatNewPass" class="form-control">
                    </div>
                </div

<!-- ############################################ DATOS PERSONALES ################################################# -->
                <div class="container lightBorder" style="height:190px;">
                    <!-- Nombre input -->
                    <div class="form-outline mb-4" style="float: left;">
                        <label class="form-label inputText" for="nombreReg">Nombre</label>
                        <input class="form-control" type="text" name="nombreReg" id="nombreReg" required
                               value="<?php echo $selectedUser->nombre; ?>">
                    </div>
                    <!-- Apellidos input -->
                    <div class="form-outline mb-4" style="float: left; margin-left: 15px;">
                        <label class="form-label inputText" for="apellidosReg"> Apellidos</label>
                        <input class="form-control" type="text" name="apellidosReg" id="apellidosReg" required
                               value="<?php echo $selectedUser->apellidos; ?>">
                    </div>
                    <!-- Población input -->
                    <div class="form-outline mb-4">
                        <label class="form-label inputText" for="poblacionReg"> Población</label>
                        <input class="form-control" type="text" name="poblacionReg" id="poblacionReg" required
                               value="<?php echo $selectedUser->poblacion; ?>">
                    </div>
                </div>
            </div>

<!-- ############################################## OTROS DATOS #################################################### -->
            <div style="float: left; margin-left: 15px;">
                <div class="userForm lightBorder" style="width: 400px">
                    <!-- userId input -->

                    <label class="inputText" for="userId" style="display: inline-block;">User Id</label>
                    <input  class="form-control" type="number" name="userId" id="userId" required readonly
                            value="<?php echo $selectedUser->id;?>">
                    <!-- Valoracion input -->
                    <label class="inputText" for="valoracion">Valoración sobre 10</label>
                    <input  class="form-control" type="number" name="valoracion" id="valoracion" min="0" max="10" step="0.1" required
                           value="<?php echo $selectedUser->valoracion;?>">
                    <!-- Votos input -->
                    <label class="inputText" for="votos">Votos</label>
                    <input  class="form-control" type="number" name="votos" id="votos" required
                           value="<?php echo $selectedUser->votos;?>">
                    <!-- Horas input -->
                    <label class="form-label inputText" for="horas">Horas</label>
                    <input  class="form-control" type="number" name="horas" id="horas" required
                           value="<?php echo $selectedUser->horas;?>">

                    <!-- Role select -->
                    <label class="form-label inputText" for="selRole"  style="margin-left: 0px;">Role</label>
                    <select class="form-select" name="selRole" id="selRole" required>
                        <?php foreach ($roles as $value):?>
                            <option value="<?php echo $value['id'];?>"><?php echo $value['roleName'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div>
            <button type="submit" name="btnRegister" id="btnRegister" class="btn btn-primary mb-4 centerButton"
                    style="float: left">Aceptar</button>
            <button class="btn btn-primary " type="button" id="btnCancelar" name="btnCancelar"
                    onclick="volverAtras(<?php echo $origen; ?>)" style="float: left">Cancelar</button>
            </div>
        </form>
    </div>
</main>

<script type="text/javascript">
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogged(<?php echo $role;?>);

    //Controlamos que el usuario no cambie campos que no debe.
    let readOnly = true;
    let role = <?php echo $role;?>;
    if(role===1){
        readOnly=false;
    }
    document.getElementById('userName').readOnly  = readOnly;
    document.getElementById('valoracion').readOnly  = readOnly;
    document.getElementById('votos').readOnly  = readOnly;
    document.getElementById('horas').readOnly  = readOnly;
    document.getElementById('selRole').disabled = readOnly;

    // Ponemos el valor correspondiente al usuario que estamos viendo.
    let selRole = document.getElementById("selRole");
    selRole.value = '<?php echo $selectedUser->roleId; ?>';

</script>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php'; ?>
