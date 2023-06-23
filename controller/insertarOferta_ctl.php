<?php
/**
 * Controlador encargado de la inserción de nuevas ofertas en la base de datos
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Oferta.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';

$usuario = unserialize($_SESSION['usuario']);
$selCat = $_REQUEST['selCat'];
$subCatId = $_REQUEST['selSubCat'];
$desc = $_REQUEST['desc'];

// Se comprueba que el usuario haya seleccionado categoría y subcategoría. Si no es asi se muestra un aviso,
// de lo contrario se procede a la inserción de la nueva oferta.
if ($selCat=='%' || $subCatId =='%'){
    $msg = "Selecciona la categoría y/o la subcategoría correcta";
    $_SESSION['conn']->showAlert($msg);
}else {
    $oferta = new Oferta(null, $usuario->id, $selCat, $subCatId, $desc);
    $res = $oferta->insertarOferta();
}

echo "<script>window.location= '?action=view&option=misOfertas';</script>";
