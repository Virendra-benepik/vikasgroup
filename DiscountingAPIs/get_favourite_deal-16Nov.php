<?php

error_reporting(E_ALL ^ E_NOTICE);
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

include("../Class_Library/Api_Class/class_employee_favouritedeal.php");
require_once('../Class_Library/Api_Class/class_connect_db_deal.php');
$obj = new Favourite();
$deal_obj = new Connection_Deal();
$jsonArr = json_decode(file_get_contents("php://input"), true);
/* {"clientid":"CO-22",
  "employeeid":"uvtwuitwiut",
  } */
//	print_r($jsonArr);

if (!empty($jsonArr)) {
    $clientid = $jsonArr['clientid'];
    $employeeid = $jsonArr['employeeid'];
    $result = $obj->GetFavourites($clientid, $employeeid);
//		 print_r($result);die;
    $val = $result['posts'];
//		print_r($val);die;

    $file = basename(__FILE__, '');
    $response = $deal_obj->discountingCurl($val[0], $file);
    /* if ($device =="android")
      echo json_encode($result);
      else
      echo $_GET['callback'].'('.json_encode($result).')'; */
}else {
    $response['success'] = 0;
    $response['result'] = "Invalid json";
}
header('Content-type: application/json');
echo ($response);
?>