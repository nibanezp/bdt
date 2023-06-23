<?php
/**
 * Controlador encargado del envío de correos cuando un usuario X desea hacerle saber a otro usuario Z que está
 * interesado en una de sus ofertas.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Oferta.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/sendMail.php';

$usuario = unserialize($_SESSION['usuario']);

$userToContact = new Usuario();
$userId = $_REQUEST['userId'];
$userToContact->getUserByUserId($userId);

$oferta = new Oferta();
$ofertaId = $_REQUEST['ofertaId'];
$oferta->autoFillOferta($ofertaId);
var_dump($usuario);
$to = $userToContact->email;
$subject = 'Nuevo contacto';
$body = "<br>";
$body .= "El usuario " .$usuario->username. " esta interesado en tu siguiente oferta: ";
$body .= "<h1 style='color:#000000;'>ID de la oferta: {$oferta->getId()} <br>";
$body .= "<h1 style='color:#000000;'>Username interesado: {$usuario->username} <br>";
$body .= "<h1 style='color:#000000;'>Nombre interesado: {$usuario->nombre} <br>";
$body .= "<h1 style='color:#000000;'>Descripcion de la oferta: {$oferta->getDescripcion()} <br>";
$body .= "<h1 style='color:#000000;'>Email interesado: {$usuario->email} <br>";
$body .= "<h1 style='color:#000000;'>Si lo deseas, puedes ponerte en contacto con él a través de su dirección de correo.";

try {
    $sender = new SendMail($to, $subject, $body);
    $res = $sender->sendMail();
    if($res) {
        echo '<script type="text/javascript">
        alert("Se ha enviado un mail al usuario ofertante. Por favor espere a que él se ponga en contacto con usted.");
        </script>';
    }else{
        echo '<script type="text/javascript">alert("NO ENVIADO, intentar de nuevo");</script><br>'
            .$fail = "Mailer Error: " . $this->mail->ErrorInfo;

    }
}catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
} finally {
    $origen = $_SESSION['origen'];
    echo "<script>window.location= '?action=view&option=".$origen."';</script>";
}
