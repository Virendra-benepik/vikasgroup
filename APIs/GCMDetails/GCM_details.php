<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once("../../Class_Library/class_gcm_details.php");

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

//initial querye
if (!empty($jsonArr['userUniqueId'])) 
{
	//print_r($jsonArr);
    $obj    = new GCM();
    $result = $obj->addGCMDetails($jsonArr);
     if($result['success'] == 1)
     {
	 $response["success"] = 1;
     $response["message"] = "GCM Details Successfully Added!";
     }
 else{
	  $response["success"] = 0;
      $response["message"] = "Error in gcm ";
 }
    
} else {
    $response['success'] = 0;
    $response['result'] = "Invalid json";

//        $response = $result;
}

header('Content-type: application/json');
echo json_encode($response);
?>