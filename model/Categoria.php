<?php
/**
 * Modelo de categoría, maneja las categorias.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
trait Categoria{
    private $id;
    private $catNombre;

    /**
     * @param $id
     */
    public function __construct($id=null, $catNombre=null){
        $this->id = $id;
        $this->catNombre = $catNombre;
    }


    // Función que devuelve una lista de las categorías existentes en la base de datos.
    public function getCategorias($orderBy = "nombre", $logSql=false): bool|array|null {
        $query = "SELECT * FROM categorias ORDER BY {$orderBy};";
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
     * @return Categoria
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCatNombre()
    {
        return $this->catNombre;
    }

    /**
     * @param mixed $nombre
     * @return Categoria
     */
    public function setCatNombre($catNombre)
    {
        $this->catNombre = $catNombre;
        return $this;
    }

}
