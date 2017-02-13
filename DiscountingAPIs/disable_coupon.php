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
require_once('../Class_Library/Api_Class/class_connect_db_deal.php');
$deal_obj = new Connection_Deal();

$jsonArr = json_decode(file_get_contents("php://input"), true);

if (!empty($jsonArr['dealid'])) {
   $file = basename(__FILE__,'');
//   print_r($jsonArr);die;
    $response = $deal_obj->discountingCurl($jsonArr,$file);
} else {
    $result['success'] = 0;
    $result['result'] = "Invalid json";

    $response = json_encode($result);
//        $response = $result;
}
header('Content-type: application/json');
echo $response;
?>