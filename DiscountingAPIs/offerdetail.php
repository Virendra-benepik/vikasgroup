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

require_once("../Class_Library/Api_Class/class_category.php");
require_once('../Class_Library/Api_Class/class_connect_db_deal.php');
$deal_obj = new Connection_Deal();
$obj      = new Category();
//initial query
$jsonArr = json_decode(file_get_contents("php://input",true),true);
if (!empty($jsonArr)) {
    $file = basename(__FILE__,'');
    
    $response = $deal_obj->discountingCurl($jsonArr,$file);
    $dealNam  = json_decode($response,true);
    $dealNam  = $dealNam['posts'][0]['dealName'];
    extract($jsonArr);
    $obj->entryDeal($clientid, $employee, $dealNam, $device);
    
} 
else {
    $response['success'] = 0;
    $response['result'] = "Invalid json";
    $response = json_encode($response);
}
header('Content-type: application/json');
echo $response;
?>
