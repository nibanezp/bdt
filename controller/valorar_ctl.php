<?php
/**
 * Controlador encargado de la actualización de datos referente a votos y horas, cuando un usuario X quiere valorar y/o
 * gratificar con N horas a un usuario Z.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';

$usuario = unserialize($_SESSION['usuario']);
$selectedUserId = $_REQUEST['id'];

$selectedUser = new Usuario();
$selectedUser->getUserByUserId($selectedUserId);
$valoracion = $selectedUser->valoracion;
$votosSelectedUser = $selectedUser->votos;

$voto = $_REQUEST['voto'];
$pHoras = $_REQUEST['pHoras'];

try {
    // Se calcula la nueva valoración del usuario en función de la valoración antigua, la nueva y la cantidad de votos.
    $newValoracion = (($valoracion * $votosSelectedUser) + $voto) / ($votosSelectedUser + 1);
}catch (DivisionByZeroError $e){
    $newValoracion = $voto;
}

// Se actualiza la valoración del usuario y se pagan las horas, si corresponde.
$res = $usuario->updateValoracion($selectedUserId, $newValoracion, $votosSelectedUser+1);
if ($pHoras!=null) {
    $res = $usuario->pagarHoras($selectedUserId, $pHoras);
}
if($res){
    $origen = $_SESSION['origen'];
    echo "<script>window.location= '?action=view&option=".$origen."';</script>";
}
