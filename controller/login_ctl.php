<?php
/**
 * Controlador encargado  de la gestión de log-in de usuarios. Comprueba si el usuario existe o no, y si existe
 * comprueba si la contraseña es correcta o no.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/view/head.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/controller/validarUserPassword.php';

// Se comprueba que tanto es nombre de usuario como la contraseña hayan sido introducidos.
if (!empty($_REQUEST['user']) && !empty($_REQUEST['password'])) {
    $usuario_req = $_REQUEST['user'];
    $password = $_REQUEST['password'];
    $usuario = validarUserPassword($usuario_req, $password);
    $roleId = $usuario->roleId;

    switch ($roleId){
        case 1: // Rol de administrador
        case 2: // Rol de usuario
            $_SESSION['logged'] = true;
            $usuario = unserialize($_SESSION['usuario']);
            $role = $usuario->roleId;
            ?>
                <script type="text/javascript">
                    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
                    topMenuLogged(<?php echo $role;?>);
                    window.location= '?action=view&option=listado';
                </script>
            <?php
            break;
        case 3: // Rol de usuario baneado, el cual no tiene acceso a la plataforma.
            $_SESSION['logged'] = false;
            $res = $_SESSION['conn']->showAlert("Este usuario esta baneado. Ponte en contacto con la administración.");
            break;
        default:
            $_SESSION['logged'] = false;
            $_SESSION['conn']->showAlert("Login incorrecto");
            echo "<script>window.location='?action=view&option=login';</script>";
            break;
    }

}else {
    $_SESSION['logged'] = false;
    $_SESSION['conn']->showAlert("Rellene ambos campos.");
}
require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';

?>
