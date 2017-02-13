<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('../../Class_Library/Api_Class/class_postLike.php');
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
	"clientid":"CO-24",
	"post_id":"Post-1",
	"employeeid":"pSNx6y5WCp1EuIOsoS3iBesrFSObKF",
	"flag":"1",
	"device":"IOS"
}*/
if (!empty($jsonArr['clientid'])) {
    $obj = new Like();

    extract($jsonArr);
    $response = $obj->create_Like($clientid, $post_id, $employeeid, $flag, $device);
} 
else 
{
    $response['success'] = 0;
    $response['result'] = "Invalid json";
}
header('Content-type: application/json');
echo json_encode($response);
?>