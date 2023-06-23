<?php
/**
 * Controlador que nos devulve un json con todos los usuarios registrados en la base de datos.
 */

/**
 * @var DAOController $conn
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';

$sql="SELECT * FROM v_users ORDER BY userId, username;";
$res = $conn->getRows($sql);
echo json_encode($res, JSON_UNESCAPED_UNICODE);



