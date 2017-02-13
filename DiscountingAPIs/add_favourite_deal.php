<?php

error_reporting(E_ALL ^ E_NOTICE);

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
$obj = new Favourite();

$jsonArr = json_decode(file_get_contents("php://input"), true);
/* {"clientid":"CO-22",
  "employeeid":"uvtwuitwiut",
  "dealid":"Deal-1",
  "branchid":"B-1"
  } */

if (!empty($jsonArr)) {
    $clientid = $jsonArr['clientid'];
    $employeeid = $jsonArr['employeeid'];
    $dealid = $jsonArr['dealid'];
    $branchid = $jsonArr['branchid'];
    $response = $obj->AddToFavourite($clientid, $employeeid, $dealid, $branchid);
} else {
    $result['success'] = 0;
    $result['result'] = "Invalid json";

    $response = $result;
}
header('Content-type: application/json');
echo json_encode($response);
?>