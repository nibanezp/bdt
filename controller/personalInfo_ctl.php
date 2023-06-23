<?php
/**
 * Controlador encargado de las modificaciones propias del usuario.
 * En caso que el usuario desee cambiar su contraseña, se le hace introducir dos veces la nueva contraseña y que ambas
 * coincidan.
 * Si el usuario no quiere cambiar su contraseña, se comprueba que la antigua no sea nula. El resto de campos que
 * necesitan algún tipo de verificación, como el formato del email,
 * se verifican en la propia vista (/bdt(view/perosonalInfo_view.php)
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';

$origen = $_SESSION['origen'];
$enc = new Encriptador();
$usuario = unserialize($_SESSION['usuario']);
$userId = $_REQUEST['userId'];
$userName = $_REQUEST['userName'];
$emailReg = $_REQUEST['emailReg'];
$password = $_REQUEST['password'];
$newPass = $_REQUEST['newPass'];
$repeatNewPass = $_REQUEST['repeatNewPass'];
$nombreReg = $_REQUEST['nombreReg'];
$apellidos = $_REQUEST['apellidosReg'];
$poblacion = $_REQUEST['poblacionReg'];
$valoracion = $_REQUEST['valoracion'];
$votos = $_REQUEST['votos'];
$horas = $_REQUEST['horas'];

// Dado que si el usuario no es admin, el selector de rol de la vista va a devolver '', recogemos el rol del usuario
// conectado, si no es admin, no cambiaremos el rol a la hora de las modificaciones de la información personal, ya que
// el rol es un campo que solo pueden modificar los administradores (rol == 1)
$role = $usuario->roleId;
if($usuario->roleId==1) {
    $role = $_REQUEST['selRole'];
}

// Se comprueba si se quiere modificar la contraseña.
if(($newPass!=null)&&($newPass==$repeatNewPass)) {
    $password = $newPass;
}elseif($newPass!=$repeatNewPass){
    $_SESSION['conn']->showAlert("Las contraseñas no coinciden.");
}elseif($password==null){
    $_SESSION['conn']->showAlert("La contraseña no puede estar vacía.");
}

$password = $enc->encrypt($password);
$usuario = new Usuario($userId, $userName, $password, $emailReg, $nombreReg, $apellidos, $poblacion,
    $horas, $role, null, $valoracion, $votos);
$res = $usuario->modificarUsuario();


echo "<script>window.location= '?action=view&option=".$origen."';</script>";
