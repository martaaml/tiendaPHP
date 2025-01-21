<?php
namespace Lib;

use Error;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Lib\PDF;

Class Mail{
    //Metodo para mandar mail del pedido

    public function mandarMail(array $pedido){

        $mail = new PHPMailer();

try{
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMPTSecure=$_ENV['SMTP_SECURE'];
    $mail->Port = $_ENV['SMTP_PORT'];

    $mail->setFrom($_ENV['SMTP_EMAIL'], 'MARO STORE');
    $mail->addAddress($_SESSION['user']['email']);+
    $mail->Subject = 'Tu pedido ha sido confirmado';

    //Generar contenido del mail
    $pdf = new PDF();
    $pdf->generarPDF($pedido);
    $mail->isHTML(true);
    $mail->Body = $pedido['nombre'].' ha realizado un pedido de tienda';

    //Añadir archivo PDF
    $mail->addAttachment($pdf->generarPDF($pedido));

    //Enviar mail
    $mail->send();
    return true;
}catch(Exception $e){
    error_log($e->getMessage());
    return false;
}

    }
}