<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_post.php');
require_once('../Class_Library/class_push_notification.php');

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');

$obj = new Post();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
//$db = new Connection_Client();

$read = new Reading();

$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/post_img/';   // folder name for storing data
$folder = 'images/post_img/';      //folder name for add with image insert into table

/* * ******************************START HERE************************************************ */
if (!empty($_POST)) {
    $flag_value = $_POST['flag'];
    if (isset($_POST['news_post'])) {
//extract($_POST);


  /****************************if condition 2 end*****************************************************************/
        if ($flag_value == 3) {

            $dev = $_POST['device'];
            if ($dev == 'd1') {
                $USERID = $_POST['author'];
                $BY = $_POST['auth'];
                $clientid = $_POST['client_id'];
                $googleapi = $_POST['googleapi'];
            }
            if ($dev == 'd2') {
                $USERID = $_POST['useruniqueid'];
                $googleapi = $_POST['googleapi'];
                $BY = $_SESSION['user_name'];
                $clientid = $_SESSION['client_id'];
            }

//echo "unique user id :--".$USERID;
            $path = $_FILES['uploadimage']['name'];
            $pathtemp = $_FILES['uploadimage']['tmp_name'];

//echo "image name ".$path;
//print_r($path);
            $path_name = $maxid . "-" . $path;

//echo "path name ".$path_name;

            $imagepath = $target . $path_name;

            $fullpath = SITE_URL . "/images/post_img/" . $path_name;

//echo "full path :-".$fullpath;
            $res = $obj->compress_image($pathtemp, $imagepath, 20);
            $thumb_image = $push->makeThumbnails($target, $path_name, 20);
            $thumb_img = str_replace('../', '', $thumb_image);
// echo "result of compress image ".$res;
            /*             * ********************************************* LIKE COMENT PUSH STATUS START ********************* */
            $flag_name = $_POST['flagvalue'];
            $like = $_POST['like'];
            if (!isset($like) && $like != 'LIKE_YES') {
                $like = 'LIKE_NO';
                $like_val = 'No';
            } else {
                $like_val = 'Yes';
            }
//echo $like;
//echo "<br/>";
            $comment = $_POST['comment'];
            if (!isset($comment) && $comment != 'COMMENT_YES') {
                $comment = 'COMMENT_NO';
                $comment_val = 'No';
            } else {
                $comment_val = 'Yes';
            }
//echo $comment;
            $push_noti = $_POST['push'];
            if (!isset($push_noti) && $push_noti != 'PUSH_YES') {
                $PUSH_NOTIFICATION = 'PUSH_NO';
            } else {
                $PUSH_NOTIFICATION = 'PUSH_YES';
            }
//echo $PUSH_NOTIFICATION;
            /*             * ************************************ LIKE COMMENT PUSH END *********************** */

            $POST_ID = $maxid;
            $POST_TITLE = "";
            $POST_IMG = $folder . $path_name;
            $POST_TEASER = "";
            $POST_IMG_THUMB = $thumb_img;
            $POST_CONTENT = trim($_POST['content']);
            $DATE = $post_date;
            $USEREMAIL = $_SESSION['user_email'];
            $BY = $_SESSION['user_name'];
            $FLAG = $flag_value;
            $User_Type = $_POST['user3'];
//echo $User_Type;
            if ($User_Type == 'Selected') {
                $user1 = $_POST['selected_user'];
                $user2 = rtrim($user1, ',');
                $myArray = explode(',', $user2);
                /*   echo "<pre>"; 
                  print_r($myArray)."<br/>";
                  echo "</pre>"; */
            } else {
                // echo "all user"."<br/>";
                $User_Type = "Selected";
                //echo "user type:-".$User_Type;
                $user1 = $_POST['all_user'];
                $user2 = rtrim($user1, ',');
                $myArray = explode(',', $user2);
                /*   echo "<pre>";
                  print_r($myArray)."<br/>";
                  echo "</pre>"; */
            }


            /*             * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
            $googleapiIOSPem = $push->getKeysPem($clientid);
            /*             * ************************************************************************************ */

            /*             * ********************* insert into database ************************************************ */
                                     // $clientid, $POST_ID, $POST_TITLE, $POST_IMG, $POST_IMG_THUMB, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment
            $device = 1;
            $result = $obj->create_Post($clientid, $POST_ID, $POST_TITLE, $POST_IMG, $POST_IMG_THUMB,$POST_TEASER, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment,$device);

            $type = 'Picture';
            $result1 = $obj->createWelcomeData($clientid, $POST_ID, $type, $POST_CONTENT, $POST_IMG, $DATE, $USERID,$FLAG);

            $groupcount = count($myArray);
            for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
                $result2 = $read->postSentToGroup($clientid, $POST_ID, $myArray[$k],$FLAG);
//echo $result2;
            }

            /*             * ****************  fetch all user employee id from user detail start **************************** */
            $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
            $token = json_decode($gcm_value, true);
            /* echo "hello user  id";
              echo "<pre>";
              print_r($token);
              echo "</pre>"; */


            /*******get group admin uuid  form group admin table if user type not= all *************************** */
   
           
     if ($User_Type != 'All') {
   
    
               // $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);


               // $adminuuid = json_decode($groupadminuuid, true);
                /* echo "hello groupm admin id";
                  echo "<pre>";
                  print_r($adminuuid)."<br/>";
                  echo "</pre>"; */
                /*                 * ****** "--------------all employee id---------"** */

               // $allempid = array_merge($token, $adminuuid);
                $allempid = array_merge($token);
                /* echo "<pre>";
                  print_r($allempid);
                  echo "<pre>"; */

                /* "--------------all unique employee id---------" */

                $allempid1 = array_values(array_unique($allempid));
                /* echo "<pre>";
                  print_r($allempid1);
                  echo "<pre>"; */
            } else {
                $allempid1 = $token;
            }
 
            /*             * ******* insert into post sent to table for analytic sstart************ */

            $total = count($allempid1);
            for ($i = 0; $i < $total; $i++) {
                $uuid = $allempid1[$i];
//echo "post sent to empid:--".$uuid."<br/>";
                if (!empty($uuid)) {
                    $read->postSentTo($clientid, $maxid, $uuid,$FLAG);
                }
            }
            /*             * ******* insert into post sent to table for analytic sstart************ */

            /*             * *** get all registration token  for sending push **************** */
            $reg_token = $push->getGCMDetails($allempid1, $clientid);
            $token1 = json_decode($reg_token, true);
              /*echo "----regtoken------";
              echo "<pre>";
              print_r($token1);
              echo "<pre>";*/
            /*             * *******************Create file of user which this post send  start******************** */
            $val[] = array();
            foreach ($token1 as $row) {
                array_push($val, $row["userUniqueId"] . "," . $row["registrationToken"]);
            }

            $file = fopen("../send_push_datafile/" . $maxid . ".csv", "w");

            foreach ($val as $line) {
                fputcsv($file, explode(',', $line));
            }
            fclose($file);

            /*             * *******************Create file of user which this post send End******************** */

            /*             * *******************check push notificaticon enabale or disable******************** */
            if ($PUSH_NOTIFICATION == 'PUSH_YES') {

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
                    //array_push($ids,$row["registrationToken"]);
                }


                $data = array('Id' => $maxid, 'Title' => $POST_CONTENT, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf,
                    'like' => $like_val, 'comment' => $comment_val);

					//print_r($data);
					
                $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
                $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
                $rt = json_decode($revert, true);
                
				/*echo "<pre>";
				print_r($IOSrevert);
				print_r($rt);*/
                if ($rt) {
                    if ($dev == 'd2') {
                        echo "<script>alert('Post Successfully Send');</script>";
                        echo "<script>window.location='../postpicture.php'</script>";
//print_r($rt);
                    } else {
                        echo "<script>alert('Post Successfully Send');</script>";
                        echo $rt;
                    }
                }
            } else {
                echo "<script>alert('Post Successfully Send');</script>";
                echo "<script>window.location='../postpicture.php'</script>";
            }
        }
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="device" value="d1">
        <p> flag 1: fill all </p>
        <p> flag 2: fill only post content </p>
        <p> flag 3: fill only image and post content </p>
        <br/>
        <p>flag Value:
            <label for="textfield"></label>
            <select name="flag" id="textfield">
                <option selected>--select flag--</option>

                <option value='3'>3</option>
            </select>

        </p>
        <p>client id:
            <label for="textfield"></label>
            <input type="text" name="client_id" id="textfield">
        </p>
        <p>googleapi:
            <label for="textfield"></label>
            <input type="text" name="googleapi" id="textfield">
        </p>
        <p>Post image:
            <label for="textfield"></label>
            <input type="file" name="uploadimage" id="textfield">
        </p>

        <p>Post content:
            <label for="textfield"></label>
            <textarea name="content" id="textfield"></textarea>

        </p>
        <p> Author(Valid user unique id)<p>
            <label for="textfield"></label>
            <input type="Email" name="author" id="textfield">
        <p>

        <p> Author name<p>
            <label for="textfield"></label>
            <input type="text" name="auth" id="textfield">
        <p>
            write(All/Selected):
            <input type="text" name="user3" id="textfield" value="">
        <p>
        <p>
            Group id:
            <input type="text" name="selected_user" id="textfield" placeholder="write group id end with ,">
        <p>


        <p>
            <input type="submit" name="news_post" id="button" value="Submit">
        </p>
    </form>

    <?php
}
?>