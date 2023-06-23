<?php
/**
 * Modelo de valoraciones
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';

trait Valoraciones{
    public $valUserId;
    public $valoracion;
    public $votos;

    /**
     * @param $userId
     * @param $valoracion
     * @param $votos
     */
    public function __construct($valUserId, $valoracion, $votos) {
        $this->valUserId = $valUserId;
        $this->valoracion = $valoracion;
        $this->votos = $votos;
    }


    // Función para la actualización de valoraciones de un usuario.
    public function updateVal($userId){
        $sql = "INSERT INTO valoraciones (userId, valoracion, votos)
                VALUES ('{$userId}', '{$this->valoracion}', '{$this->votos}')
                ON DUPLICATE KEY UPDATE valoracion='{$this->valoracion}', votos ='{$this->votos}'";
        return $_SESSION['conn']->executeSql($sql);
    }

}
