<?php

//error_reporting(E_ALL ^ E_NOTICE);ini_set("display_errors", "1");
require_once('../../Class_Library/Api_Class/class_connect_db_deal.php');
if (!class_exists('LoginUser') && include("../../Class_Library/Api_Class/class_employee_app_login.php")) {

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
      "packageName":"",
      "empcode":"",
      "password":"",
      "device":""
      } */

    if ($jsonArr) {
        $obj = new LoginUser();
          $obj_location = new Connection_Deal();

        $packageName = $jsonArr['packageName'];
        $username = $jsonArr['empcode'];
        $password = $jsonArr['password'];
        $device   = (!empty($jsonArr['device']))?$jsonArr['device']:"";
        $deviceId = (!empty($jsonArr['deviceId']))?$jsonArr['deviceId']:"";
        $usertype = $jsonArr['usertype'];
        
        $response = $obj->detectValidUser($packageName, $username, $password, $usertype);
      
   
    
        if ($response['success'] == 1) {
            $obj->entryUserLogin($packageName, $response['posts']['employeeId'], $device, $deviceId);
            $response = $obj->detectValidUser($packageName, $username, $password,$usertype);
            
             /***********************************************************/
    $file1 = "locations.php";
    $city = (!empty($response['posts']['defaultLocation']))?$response['posts']['defaultLocation']:'Faridabad';
   
    $location = $obj_location->discountingCurl($jsonArr, $file1);
   // echo $location;
    $location1 = json_decode($location,true);
   // print_r($location1);
    $count = count($location1['cities']);
    $flag = 2;
   
    for($k=0;$k<$count;$k++)    
    {
        
        $loc = $location1['cities'][$k]['state'];
     
        if(strtolower($city) == strtolower($loc))
        {
            //echo "i am here";
            $flag = 1;
            break;
        }
    }
    if($flag == 2)
    {
        $response['posts']['defaultLocation'] = 'Faridabad';
    }
 else
 {
      $response['posts']['defaultLocation'] = $city;
 }
    /**********************************************************/
        }
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>