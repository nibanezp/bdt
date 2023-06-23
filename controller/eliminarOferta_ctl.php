<?php
/**
 * Controlador que recibe el id de una oferta y elimina dicha oferta de la base de datos.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Oferta.php';
$ofertaId = $_REQUEST['ofertaId'];
$oferta = new Oferta();
$res = $oferta->eliminarOferta($ofertaId);

if($res){
    $origen = $_SESSION['origen'];
    echo "<script>window.location= '?action=view&option=".$origen."';</script>";
}
