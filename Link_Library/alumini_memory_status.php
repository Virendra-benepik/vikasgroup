<?php
@session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../Class_Library/class_post.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_AlumniMemory.php');
require_once('../Class_Library/class_reading.php');

if (!empty($_POST)) {
    $push = new PushNotification();                         // object of class push notification page
    $obj = new Post();
    $alumni = new AlumniMemory();
    $read = new Reading();

    $memory_id = $_POST['memoryId'];
	$updatedby = $_SESSION['user_unique_id'];
    $poststatus = 1;
    $server = SITE_URL;
    $maxid = $obj->maxID();
    if ($_FILES['memoryImage']['error'] == 0) {
        $target = '../images/post_img/';   // folder name for storing data
        $folder = 'images/post_img/';      //folder name for add with image insert into table

        $path = $_FILES['memoryImage']['name'];
        $pathtemp = $_FILES['memoryImage']['tmp_name'];
        $path_name = $maxid . "-" . $path;
        $imagepath = $target . $path_name;
        $fullpath = SITE_URL . "images/post_img/" . $path_name;

        $push->compress_image($pathtemp, $imagepath, 20);

        $memory_image = $folder . $path_name;
    } else {
        $fullpath = SITE_URL . $_POST['hidMemoryImage'];
//        $path_name = $maxid . "-" . $_POST['hidMemoryImage'];
        $target = '../images/memories/';
        $path_name = basename(SITE_URL . $_POST['hidMemoryImage']);
        $memory_image = $_POST['hidMemoryImage'];
    }
    
    $thumb_image = $push->makeThumbnails($target, $path_name, 20);
    $thumb_img = str_replace('../', '', $thumb_image);
    
//    echo $thumb_img;die;
    $memory_status = 1;
    $result = $alumni->status_memory($memory_id, $memory_status, $updatedby);

    /*     * **************************************** check like & comment start ********************** */
    $like = 'LIKE_YES';
    if (!isset($like) && $like != 'LIKE_YES') {
        $like = 'LIKE_NO';
        $like_val = 'like_no';
    } else {
        $like_val = 'like_yes';
    }
    $comment = 'COMMENT_YES';
    if (!isset($comment) && $comment != 'COMMENT_YES') {
        $comment = 'COMMENT_NO';
        $comment_val = 'comment_no';
    } else {
        $comment_val = 'comment_yes';
    }

    $push_noti = 'PUSH_YES';
    if (!isset($push_noti) && $push_noti != 'PUSH_YES') {
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
	
    /*     * **************************************** check like & comment end ********************** */

    $USERID = $_POST['createdBy'];
    $BY = $_POST['auth'];
    $POST_ID = $memory_id;
    $POST_TITLE = $_POST['title'];
    $POST_IMG = $memory_image;
    $POST_IMG_THUMB = $thumb_img;
    $POST_CONTENT = $_POST['memory_content'];
    $DATE = date('Y-m-d H:i:s A');
    $FLAG = 1;
    $flag_name = "Memory : ";
   // $User_Type = 'Selected';
    $clientid = $_POST['clientId'];
	$User_Type = $_POST['user3'];
		
	 if ($User_Type == 'Selected') {
            $user1 = $_POST['selected_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
           /*    echo "selected user"."<br/>";
              echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>"; */
        } else {
            // echo "all user"."<br/>";
            $User_Type = "Selected";
          //    echo "user type:-".$User_Type;
            $user1 = $_POST['all_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
         /*    echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>"; */
        }

	if($popup_NOTIFICATION == 'POPUP_YES')
		{
			$res = $push->createpopup($maxid,$clientid,$POST_IMG,$FLAG,$DATE,$USERID);
			//print_r($res);
		}

    /*     * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
    $googleapiIOSPem = $push->getKeysPem($clientid);
    /*     * ************************************************************************************ */

    /*     * ********************* insert into database ************************************************ */

    $result = $obj->create_Post($clientid, $maxid, $POST_TITLE, $POST_IMG, $POST_IMG_THUMB, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment);

    $type = 'News';
    $result1 = $obj->createWelcomeData($clientid, $maxid, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID, $_POST['flag']);

    $groupcount = count($myArray);
    for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
        $result1 = $read->postSentToGroup($clientid, $maxid, $myArray[$k], $FLAG);
//echo $result1;
    }

    /*     * ****************  fetch all user employee id from user detail start **************************** */
    $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
    $token = json_decode($gcm_value, true);

    if ($User_Type != 'All') {
        $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
        $adminuuid = json_decode($groupadminuuid, true);
        $allempid = array_merge($token, $adminuuid);

        $allempid1 = array_values(array_unique($allempid));
    } else {
        $allempid1 = $token;
    }

    /*     * ******* insert into post sent to table for analytic start************ */

    $total = count($allempid1);
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->postSentTo($clientid, $maxid, $uuid, $FLAG);
        } else {
            continue;
        }
    }
    /*     * ******* insert into post sent to table for analytic start************ */


    /*     * *** get all registration token  for sending push **************** */
    $reg_token = $push->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);

    /*     * *******************Create file of user which this post send  start******************** */
    $val[] = array();
    foreach ($token1 as $row) {
        array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
    }

    $file = fopen("../send_push_datafile/" . $memory_id . ".csv", "w");

    foreach ($val as $line) {
        @fputcsv($file, @explode(',', $line));
    }
    @fclose($file);

    /*     * *******************Create file of user which this post send End******************** */

    /*     * *******************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') {

        /*         * ******************* send push by  push notification******************** */

        $hrimg = '';
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

        $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);

        $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

        $rt = json_decode($revert, true);
        $iosrt = json_decode($IOSrevert, true);

        if ($result) {
            echo "<script>alert('Memory has been Approved')</script>";
            echo "<script>window.location='" . $server . "view_alumni_memory.php'</script>";
        }
    }
}
?>