<?php
/**
 * Con este controlador evitamos que,mediante el uso de "inspeccionar" puedan acceder a nuestra plataforma sin haber
 * realizado un log-in correcto. Este controlador se ha añadido al inicio de todas las vistas donde lo he creído
 * conveniente.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/view/head.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';

// Si aun no ha hecho login, no queremos que al inspeccionar la pagina puedan acceder a diferentes apartados.
if(!isset($_SESSION['logged']) || $_SESSION['logged']==null) {
    echo "<script>window.location='?action=view&option=welcome';</script>";
    exit();
}

