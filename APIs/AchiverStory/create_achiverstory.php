<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
if ((!class_exists('Reading') && include("../../Class_Library/class_reading.php")) && 
    (!class_exists("AchiverStory") && include("../../Class_Library/class_achiverstory.php")) && 
	(!class_exists("PushNotification") && include("../../Class_Library/class_push_notification.php"))) 
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
/*	$jsonArr1 = '{
  "clientid":"CO-24",
  "employeeid":"pSNx6y5WCp1EuIOsoS3iBesrFSObKF",
  "achiverTitle":"hello",
  "achiverstory":"this is achiver story",
  "device":"Android",
  "selected_user":"Group1,",
  "uploadimage":"";
  }';
  $jsonArr = json_decode($jsonArr1, true);*/
    /********************************START HERE************************************************ */

	//print_r($jsonArr);
    if (!empty($jsonArr['clientid']))
	{
        date_default_timezone_set('Asia/Calcutta');
        $post_date = date('Y-m-d H:i:s');

        $obj = new AchiverStory();                                        // object of class post page
        $push = new PushNotification();                         // object of class push notification page
        $read = new Reading();

		 $clientid = $jsonArr['clientid'];
		 $USERID = $jsonArr['employeeid'];
		 $achivertitle = $jsonArr['achiverTitle'];
		 $achiverstory = $jsonArr['achiverstory'];
		  $uploadimage = $jsonArr['uploadimage'];
		 $device = $jsonArr['device'];
		 $User_Type = "Selected";
		 
		 $storyid = $obj->maxID();  //---------get latest post_id
		
		 $target = '../../images/achiverimage/';   // folder name for storing data
         $folder = 'images/achiverimage/';      //folder name for add with image insert into table
		/*********************************************************************************************/
		//   print_r($_FILES);
	/*	 $path = $_FILES['uploadimage']['name'];
		 $type = $_FILES['uploadimage']['type'];
		 $pathtemp = $_FILES['uploadimage']['tmp_name'];
		 if($type == 'video/mp4')
		 {       
         $path_name = $storyid . "-" . $path;
         $imagepath = $target . $path_name;
		 move_uploaded_file($pathtemp,$imagepath);
         }
		 else{
		 $path_name = $storyid . "-" . $path;
         $imagepath = $target . $path_name;
         $fullpath = SITE_URL . "images/achiverimage/" . $path_name;
         $obj->compress_image($pathtemp, $imagepath, 20);
		 }*/
		/********************************************************************************/     
		$imgname = "";
		if(!empty($imgname))
		{
			$imgname = $obj->convertIntoImage($uploadimage);
		}
       
	 //  echo "image name-".$imgname;
	   
        if ($User_Type == 'Selected') {
            $user1 = rtrim($jsonArr['selected_user'], ',');
            $myArray = explode(',', $user1);
        } else {
            $User_Type = "Selected";
            $user1 = rtrim($jsonArr['selected_user'], ',');
            $myArray = explode(',', $user1);
        }
  // print_r($myArray);
        $POST_ID = $storyid;
        $POST_TITLE = $achivertitle;
        $POST_IMG = $imgname;
        $POST_CONTENT = $achiverstory;
        $DATE = $post_date;
        $flagType = 16;
        $flag_name = "Achiver Story : ";
        /** ******************************************** like push selection start ***************************************** */
        $like = 'LIKE_YES';
        if (!isset($like) && $like != 'LIKE_YES') {
            $like = 0;
            $like_val = 'No';
        } else {
            $like_val = 'Yes';
			 $like = 1;
        }

        $comment = 'COMMENT_YES';
        if (!isset($comment) && $comment != 'COMMENT_YES') {
            $comment = 0;
            $comment_val = 'No';
        } else {
            $comment_val = 'Yes';
			$comment = 1;
        }

         $PUSH_NOTIFICATION = 'PUSH_NO';

    /*    if (!isset($push_noti)) {
            $PUSH_NOTIFICATION = 'PUSH_NO';
        } else {
            $PUSH_NOTIFICATION = 'PUSH_YES';
        }

        $userimage = $push->getImage($USERID);

        $image = $userimage[0]['userImage'];

*/
        /********************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push->getKeysPem($clientid);
        /************************************************************************************** */

        /*********************** insert into database ************************************************ */
                                      //$clientid, $POST_TITLE, $POST_CONTENT, $POST_IMG, $device, $flagType, $like, $comment, $DATE, $USERID
        $result = $obj->create_AchiverStory($clientid, $POST_TITLE, $POST_CONTENT, $POST_IMG, $device, $flagType,$like, $comment, $DATE, $USERID );

        $type = 'AStory';//$clientid, $POST_ID, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID,$flagType
        $result1 = $obj->createWelcomeData($clientid, $storyid, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID, $flagType);

       $groupcount = count($myArray);
	 //  echo "group count".$groupcount;
        for ($k = 0; $k < $groupcount; $k++) 
		{
          $result1 = $read->StorySentToGroup($clientid, $storyid, $myArray[$k], $flagType);
        }
        /******************  fetch all user employee id from user detail start **************************** */
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
        $token = json_decode($gcm_value, true);       
        /***************************get group admin uuid  form group admin table if user type not****************************/
        if ($User_Type != 'All') 
		{
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
            $adminuuid = json_decode($groupadminuuid, true);
            $allempid = array_merge($token, $adminuuid);
            
            /*  "--------------all unique employee id---------"; */

            $allempid1 = array_values(array_unique($allempid));
            
        } else 
		{
            $allempid1 = $token;
        }

        /** ******* insert into post sent to table for analytic sstart************ */

        $total = count($allempid1);       
        for($i = 0; $i < $total; $i++) 
		{
            $uuid = $allempid1[$i];
            if (!empty($uuid)) {

                $read->postSentTo($clientid, $storyid, $uuid);
            }
        }
        /********* insert into post sent to table for analytic sstart************ */

        /***** get all registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($allempid1, $clientid);
        $token1 = json_decode($reg_token, true);
       
        /*********************Create file of user which this post send  start******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = @fopen("../send_push_datafile/" . $storyid . "-achiverstory.csv", "w");

        foreach ($val as $line) {
            @fputcsv($file, @explode(',', $line));
        }
        @fclose($file);
        /*********************Create file of user which this post send End******************** */
        /********************check push notificaticon enabale or disable******************** */
        if ($PUSH_NOTIFICATION == 'PUSH_YES') {
            $hrimg = SITE_URL . $image;
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();
            foreach ($token1 as $row) {
                if ($row['deviceName'] == 'ios') {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
            }

            $data = array('Id' => $maxid, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
            $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
            $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

            $rt = json_decode($revert, true);
            if ($rt['success'] == 1) {
                $response = $revert;
            }
        } 
		else 
		{
          //  $response = $rt;
			 $response['success'] = 1;
             $response['result'] = "data inserted";
        }
    } 
	else 
	{
        $response['success'] = 0;
        $response['result'] = "Invalid json";

        $response = json_encode($response);
    }
   // header('Content-type: application/json');
    echo (json_encode($response));
}
?>