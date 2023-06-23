<?php
/**
 * Modelo de Role, maneja los roles de usuario.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';

trait Role{
    public $id;
    public $roleName;
    function __construct($id=null, $roleName=null){
        $this->id =$id;
        $this->roleName = $roleName;
    }

}
