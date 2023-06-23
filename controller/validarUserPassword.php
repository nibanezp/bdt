<?php
/**
 * Controlador encargado de la comprobación de la existencia de un usuario con la correspondiente contraseña.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';
function validarUserPassword($userName, $password){
    $enc = new Encriptador();
    $usuario = new Usuario();
    $usuario->getUserByUserName($userName);

    if (!is_null($usuario->id) && ($password == $enc->decrypt($usuario->password))) {
        $_SESSION['usuario'] = serialize($usuario);
        return $usuario;
    }

    $_SESSION['usuario'] = null;
    return false;

}
?>

