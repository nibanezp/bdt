<?php
/**
 * Desde este controlador se genera el cuerpo de un mensaje, que posteriormente se enviará por correo electrónico
 * incluyendo la contraseña.
 */


require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/sendMail.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';
$to = $_REQUEST['inUser'];


$pass = passRecovery($to);

$subject = "Recuperación de contraseña";
$body = "<br>";
$body .= "<h1 style='color:#000000;'>Usted ha realizado una petición para recuperar su contraseña.<br>";
$body .= "Su contraseña es: </h1>";
$body .= "<p style='color:#021b9b;'>{$pass}</p> <br><br><br>";
$body .= "<h1 style='color:#e00000;'>Si usted no ha realizado dicha petición, contacte con la administración ";
$body .= "respondiendo este correo.</h1>";
if($pass != 0) {
    try {
        $sender = new SendMail($to, $subject, $body);
        $res = $sender->sendMail();
        if ($res) {
            echo '<script type="text/javascript">alert("Enviado correctamente");</script>';
        } else {
            echo '<script type="text/javascript">alert("NO ENVIADO, intentar de nuevo");</script><br>'
                .$fail = "Mailer Error: " . $this->mail->ErrorInfo;
        }
    }catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
else{
    echo '<script type="text/javascript">alert("El email introducido no esta registrado");</script>';
}

function passRecovery($email): bool|string{
    $enc = new Encriptador();
    $res = false;
    $sql = "SELECT passw FROM users WHERE email='$email';";
    $row = $_SESSION['conn']->getRow($sql);
    if (!is_null($row)) {
        $res = $enc->decrypt($row['passw']);
    }
    return $res;
}

echo "<script>window.location= '?action=view&option=login';</script>";
