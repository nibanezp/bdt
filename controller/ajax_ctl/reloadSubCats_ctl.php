<?php
/**
 * Controlador que nos devuelve las subCategorias al mover el select (selSubCat) de la vista /bdt/view/filtros_view.php
 */

/**
 * @var DAOController $conn
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';

$categoria = $_REQUEST['categoria'];
$sql = "SELECT * FROM sub_categorias WHERE categoriasId LIKE '{$categoria}';";

$res = $conn->getRows($sql);
echo json_encode($res, JSON_UNESCAPED_UNICODE);
