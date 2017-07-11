<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists('ClientEmployeeLogin') && include("../../Class_Library/Api_Class/class_employee_login.php")) {

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
      "empid":"",
      "dob":"",

      } */
//print_r($jsonArr);
    if ($jsonArr['empid'] != "") {

        $obj = new ClientEmployeeLogin();
        $empid = $jsonArr['empid'];
        $dob = $jsonArr['dob'];
        $companycode = $jsonArr['companycode'];
        $usertype = $jsonArr['usertype'];

        $completecode = $companycode . $empid;
        $response = $obj->checkEmployeeLogin($completecode, $dob, $usertype);
        // $response = $obj->tempregistration($empid, $dob);
    } else {
        $result['success'] = 0;
        $result['result'] = "Invalid json";

        $response = json_encode($result);
    }
    header('Content-type: application/json');
    echo $response;
}
?>