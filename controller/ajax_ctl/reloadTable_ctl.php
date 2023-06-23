<?php
/**
 * Controlador que nos devuelve las ofertas.
 * Si la petición que recibe es desde la vista de listado (/bdt/view/listado_view.php),
 * devolverá todas las ofertas menos las propias del usuario conectado. Por el contrario,
 * si la petición la recibe desde la vista de misOfertas (/bdt/view/misOfertas_view.php),
 * devolverá solo las ofertas propias del usuario conectado.
 */

/**
 * @var DAOController $conn
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
$categoria = $_REQUEST['categoria'];
$subcategoria = $_REQUEST['subcategoria'];
$userId = $_REQUEST['userId'];
$origen = $_REQUEST['origen'];

$sql = "SELECT * FROM v_ofertas WHERE categoriaId LIKE '%{$categoria}' AND subCatId LIKE '%{$subcategoria}' ";
if($origen==='listado'){
    $sql .= " AND userId != '{$userId}' ";
}elseif($origen==='misOfertas'){
    $sql .= " AND userId = '{$userId}' ";
}
$sql .= ";";
//echo $sql;
$res = $conn->getRows($sql);
echo json_encode($res, JSON_UNESCAPED_UNICODE);
