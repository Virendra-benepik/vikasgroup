<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('../../Class_Library/class_jobpost.php');
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
  "clientid":"CO-22",
  "employeeid":"sa",
  "jobTitle":"",
  "joblocation":"",
  "companyName":"",
  "jobDescription":"",
  "contactDetails":"",
  "device"
  } */
//print_r($jsonArr);
if (!empty($jsonArr)) {
    $obj = new JobPost();
    $clientid = $jsonArr['clientid'];
    $employeeid = $jsonArr['employeeid'];
	 $jobtitle = $jsonArr['jobTitle'];
	  $joblocation = $jsonArr['joblocation'];
	   $cname = $jsonArr['companyName'];
	    $jobdesc = $jsonArr['jobDescription'];
		$contactdetails = $jsonArr['contactDetails'];
		 $device = $jsonArr['device'];
    
    $response = $obj->createJob($clientid,$employeeid,$jobtitle,$joblocation,$cname,$contactdetails,$jobdesc,$device);
} else {
    $response['success'] = 0;
    $response['result'] = "Invalid json";

    $response = json_encode($response);
}

header('Content-type: application/json');
echo $response;
?>