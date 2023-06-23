<?php
/**
 * Controlador desde el cual insertaremos nuevas categorias y subcategorias
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Categoria.php';

$categoria = trim($_REQUEST['categoria']);
$subCat = trim($_REQUEST['subCat']);

// Introducimos una categoría, y comprobamos si existe, si no existe, la introducimos como nueva.
if ($categoria==null){
    $_SESSION['conn']->showAlert("La categoría no puede estar vacía.");
    echo "<script>window.location= '?action=view&option=insertarCategoria';</script>";
    exit();
}else{
    // Comprobamos si la categoría existe, de ser así cogemos su id, de lo contrario la insertamos en la BD y cogemos
    // el id de la nueva categoría.
    $sql = "SELECT * FROM categorias WHERE nombre = '$categoria';";
    $catRes = $_SESSION['conn']->getRows($sql);
    if ($catRes!=null){
        $catId = $catRes[0]['id'];
    }else{
        $sql = "INSERT INTO categorias (nombre) VALUES ('".$categoria."');";
        $_SESSION['conn']->executeSql($sql);
        $catId = $_SESSION['conn']->getLastInsertedId($sql);
    }
}
if ($subCat!=null){
    $sql = "SELECT * FROM sub_categorias WHERE nombre = '$subCat' and categoriasId='$catId';";
    $subCatRes = $_SESSION['conn']->getRows($sql);
    // Comprobamos que la subcategoría no pertenece a la categoría introducida, de ser así la introducimos en la BD
    if($subCatRes!=null){
        $_SESSION['conn']->showAlert("La sub-categoría {$subCat} ya esta asociada a a la categoría {$categoria}.");
    }
    // Si la subcategoría no existe o no pertenece a la categoría introducida, la insertamos en la BD
    if($subCatRes==null){
        $sql = "INSERT INTO sub_categorias (nombre, categoriasId) VALUES ('".$subCat."',".$catId." );";
        $_SESSION['conn']->executeSql($sql);
    }
}
echo "<script>window.location= '?action=view&option=insertarCategoria';</script>";
