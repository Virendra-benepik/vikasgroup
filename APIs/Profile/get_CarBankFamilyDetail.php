<?php
error_reporting(E_ALL ^ E_NOTICE);
if ((file_exists("../../Class_Library/Api_Class/class_bank.php") && include_once("../../Class_Library/Api_Class/class_bank.php")) &&
        (file_exists("../../Class_Library/Api_Class/class_family.php") && include_once("../../Class_Library/Api_Class/class_family.php")) &&
        (file_exists("../../Class_Library/Api_Class/class_car.php") && include_once("../../Class_Library/Api_Class/class_car.php"))) {

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
		"cid":"CO-24",
		"eid":"pSNx6y5WCp1EuIOsoS3iBesrFSObKF"
	}*/
    if (!empty($jsonArr['cid'])) {

        extract($jsonArr);
        $result = array();
        $result['employeeId'] = $eid;
        $result["car"] = (new Car())->GetCars($cid, $eid);
        $result["bank"] = (new Bank())->GetFromBank($cid, $eid);
        $result["family"] = (new Family())->getFamilyDetails($eid);
		$result["personal"] = (new Family())->getPersonalDetails($eid);
        $response = $result;
    }
    else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";

//        $response = $result;
    }

    header('Content-type: application/json');
    echo json_encode($response);
}
?>