<?php

error_reporting(E_ALL ^ E_NOTICE);
if ((file_exists("../../Class_Library/class_poll.php") && include_once("../../Class_Library/class_poll.php")) &&
        (file_exists("../../Class_Library/class_push_notification.php") && include("../../Class_Library/class_push_notification.php")) &&
        (file_exists("../../Class_Library/class_reading.php") && include("../../Class_Library/class_reading.php")) &&
        (file_exists("../../Class_Library/class_welcomeTable.php") && include("../../Class_Library/class_welcomeTable.php"))
) {

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
    if (!empty($jsonArr['clientid'])) {
        $obj = new Poll();
        $read = new Reading();
        $push = new PushNotification();
        $pollmax = $obj->pollMaxId();
        $welcome_obj = new WelcomePage();

//echo "poll max:-".$pollmax."<br/>";

        $cid = $jsonArr['clientid'];
        $uid = $jsonArr['uuid'];
        $uname = $jsonArr['uname'];
        $ques = $jsonArr['poll_ques'];

        $option = $jsonArr['poll_option'];
        $optionflag = $jsonArr['optflag'];

//        $device = $jsonArr['device'];

        $FLAG = 4;
        date_default_timezone_set('Asia/Calcutta');
        $c_date = date('Y-m-d H:i:s');
        $User_Type = $jsonArr['user3'];
//        $googleapi = $jsonArr['gpk'];

        $flag_name = "Poll : ";
        $ptime = $jsonArr['publish_time'];
        $utime = $jsonArr['unPublish_time'];

//        if ($_GET['device'] == 'ios') {
//
//            $po = $_GET['poll_option'];
//            $pq = $_GET['poll_ques'];
//            $su = $_GET['selected_user'];
//
//            $option = base64_decode($po);
//            $ques = base64_decode($pq);
//
//            $ptime = base64_decode($_GET['pubtime']);
//
//            $day = $_GET['day'];
//            $hour = $_GET['hour'];
//            $min = $_GET['min'];
//
//            $dat = '+' . $day . ' day +' . $hour . ' hour +' . $min . ' minutes';
//            $utime = date('Y-m-d h:i:s', strtotime($dat, strtotime($ptime)));
//        }

        $User_Type = 'Selected';

        if ($User_Type == 'Selected') {
            $user1 = $jsonArr['selected_user'];

//            if (!empty($_GET['selected_user'])) {
//                $user1 = base64_decode($_GET['selected_user']);
//            }
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
            $groupdata = json_encode($myArray);
        } else {
            $groupdata = $User_Type;
        }

//$ptime = "";
//$utime = "";
//$group = "All";
        /* echo "client id:-".$cid."<br/>";
          echo "uuid id:-".$uid."<br/>";
          echo "ques :-".$ques."<br/>";
          echo "option:-".$option."<br/>";
          echo "<pre>";
          print_r($myArray);
          echo "</pre>"; */

        $option1 = $option;
        $count = count($option1);


        /*         * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push->getKeysPem($cid);
        /*         * ************************************************************************************ */

        for ($i = 0; $i < $count; $i++) {

//echo "<script>alert(' the option flag is $optionflag ')</script>";
            if ($optionflag == 1) {

//echo "<script>alert(' bhai option flag one hogaya hai ')</script>";
                $optionmax = $obj->optionMaxId();
                $optiontext = $option1[$i];

//echo $optiontext."<br/>";

                $ansbyimg = "";
                $res = $obj->insertAnswerOptions($cid, $pollmax, $optionmax, $optiontext, $ansbyimg);

//echo "<script>alert('$res')</script>";
            }
            if ($optionflag == 2) {
                $optionmax = $obj->optionMaxId();
                $optionimg = $option1[$i];

                $img = imagecreatefromstring(base64_decode($optionimg));

                if ($img != false) {
                    $imgpath = SITE_URL . $pollmax . "-" . $optionmax . '.jpg';
                    imagejpeg($img, $imgpath); //for converting jpeg of image

                    $ansbyimg = 'Poll/poll_ansimg/' . $pollmax . "-" . $optionmax . '.jpg';
                }

                $optiontext = "";
                $res = $obj->insertAnswerOptions($cid, $pollmax, $optionmax, $optiontext, $ansbyimg);
            }
        }

        $hrimg1 = $push->getImage($uid);
        $hrimg  = $hrimg1[0]['userImage'];
//echo "this is hr image:=".$hrimg;


        $img1 = "Poll/welcome_pollShow.jpg";

        $result = $obj->createPoll($pollmax, $cid, $img1, $ques, $groupdata, $uid, $ptime, $utime, $c_date);

        $type = "Poll";
        $flag = 4;
//$img  = "";
        $result1 = $welcome_obj->createWelcomeData($cid, $pollmax, $type, $ques, $img1, $ptime, $uid, $flag);

//$result = $obj->create_Like($clientid,$post_id,$employeeid);

        $groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
            $result1 = $read->pollSentToGroup($cid, $pollmax, $myArray[$k]);
//echo $result1;
        }
        /* -------------------------------------------------------------------- */
        /*         * ****************  fetch all user employee id from user detail start **************************** */
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $cid);
        $token = json_decode($gcm_value, true);
        /* echo "hello user  id";
          echo "<pre>";
          print_r($token);
          echo "</pre>"; */


        /*         * *************************get group admin uuid  form group admin table if user type not= all *************************** */
        if ($User_Type != 'All') {
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $cid);


            $adminuuid = json_decode($groupadminuuid, true);
            /* echo "hello groupm admin id";
              echo "<pre>";
              print_r($adminuuid)."<br/>";
              echo "</pre>"; */
            /*             * ****** "--------------all employee id---------"** */

            $allempid = array_merge($token, $adminuuid);
            /* echo "<pre>";
              print_r($allempid);
              echo "<pre>"; */

            /*             * ** "--------------all unique employee id---------"********** */

            $allempid1 = array_values(array_unique($allempid));
            /* echo "user unique id";
              echo "<pre>";
              print_r($allempid1);
              echo "<pre>"; */
        } else {
            $allempid1 = $token;
        }

        /*         * ******* insert into post sent to table for analytic sstart************ */

        $total = count($allempid1);
        for ($i = 0; $i < $total; $i++) {
            $uuid = $allempid1[$i];
            $k = $read->PollSentTo($cid, $pollmax, $uuid);
        }
//echo "insert in read : ".$k;
        /*         * ******* insert into post sent to table for analytic sstart************ */

        /*         * *** get all registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($allempid1, $cid);
        $token1 = json_decode($reg_token, true);
        /* echo "----regtoken------";
          echo "<pre>";
          print_r($token1);
          echo "<pre>"; */

        /*         * *******************check push notificaticon enabale or disable******************** */

        $hrimg = SITE_URL. $hrimg;
//echo "hr image:-".$hrimg;
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
//         echo "<pre>";
//          print_r($ids);die;
        

        $data = array('Id' => $pollmax, 'Content' => $ques, 'SendBy' => $uname, 'image' => $fullpath, 'Picture' => $hrimg,
            'Publishing_time' => $ptime, 'Unpublishing_time' => $utime, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);

        $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
        $rt = json_decode($revert, true);
 


        /* ------------------------------------------------------------------------------------------------------- */
        $response = $revert;
    } else {
        $result['success'] = 0;
        $result['result'] = "Invalid json";

        $response = json_encode($result);
    }
    header('Content-type: application/json');
    echo $response;
}
?>