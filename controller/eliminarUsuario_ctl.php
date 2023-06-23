<?php
/**
 * Controlador que recibe el id de un usuario y elimina dicho usuario de la base de datos.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';
$userId = $_REQUEST['userId'];
$usuarioE = new Usuario();
$res = $usuarioE->eliminarUsuario($userId);

if($res){
    $origen = $_SESSION['origen'];
    echo "<script>window.location= '?action=view&option=".$origen."';</script>";
}
