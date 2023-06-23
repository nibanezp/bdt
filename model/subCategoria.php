<?php
/**
 * Modelo de subcategorías
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';

trait subCategoria{
    private $id;
    private $nombre;
    private $catId;

    /**
     * @param $id
     * @param $nombre
     * @param $catId
     */
    public function __construct($id=null, $nombre=null, $catId=null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->catId = $catId;
    }

    // Función que devuelve una lista de las subcategorías existentes en la base de datos.
    public function getSubCategorias($orderBy = "nombre", $logSql=false): bool|array|null {
        $query = "SELECT * FROM sub_categorias ORDER BY {$orderBy};";
        return $_SESSION['conn']->getRows($query, $logSql);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return subCategoria
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     * @return subCategoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * @param mixed $catId
     * @return subCategoria
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;
        return $this;
    }


}
