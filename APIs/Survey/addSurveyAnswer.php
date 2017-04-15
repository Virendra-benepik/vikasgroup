<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (file_exists("../../Class_Library/Api_Class/class_survey.php") 
        && include_once("../../Class_Library/Api_Class/class_survey.php")) 
    {

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
/*	{
	"clientid": "CO-25",
	"employeeid": "GNWxfaPoxq6wbk8lQJHTFMOIU98eup",
	"totalques": 3,
	"surveyId": "1",
	"comment": "hello",
	"device":3,
	"response": "[{
		"feedback_id": "h1",
		"question_id": "1"
	}, {
		"feedback_id": "a1",
		"question_id": "2"
	}, {
		"feedback_id": "a1",
		"question_id": "3"
	}]"
       }
   --------------------------------------------------------
       for android
           
           {
	"clientid": "CO-25",
	"employeeid": "pSNx6y5WCp1EuIOsoS3iBesrFSObKF123",
	"totalques": 3,
	"surveyId": "1",
	"comment": "hello",
	  "device":2
	"response": "{\"1\":\"a1\",\"2\":\"h1\",\"3\":\"a1\"}"
}
 */
     
    if (!empty($jsonArr['clientid'])) 
        {
        if($jsonArr['device'] == 2)
        {
            $ans1 =  json_decode($jsonArr['response'],true);
         //   print_r($ans1);
          $jsonArr['response'] = array();
            foreach ($ans1 as $key => $value)
            {
                $k['feedback_id'] = $value;
                $k['question_id'] = $key;
               // $val = json_encode($k);
                array_push($jsonArr['response'], $k);
            }
             
        }
       
        extract($jsonArr);
        $obj = new Survey();  // create object of class cl_module.php
        $response1 = $obj->addSurveyAnswer($clientid, $employeeid, $surveyId,$totalques,$comment,$device,$response);
    } 
    else {
        $response1['success'] = 0;
        $response1['result'] = "Invalid json";
    }

    header('Content-type: application/json');
    echo json_encode($response1);
}
?>
