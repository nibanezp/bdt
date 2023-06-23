<?php

/**
 * Este fichero contiene el head de la página, ya que siempre va a ser el mismo,
 * así sera mas fácil de importar.
 * Este mismo fichero, importara el header del html.
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BancoDelTiempo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Importación de bootstrap 5.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <!-- -->
    <!-- Importación de jquery y datatables-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
    <!-- -->
    <!-- Refresco del css. Así evitamos cargar una versión vieja que haya sido almacenada en la caché del navegador -->
    <link rel="stylesheet" href="view/css/estilos.css?v=<?php echo time(); ?>" />
    <script src="./utilities/scripts.js?v=<?php echo time(); ?>"></script>
    <!-- -->
<!--    <script src="./utilities/scripts.js"></script>-->
</head>
    <body class="fondo">
        <?php require_once $_SERVER['DOCUMENT_ROOT'].'/view/header.php';?>
        <script type="text/javascript">
            // Se oculta el top menu, ya que de inicio no hay ningún usuario conectado
            topMenuLogout();
        </script>

