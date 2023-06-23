<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nestor
 * Date:17/04/2023
 * Time:
 */
$action = 'view';
$option = 'welcome';
if (isset($_REQUEST['action'])){
    $action=$_REQUEST['action'];
    $option = null;
    if(isset($_REQUEST['option'])) {
        $option = $_REQUEST['option'];
    }
}


switch ($action) {
    case 'ctl':
        include $_SERVER['DOCUMENT_ROOT'].'/controller/'.$option.'_'.$action.'.php';
        break;
    case 'view':
        include $_SERVER['DOCUMENT_ROOT'].'/'.$action.'/'.$option.'_'.$action.'.php';
        break;
    default:
        include $_SERVER['DOCUMENT_ROOT'].'/view/welcome_view.php';
        break;
}

?>

