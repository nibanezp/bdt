<?php
/**
 * Controlador encargado del registro de usuarios. Se recogen los datos introducidos por el usuario y se procede a su
 * inserción en la base de datos mediante la función altaUsuario, la cual, a través de la función executeSql,
 * hará las comprobaciones pertinentes, como por ejemplo que el username y el email no existan en la base de datos.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Valoraciones.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';

$enc = new Encriptador();
$nombreReg = $_REQUEST['nombreReg'];
$apellidosReg = $_REQUEST['apellidosReg'];
$userName = $_REQUEST['userName'];
$passwordReg = $enc->encrypt($_REQUEST['passwordReg']);
$poblacionReg = $_REQUEST['poblacionReg'];
$emailReg = $_REQUEST['emailReg'];

$usuario = new Usuario(  null, $userName, $passwordReg, $emailReg, $nombreReg, $apellidosReg, $poblacionReg,
    10,null, null, 0 , 0);
$res = $usuario->altaUsuario();
if ($res) {
    echo "<script>window.location= '?action=view&option=login';</script>";

}else{
    echo "<script>window.location= '?action=view&option=register';</script>";

}

