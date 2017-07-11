<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);

if ((!class_exists('Reading') && include("../../Class_Library/class_reading.php")) && (!class_exists("Post") && include("../../Class_Library/class_post.php")) && (!class_exists("PushNotification") && include("../../Class_Library/class_push_notification.php"))) {

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
    "client_id":"CO-25",
         "author":"",
            "auth":"",
            "selected_user":"",
            "title":"",
            "content":"",
           "device":""
 }*/
//print_r($jsonArr);
    /********************************START HERE************************************************ */
    if (!empty($jsonArr['client_id'])) {
        date_default_timezone_set('Asia/Calcutta');
        $post_date = date('Y-m-d H:i:s A');

        $obj = new Post();                                        // object of class post page
        $push = new PushNotification();                         // object of class push notification page
        $db = new Connection_Communication();

        $read = new Reading();

        $maxid = $obj->maxID();  //---------get latest post_id

        $target = '../images/post_img/';   // folder name for storing data
        $folder = 'images/post_img/';      //folder name for add with image insert into table

        $USERID = $jsonArr['author'];
        $BY = $jsonArr['auth'];

        $User_Type = "Selected";
        $clientid = $jsonArr['client_id'];

        if ($User_Type == 'Selected') {
            $user1 = rtrim($jsonArr['selected_user'], ',');
            $myArray = explode(',', $user1);
        } else {
            $User_Type = "Selected";
            $user1 = rtrim($jsonArr['selected_user'], ',');
            $myArray = explode(',', $user1);
        }

        $POST_ID = $maxid;
        $POST_TITLE = $jsonArr['title'];
        $POST_IMG = "";
        $POST_THUMB_IMG = "";
        $POST_TEASER = "";
        $POST_CONTENT = $jsonArr['content'];
        $device = $jsonArr['device'];
        $DATE = $post_date;
        $FLAG = 2;
        $flag_name = "Message : ";
        /********************************************** like push selection start ***************************************** */
        $like = 'LIKE_YES';
        if (!isset($like) && $like != 'LIKE_YES') {
            $like = 'LIKE_NO';
            $like_val = 'No';
        } else {
            $like_val = 'Yes';
        }

        $comment = 'COMMENT_YES';
        if (!isset($comment) && $comment != 'COMMENT_YES') {
            $comment = 'COMMENT_NO';
            $comment_val = 'No';
        } else {
            $comment_val = 'Yes';
        }

        $push_noti = 'PUSH_NO';

        if (!isset($push_noti) && $push_noti != 'PUSH_YES') {
            $PUSH_NOTIFICATION = 'PUSH_NO';
        } else {
            $PUSH_NOTIFICATION = 'PUSH_YES';
        }

		$devname = "dev";
        $userimage = $push->getImage($USERID,$devname);

        $image = $userimage[0]['userImage'];



        /*         * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push->getKeysPem($clientid);
        /*         * ************************************************************************************ */

        /*         * ********************* insert into database ************************************************ */
//echo $device;
$teaser = "";
        $result = $obj->create_Post($clientid, $POST_ID, $POST_TITLE, $POST_IMG,$POST_THUMB_IMG, $teaser, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment, $device);

        $type = 'Message';
        $result1 = $obj->createWelcomeData($clientid, $POST_ID, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID, $FLAG);

        $groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
            $result1 = $read->postSentToGroup($clientid, $maxid, $myArray[$k], $FLAG);
//echo $result1;
        }
        /** ****************  fetch all user employee id from user detail start **************************** */
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
        $token = json_decode($gcm_value, true);
        /* echo "hello user  id";
          echo "<pre>";
          print_r($token);
          echo "</pre>"; */


        /*************get group admin uuid  form group admin table if user type not= all *********************** */
        
        
        if ($User_Type != 'All') {
            //$groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);


            //$adminuuid = json_decode($groupadminuuid, true);
            /* echo "hello groupm admin id";
              echo "<pre>";
              print_r($adminuuid)."<br/>";
              echo "</pre>";
              "--------------all employee id---------"; */

          //  $allempid = array_merge($token, $adminuuid);
            $allempid = array_merge($token);
            /* echo "<pre>";
              print_r($allempid);
              echo "<pre>";

              "--------------all unique employee id---------"; */

            $allempid1 = array_values(array_unique($allempid));
            /* echo "unique id"."<br/>";
              echo "<pre>";
              print_r($allempid1);
              echo "<pre>"; */
        } else {
            $allempid1 = $token;
        }

        /******** insert into post sent to table for analytic sstart************ */
        
        $total = count($allempid1);
        /* echo "<pre>";
          print_r($allempid1); die;
          echo "<pre>"; */

        for ($i = 0; $i < $total; $i++) {
            $uuid = $allempid1[$i];
//echo "post sent to empid:--".$uuid."<br/>";
            if (!empty($uuid)) {

               $read->postSentTo($clientid, $maxid, $uuid);
            }
        }
        /*         * ******* insert into post sent to table for analytic sstart************ */

        /*         * *** get all registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($allempid1, $clientid);
        $token1 = json_decode($reg_token, true);
        /* echo "----regtoken------";
          echo "<pre>"; */
//          print_r($token1);die;
          /*echo "<pre>"; */

        /*         * *******************Create file of user which this post send  start******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = @fopen("../send_push_datafile/" . $maxid . ".csv", "w");

        foreach ($val as $line) {
            @fputcsv($file, @explode(',', $line));
        }
        @fclose($file);
        /*         * *******************Create file of user which this post send End******************** */
        /*         * *******************check push notificaticon enabale or disable******************** */
       // $PUSH_NOTIFICATION = "PUSH_NO";
        
        if ($PUSH_NOTIFICATION == 'PUSH_YES') 
            {
            $hrimg = $image;
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();
            foreach ($token1 as $row) {
                if ($row['deviceName'] == 3) {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
            }

            $data = array('Id' => $maxid, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
            $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile'],$device);
            $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

			//print_r($data);
			
            $rt = json_decode($revert, true);
            if ($rt['success'] == 1) {
                //$response = $revert;
			   $response['success'] = 1;
			   $response['msg'] = "Post send";
			   $response = json_encode($response);
            }
        } else {
            //$response = $rt;
			$response['success'] = 0;
			$response['msg'] = "There is some Error , please contact info@benepik.com";
			$response = json_encode($response);
        }
    } else {
        $response['success'] = 0;
        $response['msg'] = "Invalid json";

        $response = json_encode($response);
    }
    header('Content-type: application/json');
    echo ($response);
}
?>
