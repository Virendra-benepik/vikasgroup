<?php

//error_reporting(E_ALL ^ E_NOTICE);

if (file_exists("../../Class_Library/class_get_useruniqueid.php") && include("../../Class_Library/class_get_useruniqueid.php")) {
    
    ini_set('SMTP', 'mail.benepik.com ');
    ini_set('smtp_port', 25);

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

	//print_r($jsonArr);
    $userdata = new UserUniqueId();

    
    if ($jsonArr["clientid"]) {

        extract($jsonArr);
		//echo $clientid;
		//echo $employeeid;
		//echo $device;
		//echo $deviceid;
        $result = $userdata->getUserData($clientid, $employeeid);
		$userdata = json_decode($result , true);
		//print_r($userdata);
		
		$userid = $userdata[0]['employeeCode'];
		$username = $userdata[0]['firstName']." ".$userdata[0]['middleName']." ".$userdata[0]['lastName'];
		$useremailid = $userdata[0]['emailId'];
		$usercontact = $userdata[0]['contact'];
		
		//echo count($userdata);

        if (count($userdata) != "") {
           
		   $to = "info@benepik.com";
            //$to = "monikagupta05051994@gmail.com";
			//$to = "monika@benepik.com";
            $subject = "Issue at Vikas Live";

            $message = "
            <html>
            <head>
            <title>HTML email</title>
            </head>
            <body>
            <p>Following user has reported issue at Vikas Live</p>
			
			<p>Name :- " . $username . "</p>
            <p>Employee ID :- " . $userid . "</p>
            <p>Email ID :- " . $useremailid . "</p>
            <p>Contact Number :- " . $usercontact . "</p>
			<br/>
            <br/>
            <p>Regards,</p>
            <p>Team Vikas Live</p>
            </body>
            </html>
            ";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $headers .= 'From: Vikas Live<vikaslive@benepik.com>' . "\r\n";

             $mailres = mail($to, $subject, $message, $headers);
			 if($mailres == 1)
			 {
				 $response['success'] = 1;
                 $response['result'] = "Your issue has been submitted successfully";
			 }
			 else
			 {
				 $response['success'] = 0;
                 $response['result'] = "Some Error has occur , please try again";
			 }
			
        }
		else
		{
			 $response['success'] = 0;
             $response['result'] = "Incorrect Client Or Employee ID";
		}
            
		
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";

//        $response = $result;
    }

    header('Content-type: application/json');
    echo json_encode($response);
}
?>