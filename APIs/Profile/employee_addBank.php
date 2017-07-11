<?php

error_reporting(E_ALL ^ E_NOTICE);

if (file_exists("../../Class_Library/Api_Class/class_bank.php") && include("../../Class_Library/Api_Class/class_bank.php")) {
    include("../../Class_Library/Api_Class/class_messageSentTo.php");

    require_once("../../Class_Library/class_gcm_details.php");

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
/* {
     "clientid":"",
             "employeeid":"",
             "bankname":"",
             "ifsccode":"",
             "accountNo":"",
             "name":""
 }*/
    if (!empty($jsonArr["clientid"])) {
        $mesg = new messageSent();
        $obj = new Bank();

        extract($jsonArr);
        $result = $obj->AddToBank($clientid, $employeeid, $bankname, $ifsccode, $accountNo, $name);
      //  print_r($result);
        if ($result['success'] == 1) {
            $personMail = $result['mailid'];
           $adminMail = "saurabh.jain@benepik.com,sau_org@yahoo.co.in,benepik@gmail.com";
		   //$adminMail = "monikagupta05051994@gmail.com";
            $prognam = $result['progName'];
            $dedimail = $result['dedicatedEmail'];

            $mesgMail = "
            <html>
            <head>
            <title></title>
            </head>
            <body>
            <h3>Bank Details added successfully</h3><br>
            <p>From : " . $personMail . "</p><br>
            <p>Name : " . $name . "</p><br>
            <p>Bank Name : " . $bankname . "</p><br>
            <p>Account Number : " . $accountNo . "</p><br>
            <p>IFSC code : " . $ifsccode . "</p><br>
            <p>Regards,</p>" . $prognam . "
            </body>
            </html>
            ";
            $sub = "Bank Details added";
            $from =  $dedimail;

            $mesg->forMailToSir($adminMail, $sub, $mesgMail, $from);
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