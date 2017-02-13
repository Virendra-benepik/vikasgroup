<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_post.php');
require_once('../Class_Library/class_push_notification.php');

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');


$obj = new Post();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
/* $db = new Connection_Client(); */

$read = new Reading();

$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/post_img/';   // folder name for storing data
$folder = 'images/post_img/';      //folder name for add with image insert into table

/* * ******************************START HERE************************************************ */
//echo "this is base path-".BASE_PATH;
//echo "this is site url-".SITE_URL;
if (!empty($_POST)) {

    $flag_value = $_POST['flag'];
    $flag_name = $_POST['flagvalue'];
    //echo "flag name-".$flag_name;
    $dev = $_POST['device'];
    if (isset($_POST['news_post'])) {

        if ($dev == 'd1') {
            $USERID = $_POST['author'];
            $BY = $_POST['auth'];
            $clientid = $_POST['client'];
        }
        if ($dev == 'd2') {
            $USERID = $_POST['useruniqueid'];
            $googleapi = $_POST['googleapi'];
//echo "user id - ".$USERID;
            $BY = $_SESSION['user_name'];
            $clientid = $_SESSION['client_id'];
//echo $clientid;
        }
        $path = $_FILES['uploadimage']['name'];
        $pathtemp = $_FILES['uploadimage']['tmp_name'];
//echo $path;
        $path_name = $maxid . "-" . $path;

        $imagepath = $target . $path_name;

        $fullpath = SITE_URL . "images/post_img/" . $path_name;
//echo $fullpath;
        $obj->compress_image($pathtemp, $imagepath, 20);

        $thumb_image = $push->makeThumbnails($target, $path_name, 20);
        $thumb_img = str_replace('../', '', $thumb_image);
        /*         * **************************************** check like & comment start ********************** */
        $like = $_POST['like'];
        if (!isset($like) && $like != 'LIKE_YES') {
            $like = 'LIKE_NO';
            $like_val = 'like_no';
        } else {
            $like_val = 'like_yes';
        }

        $comment = $_POST['comment'];
        if (!isset($comment) && $comment != 'COMMENT_YES') {
            $comment = 'COMMENT_NO';
            $comment_val = 'comment_no';
        } else {
            $comment_val = 'comment_yes';
        }


        $push_noti = $_POST['push'];
        if (!isset($push_noti) || $push_noti != 'PUSH_YES') {
            $PUSH_NOTIFICATION = 'PUSH_NO';
        } else {
            $PUSH_NOTIFICATION = 'PUSH_YES';
        }

        $popup_NOTIFICATION = "";
        if (!isset($_POST['popup'])) {
            $popup_NOTIFICATION = 'POPUP_NO';
        } else {
            $popup_NOTIFICATION = 'POPUP_YES';
        }
        //ECHO $popup_NOTIFICATION;
        /**         * *************************************** check like & comment end ********************** */
        $POST_ID = $maxid;
        $POST_TITLE = $_POST['title'];
        $POST_IMG = $folder . $path_name;
        $POST_CONTENT = $_POST['content'];
        //echo "thi sis post content-".$POST_CONTENT;
        $POST_IMG_THUMB = $thumb_img;
        $DATE = $post_date;
        $FLAG = $flag_value;
        $User_Type = $_POST['user3'];

        if ($User_Type == 'Selected') {
            $user1 = $_POST['selected_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
            /*  echo "selected user"."<br/>";
              echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>"; */
        } else {
            // echo "all user"."<br/>";
            $User_Type = "Selected";
            //  echo "user type:-".$User_Type;
            $user1 = $_POST['all_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
           /* echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>"; */
        }

        if ($popup_NOTIFICATION == 'POPUP_YES') {
            $res = $push->createpopup($POST_ID, $clientid, $POST_IMG, $FLAG, $DATE, $USERID);
            //print_r($res);
        }



        /** ******************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push->getKeysPem($clientid);
       // print_r($googleapiIOSPem);
        
        /*         * ************************************************************************************ */

        /*         * ********************* insert into database ************************************************ */
$teaser = "";
$devcie = 1;
        $result = $obj->create_Post($clientid, $POST_ID, $POST_TITLE, $POST_IMG, $POST_IMG_THUMB,$teaser, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment,$devcie);

        $type = 'News';
        $result1 = $obj->createWelcomeData($clientid, $POST_ID, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID, $FLAG);

        $groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
            $result1 = $read->postSentToGroup($clientid, $maxid, $myArray[$k], $FLAG);
//echo $result1;
        }

        /*         * ****************  fetch all user employee id from user detail start **************************** */
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
        $token = json_decode($gcm_value, true);
        /* echo "hello user  id";
          echo "<pre>";
          print_r($token);
          echo "</pre>"; */


        /*         * *************************get group admin uuid  form group admin table if user type not= all *************************** */
        if ($User_Type != 'All') {
//echo "within not all user type".$User_Type."<br/>";
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
            $adminuuid = json_decode($groupadminuuid, true);
            /*  echo "hello groupm admin id";
              echo "<pre>";
              print_r($adminuuid)."<br/>";
              echo "</pre>";
              echo "--------------all employee id---------"; */

            $allempid = array_merge($token, $adminuuid);
            /* echo "<pre>";
              print_r($allempid);
              echo "<pre>";

              echo "--------------all unique employee id---------"; */

            $allempid1 = array_values(array_unique($allempid));
            /*  echo "user unique id";
              echo "<pre>";
              print_r($allempid1);
              echo "<pre>"; */
        } else {
//echo "within all user type".$User_Type."<br/>";
            $allempid1 = $token;
        }

        /*         * ******* insert into post sent to table for analytic sstart************ */

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
        /*         * ******* insert into post sent to table for analytic sstart************ */

        /*         * *** get all registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($allempid1, $clientid);
        $token1 = json_decode($reg_token, true);
       /*  echo "----regtoken------";
          echo "<pre>";
          print_r($token1);
          echo "<pre>";*/
        /*********************Create file of user which this post send  start******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = fopen("../send_push_datafile/" . $maxid . ".csv", "w");

        foreach ($val as $line) {
            @fputcsv($file, @explode(',', $line));
        }
        @fclose($file);

        /*         * *******************Create file of user which this post send End******************** */

        /*         * *******************check push notificaticon enabale or disable******************** */
        if ($PUSH_NOTIFICATION == 'PUSH_YES') {

            /*             * ******************* send push by  push notification******************** */

            $hrimg = SITE_URL . $_SESSION['image_name'];

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
            $content = str_replace("\r\n", "", strip_tags($POST_CONTENT));
            $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);

           $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
            $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

            $rt = json_decode($revert, true);
            $iosrt = json_decode($IOSrevert, true);
//echo "<pre>";
//print_r($rt);
            if ($rt) {
                if ($dev == 'd1') {
                    echo "<script>alert('Post Successfully Send');</script>";
//echo $rt;
                } else {
                    echo "<script>alert('Post Successfully Send');</script>";
                  //  print_r($rt);
                  echo "<script>window.location='../postnews.php'</script>";
                }
            }
        } else {
            echo "<script>alert('Post Successfully Send');</script>";
           // echo "<script>window.location='../postnews.php'</script>";
        }


        /*         * **************************if condition 2 end**************************************************************** */
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="device" value="d1">
        <input type="hidden" name="flagvalue" value="News">
        <p> flag 1: fill all </p>
        <p> flag 2: fill only post content </p>
        <p> flag 3: fill only image and post content </p>
        <br/>
        <p>flag Value:
            <label for="textfield"></label>
            <select name="flag" id="textfield">
                <option selected>--select flag--</option>
                <option value='1'>1</option>

            </select>

        </p>
        <p>Post Title:
            <label for="textfield"></label>
            <input type="text" name="title" id="textfield">
        </p>
        <p>CLIENT
            <label for="textfield"></label>
            <input type="text" name="CLIENTID" id="textfield">
        </p>
        <p>Post image:
            <label for="textfield"></label>
            <input type="file" name="uploadimage" id="textfield">
        </p>
        <p>Post teaser:
            <label for="textfield"></label>
            <input type="text" name="teasertext" id="textfield">
        </p>
        <p>Post content:
            <label for="textfield"></label>
            <textarea name="content" id="textfield"></textarea>
        </p>
        <p> Author(Valid system generated  UU Id)<p>
            <label for="textfield"></label>
            <input type="Email" name="author" id="textfield">
        <p>
        <p>Client Id<p>
            <label for="textfield"></label>
            <input type="Email" name="client" id="textfield">
        <p>
        <p> Author name<p>
            <label for="textfield"></label>
            <input type="text" name="auth" id="textfield">
        <p>

            <input type="hidden" name="user3" id="textfield" value="All">

            <input type="submit" name="news_post" id="button" value="Submit">
        </p>
    </form>

    <?php
}
?>