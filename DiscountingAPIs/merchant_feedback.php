<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
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
/* * ********************************************************************************************************** */
require_once("../Class_Library/Api_Class/class_sentToAdmin.php");
include_once("../Class_Library/Api_Class/class_messageSentTo.php");

$mesg = new messageSent();

$obj = new MessagesToAdmin();

$jsonArr = json_decode(file_get_contents("php://input"), true);

/* {
  "mname":'',
  "message":"nice message",
  "clientid":"CO-22",
  "employeeid":""
  } */

if ($jsonArr) {
    
    $sub   = $jsonArr['sub'];
    $mname = $jsonArr['mname'];
    $message = $jsonArr['message'];
    $clientid = $jsonArr['clientid'];
    $employeeid = $jsonArr['employeeid'];

    $result = $obj->merchantFeedback($clientid, $employeeid);
//print_r($result);
    $msg = "";
    $msg2 = "";
    $name = "";
    if ($result['success'] == 1) {
        $mail = $result['mailid'];
        $name = $result['name'];
        $progn = $result['progName'];
        $dedi = $result['dedicatedEmail'];

        $sub = "Feedback of Merchant";
        $msg.="Dear " . $name . ",";
        $msg.="<br/><br/>";
        $msg.="<br/>Thank you for providing merchant feedback to $name. We will act on your feedback accordingly.";
        $msg.="<br/><br/>";
        $msg.="<br/>For your information, here is a copy of your message:";
        $msg.="<br/><br/>";
        $msg.="<br/>Subject : " . $sub;
        $msg.="<br/>Merchant Name : " . $mname;
        $msg.="<br/>Message : " . $message;


        $msg.="<br/><br/>";
        $msg.="Thank You, <br/> Team $progn";

        $from = "From: " . $progn . "<" . $dedi . ">";

        if ($mail != "") {
            $mesg->forMail($mail, $sub, $msg, $from);
        }

        $sub2 = "Merchant Feedback";

        $adminMailid = "webveeru@gmail.com,info@benepik.com,benepik@gmail.com";
        $msg2.="Merchant Name : " . $mname;
        $msg2.="<br/>Message : " . $message;
        $msg2.="<br/>Name : " . $name . ",";
        $msg2.="<br/>Email : " . $mail;
        $msg2.="<br/><br/><br/>";
        $msg2.="Thank You, <br/> Team $progn";

        $mesg->forMailToSir($adminMailid, $sub2, $msg2, $from);
    }
    echo json_encode($result);
}
?>