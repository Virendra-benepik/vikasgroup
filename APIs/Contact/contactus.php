<?php

error_reporting(E_ALL ^ E_NOTICE);

if (file_exists("../../Class_Library/Api_Class/class_sentToAdmin.php") && include("../../Class_Library/Api_Class/class_sentToAdmin.php")) {
    include("../../Class_Library/Api_Class/class_messageSentTo.php");

    ini_set('SMTP', 'mail.benepik.com ');
    ini_set('smtp_port', 25);

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        //echo json_encode($response);
    }

// Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    $jsonArr = json_decode(file_get_contents("php://input"), true);

    $mesg = new messageSent();

    $obj = new MessagesToAdmin();
    if ($jsonArr["clientid"]) {

        extract($jsonArr);
        $result = $obj->contactUs($clientid, $employeeid);
		//print_r($result);
//die;
        if ($result['success'] == 1) {
            $usermail = $result['mailid'];
            $username = $result['name'];
            $contactno = $result['contactno'];
            $progn = $result['progName'];
            $dedi = $result['dedicatedEmail'];
            $msg = '';
            $sub = "Thanks For Contacting Us ";
            $msg1.="Dear " . $username . ",";
            $msg1.="<br/>";
            $msg1.="<br/>Thanks for contacting Vikas Live. We have received your message";
            $msg1.="<br/><br/>";
            $msg1.="For your referance, here is a copy of your message:";
            $msg1.="<br/>";
            $msg1.="<br/>Subject : " . $subject;
            $msg1.="<br/>Message : " . $message;
            $msg1.="<br/><br/><br/><br/>";
            $msg1.="Regards, <br/> Team Vikas Live";
            $from = $dedi;

            if ($usermail != "") {
                $mesg->forMail($usermail, $sub, $msg1, $from);
            }

            /*             * ********************************************************************************************************* */

            /*             * ********************************* mail to admin ********************************************* */
        //    $to = "info@benepik.com, benepik@gmail.com";
$to = "webveeru@gmail.com,virendra@benepik.com";
            $subject = "Contact Us Submitted on Vikas Live ";

            $message = "
            <html>
            <head>
            <title>HTML email</title>
            </head>
            <body>
            <p>Dear Team Vikas Live,</p>
            <p>Mr/Ms " . $username . ", has tried to contact you.</p>
            <p>Email ID :- " . $usermail . "</p>
            <p>Contact Number :- " . $contactno . "</p>
            <br/>
            <p>Subject :- " . $subject . "</p>
            <p>Message :- " . $message . "</p>
            <br/>
            <br/>
            <p>Regards,</p>
            <p>Team Vikas Live</p>
            </body>
            </html>
            ";

// Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers

            $headers .= 'From: Vikas Live<' . $dedi . '>' . "\r\n"."Return-Path: ".$dedi."\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

            if (!mail($to, $subject, $message, $headers, '-f '.$dedi)) {
                echo 'mail failed';
                die;
            }

            /*             * ****************************************** mail to admin end *************************************** */
        }
            $response = $result;
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";

//        $response = $result;
    }

    header('Content-type: application/json');
    echo json_encode($response);
}
?>