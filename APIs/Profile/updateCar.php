<?php

error_reporting(E_ALL); ini_set('display_errors', 1);
if (file_exists("../../Class_Library/Api_Class/class_car.php") && include("../../Class_Library/Api_Class/class_car.php")) {
    require_once('../../Class_Library/Api_Class/class_messageSentTo.php');

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
    "clientid":"",
            "employeeid":"",
            "carid":"",
            "carModel":"",
            "modelNo":"",
            "RegisNo":"",
            "name":""
}*/
    $obj = new Car();
    $mail = new messageSent();
    $famliy = new Family();
    if ($jsonArr["clientid"]) {

        extract($jsonArr);
        $response = $obj->updateCar($clientid, $employeeid, $carid, $carModel, $modelNo, $RegisNo, $name);
      //  print_r($response);
        $user_details = $famliy->getFamilyDetails($employeeid);
       // print_r($user_details);

        if (!empty($response)) {
            //$mailid = "benepik@gmail.com";
           $mailid = "webveeru@gmail.com";
            $sub = "Car details Updated";

            $mailMessage="A new Car Has Been Updated";
            $mailMessage.="<br/><br/><br/>";
            $mailMessage.="Email :" . $user_details['posts']['emailId'];
            $mailMessage.="<br/>";
            $mailMessage.="Manufacture : " . $carModel;
            $mailMessage.="<br/>";
            $mailMessage.="Model: " . $modelNo;
            $mailMessage.="<br/>";
            $mailMessage.="Registration no: " . $RegisNo;
            $mailMessage.="<br/> ";
            $mailMessage.="Owner name: " . $name . "<br><br><br>";
            $mailMessage.="Regards<br>Team Haier Connect";

            $from = "From: info@benepik.com";

            $mail->forMailToSir($mailid, $sub, $mailMessage, $from);
            
        }
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>