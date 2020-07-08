<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';
class MailConfigHelper {

    public static function getMailer():PHPMailer {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '671b58206aac73';
        $mail->Password = '3277ffb7ed7612';
        $mail->Port = 2525;
        $mail->SMTPSecure = 'tls';
        $mail->setFrom('ahuja.devansh2@gmail.com', 'Devansh Ahuja');

        $mail->isHTML(true);
        return $mail;

    }

}

//letogal119@winmails.net letogal119

?>
