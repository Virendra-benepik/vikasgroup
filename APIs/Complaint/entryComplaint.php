<?php

require_once('../../Class_Library/Api_Class/class_ComplaintSuggestion.php');

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

if (!empty($jsonArr['clientid'])) {
    $obj = new Complaint();
    
    extract($jsonArr);

    $response = $obj->entryComplaint($clientid, $employeeid, $content, $status, $isAnonymous, $device);
} else {
    $response['success'] = 0;
    $response['message'] = "Invalid json";
}
header('Content-type: application/json');
echo json_encode($response);
?>
