<?php
/**
 * Clase para el manejo de correos
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPMailer/src/SMTP.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/DAOController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utilities/Encriptador.php';

class SendMail{

    private $mail;
    public $to;
    public $subject;
    public $body;

    function __construct($to, $subject, $body){
        $this->mail = new PHPMailer\PHPMailer\PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->IsHTML(true);
        //Configuración servidor mail
        $this->mail->CharSet = "UTF-8";
        $this->mail->SMTPAuth = true; //seguridad
        $this->mail->SMTPSecure = 'tls'; //seguridad
        $this->mail->Host = "smtp.gmail.com"; // servidor smtp
        $this->mail->Port = 587; //puerto
        $this->mail->From = "bancodeltiempo2023@gmail.com"; //remitente
        $this->mail->Username = 'bancodeltiempo2023@gmail.com'; //nombre usuario
        $this->mail->Password = 'zipuhcbztxwiigyk'; //contraseña
        $this->mail->AddAddress($to);
        $this->mail->Subject = $subject;
//        $this->mail->Body = $body;
        $plantilla = "./view/imagenes/mailTemplate.php";
        $texto = file_get_contents($plantilla);
        $texto = str_replace("%cuerpo%", $body, $texto);
        $this->mail->MsgHTML($texto);
        $this->mail->AddEmbeddedImage("./view/imagenes/relojFondo.png", "relojId");
    }

    public function sendMail(){
        if ($this->mail->Send()) {
            return true;
        } else {
            return $this->mail->ErrorInfo;
        }


    }
}


