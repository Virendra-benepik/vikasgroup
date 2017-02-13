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
	
	require_once('../Class_Library/Api_Class/class_connect_db_deal.php');
    require_once('../Class_Library/class_user.php');
	
	$deal_obj = new Connection_Deal();             //this object for deal api
	$user_obj = new User();                        // this object for check valid user
		
    $jsonArr = json_decode(file_get_contents("php://input"), true);
	/*{"clientid":"CO-22",
	"emailId":"gagandeep@benepik.com",
	"empid" : "pSNx6y5WCp1EuIOsoS3iBesrFSObKF";
	}*/
	
	   if (!empty($jsonArr)) 
	   {
		$clientid = $jsonArr["clientid"];
		$email = $jsonArr["emailId"];
		$empid = $jsonArr["empid"];
		$orderid = $jsonArr["orderid"];
		$device = $jsonArr["device"];
		
		$data = $user_obj->getUserDetail($clientid,$empid);
		//print_r($data);
		$success = $data['success'];
		// echo json_encode($result);
			   if ($success == 1) 
					{	
					   $file = basename(__FILE__,'');
					   $response = $deal_obj->discountingCurl($jsonArr,$file);
					   //echo "this is response-".$response;
					}
      } 
	else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo $response;

?>