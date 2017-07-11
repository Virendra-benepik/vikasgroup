<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('dispaly_errors',1);

if (file_exists("../../Class_Library/class_thought.php") && include("../../Class_Library/class_thought.php")) {
//require_once('../../Class_Library/Api_Class/class_AppAnalytic.php');
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
    "clientid":"CO-27",
    "uuid":"HGLF3M0DfwFdqWP3AbWPUWA0cD03O61",
    "value":0,
    "device":2,
	"deviceId":""
}*/
    if (!empty($jsonArr['clientid'])) {
        $obj = new ThoughtOfDay();
       //  $analytic_obj = new AppAnalytic();
        $flagtype = 5;

        extract($jsonArr);
         $analytic_obj->listAppview($clientid, $uuid, $device, $deviceId, $flagtype);
      //  $response = $obj->getthoughtlist($clientid,$uuid,$value);
    }
    else {
        $result['success'] = 0;
        $result['result'] = "Invalid json";

        $response = json_encode($result);
    }
    header('Content-type: application/json');
    echo $response;
}
?>