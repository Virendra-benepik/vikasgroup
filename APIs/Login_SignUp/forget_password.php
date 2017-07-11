<?php

//error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("../../Class_Library/Api_Class/class_employee_forgetpassword.php") && include("../../Class_Library/Api_Class/class_employee_forgetpassword.php")) {

    include("../../Class_Library/Api_Class/class_sent_email.php");

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
/*{
    "packageName":""
        "empcode":""
}*/
    $mesg = new messageSent();
    $obj = new ForgotPassword();
   // print_r($jsonArr);
    if (!empty($jsonArr["packageName"])) {

        extract($jsonArr);
        $result = $obj->forgotPasswordSentTo($packageName, $empcode);
        if ($result['success'] == 1) {
            $progNam = $result["progName"];
            $dedi = $result["dedicated_mail"];
            $nam = $result["name"];
            $pass = $result['password'];
            $deciderVal = $result['decider'];
            $mailid = $result['emailId'];
            $mobile = !empty($result['contact']) ? "+91" . $result['contact'] : "";

            $mesgMob = "Hello " . $nam . "\n Your Password: " . $pass . "\n Regards,\n" . $progNam;

            $mesgMail = "
            <html>
            <head>
            <title></title>
            </head>
            <body>
            <p>Hello " . $nam . ",</p><br>
            <p>We received a request to send the password associated with this e-mail address.</p>
            <p>Your password : " . $pass . "</p>
            <p>If you did not request to have your password you can safely ignore this email. Rest assured your customer account is safe.</p><br>
            <p>Regards,</p> Team " . $progNam . "
            </body>
            </html>";
            $sub = "Vikas Live Password Assistance ";
            $from = "From: " . $progNam . "<" . $dedi . ">";

            if ($deciderVal > 0) {
                $mesg->sentForMessages($mailid, $mobile, $sub, $mesgMail, $mesgMob, $deciderVal, $from);
            }
        }
        $response = $result;
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>