<?php

if (!class_exists('messageSent') && include("../../Class_Library/Api_Class/class_sent_email.php")) {

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

    if (!empty($jsonArr)) {
        $obj = new messageSent();
        extract($jsonArr);

        $mailid = "gagandeep509.singh@gmail.com";
        /*         * *******************************send mail***************************************** */
        $to = $mailid;
        $subject = 'Manav-Rachna Sign Up Issue';
        $from = $email;

        // To send HTML mail, the Content-type header must be set

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
        $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        // Compose a simple HTML email message

        $message = '<html><body>';

        $message .= '<p>Dear Admin ,<p>';

        $message .= '<p>User ' . $name . ' is unable to SignUp in Manav-Rachna Connect App </p><br>';

        $message .= '<p>User SignUp Details : </p><br>';

        $message .= '<p>Full Name : ' . $name . '</p><br>';
        $message .= '<p>Contact Number  : ' . $contact . '</p><br>';
        $message .= '<p>Email : ' . $from . '</p><br>';
        $message .= '<p>Additional Query : ' . strip_tags($query, '') . '</p><br>';

        $message .= '<p>Regards,</p>';
        $message .= '<p>Team Manav-Rachna</p>';

        $message .= '</body></html>';

        if ($obj->forMail($to, $subject, $message, $from) == true) {
            $response['success'] = 1;
            $response['result'] = "Issue has been reported to Admin, we will get back to you shortly";
        } else {
            $response['success'] = 0;
            $response['result'] = "There is some techinal fault, please try again later";
        }
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>