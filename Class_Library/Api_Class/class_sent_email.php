<?php

include_once('../../twilio-php-master/Services/Twilio.php');

Class messageSent {

    function sentForMessages($mailid, $mobNumber = '', $sub, $mailMessage, $mobileMessage, $deciderVal, $from) {
        if ($deciderVal == 1) {
            if ($mailid != "") {
                self::forMail($mailid, $sub, $mailMessage, $from);
            }
        } else if ($deciderVal == 2) {
            if ($mobNumber != "") {
                self::forMobile($mobNumber, $mobileMessage);
            }
        } else if ($deciderVal == 3) {
            if (($mailid != "")) {
                self::forMail($mailid, $sub, $mailMessage, $from);
                if ($mobNumber != '') {
                    self::forMobile($mobNumber, $mobileMessage);
                }
            }
        }
    }

    function forMail($mailid, $sub, $mailMessage, $from, $headers = '') {
//        $headers = "MIME-Version: 1.0" . "\r\n";
        if (empty($headers)) {
            $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= $from . "\r\n";
        }

        if (mail($mailid, $sub, $mailMessage, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    function forMailToSir($mailid, $sub, $mailMessage, $from) {
// echo "<script>alert('you are here')</script>";
//        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= $from . "\r\n";
        /* $headers .= "CC: mk73142@gmail.com\r\n";  
          $headers .= "BCC: mk73142@gmail.com\r\n"; */

        mail($mailid, $sub, $mailMessage, $headers);
    }

    function forMailToAppointment($mailid, $sub, $mailMessage) {

//        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: info@gmail.com \r\n";

        mail($mailid, $sub, $mailMessage, $headers);
    }

    function forMobile($mobNumber, $mobileMessage) {

        $account_sid = 'AC6cada6ee591e119871888eecc7c759c5';
        $auth_token = 'ed74429787ae54cb2af89120ccc4833f';
        $client = new Services_Twilio($account_sid, $auth_token);

        $client->account->messages->create(array(
            'To' => $mobNumber,
            'From' => "+13144007176",
            'Body' => $mobileMessage,
        ));
    }

}

?>