<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 12/06/16
 * Time: 04:21
 */

namespace Ozyris\Service;

class Mailer
{

    /**
     * @param string $destinataire
     * @param string $subject
     * @param string $message
     * @param string $headers
     * @return bool
     * @throws \Exception
     */
    public function sendMail($destinataire, $subject, $message, $headers = '')
    {

        if (empty($headers)) {
            $headers = 'From: no-reply@noreply.com' . "\r\n" .
                'Reply-To: no-reply@noreply.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        }

        return mail($destinataire, $subject, $message, $headers);
    }
}