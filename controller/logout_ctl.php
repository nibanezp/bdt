<?php
/**
 * Este controlador nos devuelve a la página de inicia de la plataforma, e inicializa las variables logged y usuario.
 */

$_SESSION['logged'] = false;
$_SESSION['usuario'] = null;

require_once $_SERVER['DOCUMENT_ROOT'].'/view/head.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/welcome.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/footer.php';

