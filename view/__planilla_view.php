<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/view/head.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';

// Si aun no ha hecho login, no queremos que al inspeccionar la pagina puedan acceder a diferentes apartados.
if(!isset($_SESSION['logged']) || $_SESSION['logged']==null) {
    echo "<script>window.location= '?action=view&option=welcome';</script>";
    exit();
}
$usuario = unserialize($_SESSION['usuario']);
$role = $usuario->roleId;
?>

<main>





</main>

<script type="text/javascript">
    // Se muestra la parte del top menu que nos interesa en función del rol de usuario
    topMenuLogged(<?php echo $role;?>);
</script>
