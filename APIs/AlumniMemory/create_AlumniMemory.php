<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('../../Class_Library/class_AlumniMemory.php');
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
/*
$jsonArr1 =  '{
  "clientid":"CO-24",
  "employeeid":"pSNx6y5WCp1EuIOsoS3iBesrFSObKF",
  "memoryTitle":"this is title",
  "memeorycontent":"hello this is memory for approvel ",
  "device":"Android",
  "selected_group":"Group1,"
  "uploadimage":""
  }'; 
//print_r($jsonArr);
*/
//$jsonArr = json_decode($jsonArr1, true);
    if (!empty($jsonArr)) 
     {
     $obj = new AlumniMemory();
	 $memoryid = $obj->maxId();
	 
	  date_default_timezone_set('Asia/Calcutta');
         $post_date = date('Y-m-d H:i:s');
         $target = '../../images/memories/';   // folder name for storing data
         $folder = 'images/memories/';      //folder name for add with image insert into table
		/*********************************************************************************************/
		//   print_r($_FILES);
	/*	 $path = $_FILES['uploadimage']['name'];
		 $type = $_FILES['uploadimage']['type'];
		 $pathtemp = $_FILES['uploadimage']['tmp_name'];
		 if($type == 'video/mp4')
		 {       
         $path_name = $memoryid . "-" . $path;
         $imagepath = $target . $path_name;
		 move_uploaded_file($pathtemp,$imagepath);
         }
		 else{
		 $path_name = $memoryid . "-" . $path;
         $imagepath = $target . $path_name;
         $fullpath = SITE_URL . "images/achiverimage/" . $path_name;
         $obj->compress_image($pathtemp, $imagepath, 20);
		 }
		 $POST_IMG = $folder . $path_name;   */
		/********************************************************************************/
         $clientid = $jsonArr['clientid'];
         $employeeid = $jsonArr['employeeid'];
		 $memoryTitle = $jsonArr['memoryTitle'];
	     $memeorycontent = $jsonArr['memeorycontent'];
		 $device = $jsonArr['device'];
		 $flag = 18;
		 $memoryimage = $jsonArr['uploadimage'];
		 $selectedgroup = $jsonArr['selected_group'];
         $imgname = $obj->convertIntoImage($memoryimage);
		// echo "this si image name-".$imgname;
    $response = $obj->createMemory($clientid,$imgname,$memoryTitle,$memeorycontent,$device,$employeeid,$post_date,$flag,$selectedgroup);
} else 
{
    $response['success'] = 0;
    $response['result'] = "Invalid json";

    $response = json_encode($response);
}

header('Content-type: application/json');
echo $response;
?>