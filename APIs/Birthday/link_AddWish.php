<?php

/* * ******************************** included class file and create object of class ****************************** */
/*
  Created By :- Monika Gupta
  Created Date :- 03/11/2016
  Description :- link files contain all fields from HTML file and create object of class files . call functions help of object and pass parameter into function .
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
if ((!class_exists("PushNotification") && include("../../Class_Library/class_push_notification.php")) &&
        (!class_exists("wish") && include("../../Class_Library/Api_Class/class_wish.php")) &&
        (!class_exists("User") && include("../../Class_Library/class_user.php"))) {

    $obj = new wish();
    $push = new PushNotification();                         // object of class push notification page
    $user = new User();

    /*     * ******************************** end included class file and create object of class ****************************** */

    /*     * ******************************START HERE************************************************ */

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }


//$wishdata = file_get_contents("php://input",true); 
    $jsonArr = json_decode(file_get_contents("php://input"), true);

    /* 		$wishcomment = "this is comment";

      $wishimgage ="";      // base 64 data

      $data['wishcomment'] = $wishcomment;
      $data['wishimage'] = $wishimgage;
      $data['clientid'] = $clientid;
      $data['employeeid'] = $employeeid;
      $data['wishflag'] = $wishflag;
      $data['createdby'] = $createdby;

      $wishdata = json_encode($data);
     */
    $wishcomm = "";
    //$wishimg = "";
    $imgname = "";

    if (!empty($jsonArr['clientid'])) {

        $request = $jsonArr;
        //print_r($request);die;

        $wishcomm = $request["wishcomment"];

        $wishimg = !empty($request["wishimage"]) ? $request["wishimage"] : '';

        $clientid = $request["clientid"];
        $employeeid = $request["employeeid"];

        $wishflag = $request["wishflag"];
        $createdby = $request["createdby"];

        $number = $obj->randomNumber(3);
        $maxid = $obj->maxId();
        //echo "rand number".$number; die;
        IF ($wishimg != "")
            $imgname = $obj->convertIntoImage($wishimg, $number);
        $fullpath = !empty($imgname) ? dirname(SITE_URL) . "/" . "images/wishimg/" . $imgname : "";

        //echo "thisis full path-".$fullpath;
        /*         * **********************get keypem****************************** */
        $googleapiIOSPem = $push->getKeysPem($clientid);

        /*         * ****************** end get key pem *************************** */

        /*         * ********************************* save wish ************************************** */
        $result = $obj->saveWish($wishcomm, $imgname, $clientid, $employeeid, $wishflag, $createdby);

        /*         * ******************************** end save wish *********************************** */


        /*         * ********************* like comment push notification ***************************** */
        $like = 'LIKE_YES';
        if (!isset($like) && $like != 'LIKE_YES') {
            $like = 0;
            $like_val = '';
        } else {
            $like_val = '';
            $like = 1;
        }

        $comment = 'COMMENT_YES';
        if (!isset($comment) && $comment != 'COMMENT_YES') {
            $comment = 0;
            $comment_val = '';
        } else {
            $comment_val = '';
            $comment = 1;
        }

        $PUSH_NOTIFICATION = 'PUSH_YES';
//    if (!isset($push_noti)) {
//        $PUSH_NOTIFICATION = 'PUSH_NO';
//    } else {
//        $PUSH_NOTIFICATION = 'PUSH_YES';
//    }

        /*         * **************************end like comment pushnotification ********************** */

        /*         * ***************************************** get user details ***************************** */
        $username = $user->getUserDetail($clientid, $createdby);
       //    print_r($username);
        /*         * ******************************* end get user details *********************************** */

        date_default_timezone_set('Asia/Calcutta');
        $POST_ID = $maxid;
        $POST_IMG = "";
        $POST_TITLE = $wishcomm;
        $POST_TEASER = "";
        $POST_CONTENT = substr($username['userName']['firstName'] . ' ' . $username['userName']['lastName'] . " Wished " . '"' . $wishcomm, 0, 30) . '....."';
        $DATE = date('Y-m-d H:i:s');
        $FLAG = 19;
        $flag_name = "Wish : ";
        $BY = $username['userName']['firstName'] . ' ' . $username['userName']['lastName'];

        /*         * ************************ fet user image *********************************** */
        $imgdev = "dev";
        $userimage = $push->getImage($createdby, $imgdev);
        //print_r($userimage);
        $image = $userimage[0]['userImage'];
        $userimg = $image;
        /*         * ********************************end get user image ***************************** */

        $employeeId = array($employeeid);

        /*         * ************************** get registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($employeeId, $clientid);
        $token1 = json_decode($reg_token, true);

        //echo "registration token ";
        //print_r($token1);
        /*         * ***************************** end get registration token  for sending push  ************************** */

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

        /*         * ******************************************************************************************* */

        $hrimg = $userimg;
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

        $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);

        //print_r($data);

        $device = 'ios';
        $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile'],$device);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

        $rt = json_decode($revert, true);
        //$iosrt = json_decode($IOSrevert, true);
        //print_r($rt);
        //print_r($iosrt);

        echo $result;
    } else {
        $result['status'] = 0;
        $result['msg'] = "invalid json";
        echo json_encode($result);
    }
}
?>