<?php
/**
 * Modelo de Oferta, a la cual se le añade Categoría y subCategoría
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Categoria.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/subCategoria.php';

class Oferta{
    use Categoria;
    use subCategoria;
    private $id;
    private $userId;
    private $categoriaId;
    private $subCatId;
    private $descripcion;

    /**
     * @param $id
     * @param $userId
     * @param $categoriId
     * @param $subCatId
     * @param $descripcion
     */
    public function __construct($id=null, $userId=null, $categoriaId=null, $subCatId=null, $descripcion=null){
        $this->id = $id;
        $this->userId = $userId;
        $this->categoriaId = $categoriaId;
        $this->subCatId = $subCatId;
        $this->descripcion = $descripcion;
    }


    // Función que inserta una nueva oferta en la base datos.
    public function insertarOferta(){
        $sql = "INSERT INTO ofertas (userId, categoriaId, subCatId, descripcion)
        VALUES ('$this->userId', '{$this->categoriaId}', '{$this->subCatId}', '{$this->descripcion}');";
        return $_SESSION['conn']->executeSql($sql);
    }


    // Función que modifica la oferta indicada mediante un identificador ($ofertaID) con lo datos recibidos.
    public function modificarOferta($ofertaId, $categoriaId, $subCatId, $descripcion){
        $sql = "UPDATE ofertas 
                SET categoriaId = '".$categoriaId."',
                    subCatId = '".$subCatId."',
                    descripcion = '".$descripcion."'
                WHERE id=".$ofertaId.";";
        return $_SESSION['conn']->executeSql($sql);
    }


    // Función que elimina la oferta indicada mediante un identificador ($ofertaID).
    public function eliminarOferta($ofertaId){
        $sql = "DELETE FROM ofertas WHERE id=$ofertaId;";
        return $_SESSION['conn']->executeSql($sql);
    }


    // Función que recoge una oferta de la base de datos y nos rellena la variable de tipo Oferta con los valores
    // obtenidos.
    public function autoFillOferta($ofertaId, $logSql=false){
        $sql = "SELECT * FROM v_ofertas WHERE id='{$ofertaId}';";
        $row = $_SESSION['conn']->getRow($sql, $logSql);
        if (!is_null($row)) {
            $this->id = $row['id'];
            $this->userId = $row['userId'];
            $this->categoriaId = $row['categoriaId'];
            $this->catNombre = $row['catNombre'];
            $this->subCatId = $row['subCatId'];
            $this->subCatNombre = $row['subCatNombre'];
            $this->descripcion = $row['descripcion'];

        }else{
            return false;
        }
    }

    /**
     * @return mixed|null
     */
    public function getId(): mixed {
        return $this->id;
    }

    /**
     * @param mixed|null $id
     * @return Oferta
     */
    public function setId(mixed $id): Oferta {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getUserId(): mixed {
        return $this->userId;
    }

    /**
     * @param mixed|null $userId
     * @return Oferta
     */
    public function setUserId(mixed $userId): Oferta {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getCategoriaId(): mixed {
        return $this->categoriaId;
    }

    /**
     * @param mixed|null $categoriaId
     * @return Oferta
     */
    public function setCategoriaId(mixed $categoriaId): Oferta {
        $this->categoriaId = $categoriaId;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getSubCatId(): mixed {
        return $this->subCatId;
    }

    /**
     * @param mixed|null $subCatId
     * @return Oferta
     */
    public function setSubCatId(mixed $subCatId): Oferta {
        $this->subCatId = $subCatId;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getDescripcion(): mixed {
        return $this->descripcion;
    }

    /**
     * @param mixed|null $descripcion
     * @return Oferta
     */
    public function setDescripcion(mixed $descripcion): Oferta {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCatNombre() {
        return $this->catNombre;
    }

    /**
     * @param mixed $catNombre
     * @return Oferta
     */
    public function setCatNombre($catNombre) {
        $this->catNombre = $catNombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubCatNombre() {
        return $this->subCatNombre;
    }

    /**
     * @param mixed $subCatNombre
     * @return Oferta
     */
    public function setSubCatNombre($subCatNombre) {
        $this->subCatNombre = $subCatNombre;
        return $this;
    }



}
