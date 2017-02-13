<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_achiverstory.php');
require_once('../Class_Library/class_push_notification.php');

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');

$obj = new AchiverStory();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();
$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/achiverimage/';   // folder name for storing data
$folder = 'images/achiverimage/';      //folder name for add with image insert into table

/* * ******************************START HERE************************************************ */
 if (!empty($_POST))
  {
    $flag_value = $_POST['flag'];
    $flag_name = "Hall of Fame : ";
    $dev = $_POST['device'];  
	$USERID = $_POST['useruniqueid'];
	$googleapi = $_POST['googleapi'];
	$BY = $_SESSION['user_name'];
	$clientid = $_SESSION['client_id'];

    /************************************************************/
	$path = $_FILES['uploadimage']['name'];
	$type = $_FILES['uploadimage']['type'];
	$pathtemp = $_FILES['uploadimage']['tmp_name'];
	if($type == 'video/mp4')
	{       
	 $path_name = $maxid . "-" . $path;
	 $imagepath = $target . $path_name;
	 move_uploaded_file($pathtemp,$imagepath);
	}
	else{
	 $path_name = $maxid . "-" . $path;
	 $imagepath = $target . $path_name;
	 $fullpath = SITE_URL . "images/achiverimage/" . $path_name;
	 $obj->compress_image($pathtemp, $imagepath, 10);
	}
	     
        /****************************************** check like & comment start ********************** */
		$like = "";
		$comment = "";
        $like = $_POST['like'];
        if (!isset($like) || $like != 'LIKE_YES') {
            $like = 0;
            $like_val = 'No';
        } else {
            $like_val = 'Yes';
			$like = 1;
        }

        $comment = $_POST['comment'];
        if (!isset($comment) || $comment != 'COMMENT_YES') {
            $comment = 0;
            $comment_val = 'No';
        } else {
            $comment_val = 'Yes';
			$comment = 1;
        }
            $PUSH_NOTIFICATION = "";
        if (!isset($_POST["push"])) 
		{
            $PUSH_NOTIFICATION = 'PUSH_NO';
        } else {
            $PUSH_NOTIFICATION = 'PUSH_YES';
        }
		
		
		 $popup_NOTIFICATION = "";
		  if (!isset($_POST['popup'])) 
		{
            $popup_NOTIFICATION = 'POPUP_NO';
        } else {
            $popup_NOTIFICATION = 'POPUP_YES';
        }
		//ECHO $popup_NOTIFICATION;
		
	//	 echo "thisis pp val-".$popup;

        /*         * **************************************** check like & comment end ********************** */

        $POST_ID = $maxid;
        $POST_TITLE = $_POST['title'];
        $POST_IMG = $folder . $path_name;
        $POST_CONTENT = $_POST['content'];
        $DATE = $post_date;
        $FLAG = $flag_value;
        $User_Type = $_POST['user3'];
		$device = "Panel";
		$flagType = 16;
/*=========================================================================*/
        if ($User_Type == 'Selected') 
		{
            $user1 = $_POST['selected_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
            
        } else 
		{
            $User_Type = "Selected";
            $user1 = $_POST['all_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
        }
		
		if($popup_NOTIFICATION == 'POPUP_YES')
		{
			$res = $push->createpopup($POST_ID,$clientid,$POST_IMG,$FLAG,$DATE,$USERID);
			print_r($res);
		}


        /** ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push->getKeysPem($clientid);
        /*         * ************************************************************************************ */

        /*         * ********************* insert into database ************************************************ */
                                   
        $result = $obj->create_AchiverStory($clientid, $POST_TITLE, $POST_CONTENT, $POST_IMG, $device, $flagType, $like, $comment, $DATE, $USERID);
        
        $type = 'AStory';
        $result1 = $obj->createWelcomeData($clientid, $POST_ID, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID,$flagType);

        $groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
        $result1 = $read->StorySentToGroup($clientid, $maxid, $myArray[$k], $FLAG);
        }

        /** ****************  fetch all user employee id from user detail start **************************** */
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
        $token = json_decode($gcm_value, true);
      
        /***************************get group admin uuid  form group admin table if user type not= all *************************** */
        if ($User_Type != 'All') 
		{
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
            $adminuuid = json_decode($groupadminuuid, true);
           
            $allempid = array_merge($token, $adminuuid);
           
            $allempid1 = array_values(array_unique($allempid));
           
        } else 
		{
            $allempid1 = $token;
        }

        /** ******* insert into post sent to table for analytic sstart*************/

        $total = count($allempid1);
        for ($i = 0; $i < $total; $i++) 
		{
            $uuid = $allempid1[$i];

            if (!empty($uuid)) 
			{
                $read->postSentTo($clientid, $maxid, $uuid, $FLAG);
            } else {
                continue;
            }
        }
        /* * ******* insert into post sent to table for analytic sstart************ */

        /*         * *** get all registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($allempid1, $clientid);
        $token1 = json_decode($reg_token, true);
       
        /*         * *******************Create file of user which this post send  start******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = fopen("../send_push_datafile/" . $maxid . "-achiverstory.csv", "w");

        foreach ($val as $line) 
		{
            @fputcsv($file, @explode(',', $line));
        }
        fclose($file);

        /*         * *******************Create file of user which this post send End******************** */

        /*         * *******************check push notificaticon enabale or disable******************** */
        if ($PUSH_NOTIFICATION === 'PUSH_YES') 
		{

            /*             * ******************* send push by  push notification******************** */

            $hrimg = SITE_URL . $_SESSION['image_name'];
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();
            foreach ($token1 as $row) {

                if ($row['deviceName'] == 'ios') {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
                //array_push($ids,$row["registrationToken"]);
            }
           $content = str_replace("\r\n","",strip_tags($POST_CONTENT));
            $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $content , 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
	
            $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
            $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
            $rt = json_decode($revert, true);
			
            if ($rt) 
			{
             echo "<script>alert('Post Successfully Send');</script>";
             echo "<script>window.location='../create_achiver_story.php'</script>";      
            }
        }
		else 
		{
            echo "<script>alert('Post Successfully Send');</script>";
            echo "<script>window.location='../create_achiver_story.php'</script>";
        }


        /*         * **************************if condition 2 end**************************************************************** */
   
} 

   ?>