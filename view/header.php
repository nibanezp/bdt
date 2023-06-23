<?php
/**
 * Este fichero contiene el header de la página, ya que siempre va a ser el mismo,
 * así sera mas fácil de importar.
 * Consta de un menu desplegable solo accesible para administradores, un menu de usuario
 * y los botones para registrarse, hacer login y logout.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';
$userId = 0;
if (isset($_SESSION['usuario'])) {
    $usuario = unserialize($_SESSION['usuario']);
    $userId = $usuario->userId;
}
?>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 mb-2 border-bottom">
    <ul class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                id="adminOpts">
            Admin options
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?action=view&option=listarUsuarios">Listar usuarios</a></li>
            <li><a class="dropdown-item" href="?action=view&option=insertarCategoria">Añadir categorias</a></li>
<!--            <li><a class="dropdown-item" href="#">Under construction</a></li>-->
            <li><hr class="dropdown-divider"></li>
<!--            <li><a class="dropdown-item" href="#">Under construction</a></li>-->
        </ul>
    </ul>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="?action=view&option=listado" class="nav-link px-2 link-primary" id="listado"><u>Listado</u></a></li>
        <li><a href="?action=view&option=misOfertas" class="nav-link px-2 link-primary" id="misOfertas"><u>Mis ofertas</u></a></li>
        <li><a href="?action=view&option=personalInfo&userId=<?php echo $userId?>" class="nav-link px-2 link-primary" id="personalInfo"><u>Información personal</u></a></li>
    </ul>

    <div class="col-md-3 text-center">
        <!-- Botón de registro Sign-up -->
        <form action="?action=view&option=register" method="post" style="float: left">
            <button type="submit" class="btn btn-primary me-2" id="btnSignUp">Sign-up</button>
        </form>
        <!-- Botón de Login -->
        <form action="?action=view&option=login" method="post" style="float: left">
            <button type="submit" class="btn btn-outline-primary me-2" id="btnLogin">Login</button>
        </form>
        <!-- Botón de Logout -->
        <form action="?action=ctl&option=logout" method="post" >
            <button type="submit" class="btn btn-outline-primary" id="btnLogout">Logout</button>
        </form>
    </div>
</header>
