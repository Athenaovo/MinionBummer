<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 4/1/18
 * Time: 7:18 PM
 */

namespace Bummer;

/**
 * Email adapter class
 */
class Email {
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }
}