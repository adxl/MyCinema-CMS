<?php

namespace App\Core;

use App\Core\PHPMailer\PHPMailer;
use App\Core\PHPMailer\SMTP;

class Mailer
{
    public static function init(array $from, array $to, $subject, $body, $altBody = "")
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Port = EMAIL_SMTP_PORT;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_ADDRESS;
        $mail->Password = EMAIL_PASSWD;

        $mail->CharSet    = 'UTF-8';
        $mail->Encoding   = 'base64';

        $mail->setFrom($from['address'], $from['name'] ?? '');

        foreach ($to as $receiver) {
            $mail->addAddress($receiver['address'], $receiver['address'] ?? '');
        }

        $mail->Subject = $subject;
        $mail->msgHTML($body);
        $mail->AltBody = $altBody;

        return $mail;
    }

    public static function sendEmail($mailObject, $onSuccess, $onError)
    {
        if ($mailObject->send())
            $onSuccess();
        else
            $onError();
    }
}
