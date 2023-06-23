<?php
/**
 * Controlador encargado de la modificación de ofertas.
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Oferta.php';

$oferta = new Oferta();
$ofertaId = $_REQUEST['ofertaId'];
$categoriaId = $_REQUEST['selCat'];
$subCatId = $_REQUEST['selSubCat'];
$descripcion = $_REQUEST['desc'];

// Se comprueba que el usuario haya seleccionado categoría y subcategoría. Si no es asi se muestra un aviso,
// de lo contrario se procede a la modificación de la oferta seleccionada.
if ($categoriaId=='%' || $subCatId =='%') {
    $msg = "Selecciona la categoría y/o la subcategoría correcta";
    $_SESSION['conn']->showAlert($msg);
    echo  "<script>window.location='?action=view&option=modificarOferta&ofertaId=".$ofertaId."';</script>";
}else{
    $res = $oferta->modificarOferta($ofertaId, $categoriaId, $subCatId, $descripcion);
    echo "<script>window.location= '?action=view&option=".$_SESSION['origen']."';</script>";
}

