<?php

include('../../twilio-php-master/Services/Twilio.php');

Class messageSent {

    function sentForMessages($mailid, $mobNumber, $sub, $mailMessage, $mobileMessage, $deciderVal, $from) {

        if ($deciderVal == 1) {
            if ($mailid != "") {
                self::forMail($mailid, $sub, $mailMessage, $from);
            }
        } else if ($deciderVal == 2) {
            if ($mobNumber != "") {
                self::forMobile($mobNumber, $mobileMessage);
            }
        } else if ($deciderVal == 3) {
            if (($mailid != "") && ($mobNumber != "")) {
                self::forMail($mailid, $sub, $mailMessage, $from);
                self::forMobile($mobNumber, $mobileMessage);
            }
        } else {
            
        }
    }

    function forMail($mailid, $sub, $mailMessage, $from) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     //   $headers .= $from . "\r\n";
//        mail($mailid, $sub, $mailMessage, $headers);
         $headers .= "From: <".$from.">"."\r\n"."Return-Path: ".$from."\r\n";
        
        if (!mail($mailid, $sub, $mailMessage, $headers, '-f '.$from)) {
            echo 'Mail Falied';
            die;
        } 
//        else {
//            echo 'Mail sent';
//            die;
//        }
    }

    function forMailToSir($mailid, $sub, $mailMessage, $from) {
// echo "<script>alert('you are here')</script>";
//echo "this is from-".$from;die;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      //  $headers .= $from . "\r\n";
        /* $headers .= "CC: mk73142@gmail.com\r\n";  
          $headers .= "BCC: mk73142@gmail.com\r\n"; */
        
        $headers .= "From: <".$from.">"."\r\n"."Return-Path: ".$from."\r\n";


        if(!mail($mailid, $sub, $mailMessage, $headers, '-f '.$from)){
            echo 'Mail failed';die;
        }
    }

    function forMailToAppointment($mailid, $sub, $mailMessage) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: info@benepik.com \r\n";

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