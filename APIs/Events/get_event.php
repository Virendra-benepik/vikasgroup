<?php

error_reporting(E_ALL ^ E_NOTICE);
require_once('../../Class_Library/Api_Class/class_AppAnalytic.php');
if ((!class_exists('Family') && include("../../Class_Library/Api_Class/class_family.php")) && (!class_exists("Event") && include("../../Class_Library/class_event.php"))) {

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
      "clientid":"CO-27",
      "uid":"1NtwiCYbQ7IxpjQb30cfzTzenjKCmC",
      "value":0,
      "device":2,
      "deviceId":""
      } */
    if (!empty($jsonArr['clientid'])) {

        $obj = new Event();
            $analytic_obj = new AppAnalytic();
        $flagtype = 6;
        $module = '';   
        extract($jsonArr);
        $deviceId = (!empty($deviceId))?$deviceId:"";
        $device = (!empty($device))?$device:"";
        $analytic_obj->listAppview($clientid, $uid, $device, $deviceId, $flagtype);
        $response = $obj->EventDisplays($clientid, $uid, $value, $module);
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
