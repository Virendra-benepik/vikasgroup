<?php

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

include("../Class_Library/Api_Class/class_employee_favouritedeal.php");
require_once('../Class_Library/Api_Class/class_connect_db_deal.php');
$obj = new Favourite();
$deal_obj = new Connection_Deal();

$jsonArr = json_decode(file_get_contents("php://input"), true);
/* {"clientid":"CO-22",
  "employeeid":"uvtwuitwiut",
  } */
if (!empty($jsonArr['employeeid'])) {
    $clientid = $jsonArr['clientid'];
    $employeeid = $jsonArr['employeeid'];
    $result = $obj->GetFavourites($clientid, $employeeid);
    if ($result['success'] == 1) {
        $response['favorites'] = array();
        $favo = array();
        $file = basename(__FILE__, '');
        $count = count($result['posts']);
        $arr = $result['posts'];
        $response = $deal_obj->discountingCurl($arr, $file);
    } else {
        $response = json_encode($result);
    }
} else {
    $response['success'] = 0;
    $response['result'] = "Invalid json";
}
header('Content-type: application/json');
echo ($response);
?>