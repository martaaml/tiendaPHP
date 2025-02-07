<?php

namespace Lib;

use Error;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Lib\PDF;
use Exception;

class Mail
{
    //Funcion para mandar mail del pedido
    public function mandarMail(array $pedido)
    {

        $mail = new PHPMailer();
        try {
       
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '5c40b816a1b64e';
            $mail->Password = '3b882c184c1894';
            $mail->addAddress($_SESSION['user']['email']);
            $mail->Subject = 'Tu pedido ha sido confirmado';

            //Generar contenido del mail
            $pdf = new PDF();
            $ruta = $pdf->generarPDF();

            $mail->isHTML(true);
            $mail->Body = $_SESSION['user']['nombre'] . ' ha realizado un pedido de tienda';

            //Añadir archivo PDF
            $mail->addAttachment($ruta);

            //Enviar mail
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
