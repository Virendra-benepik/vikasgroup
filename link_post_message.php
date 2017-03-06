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
    $flag_value = 2;
    $flag_name = "Message : ";
//extract($_POST);
    $comment = "";
    /*     * **************************if condition 2  start**************************************************************** */

    $dev = $_POST['device'];

    if ($dev == 'd2') {
        $USERID = $_POST['useruniqueid'];

        $googleapi = $_POST['googleapi'];

//echo "unique user id :--".$USERID."<BR/>";
        $BY = $_SESSION['user_name'];
        $User_Type = $_POST['user3'];
        $clientid = $_SESSION['client_id'];
//echo $User_Type;
        
    } else {
        $USERID = $_POST['author'];
        $BY = $_POST['auth'];
        $User_Type = $_POST['user3'];
        $clientid = $_POST['client_id'];
        $googleapi = $_POST['gpk'];
        $PUSH_NOTIFICATION = "PUSH_YES";
//echo $User_Type;
       
    }

    $POST_ID = $maxid;
    $POST_TITLE = trim($_POST['title']);
    $POST_IMG = "";
	$thumb_img = "";
    $POST_TEASER = "";
    $POST_CONTENT = trim($_POST['content']);
    $DATE = $post_date;
    $FLAG = $flag_value;

    /*     * ******************************************** like push selection start ***************************************** */
    $like = $_POST['like'];
    if (!isset($like) && $like != 'LIKE_YES') {
        $like = 'LIKE_NO';
        $like_val = 'No';
    } else {
        $like_val = 'Yes';
    }

    $comment = $_POST['comment'];
    if (!isset($comment) && $comment != 'COMMENT_YES') {
        $comment = 'COMMENT_NO';
        $comment_val = 'No';
    } else {
        $comment_val = 'Yes';
    }
    $push_noti = $_POST['push'];
    if (!isset($push_noti) && $push_noti != 'PUSH_YES') {
        $PUSH_NOTIFICATION = 'PUSH_NO';
    } else {
        $PUSH_NOTIFICATION = 'PUSH_YES';
    }

    /*     * ******************************************** like push selection end ***************************************** */

//echo $PUSH_NOTIFICATION;
//echo $comment;

    /*     * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
	
	/************************ user group ***********************************************/
	
	if ($User_Type == 'Selected') {
            $user1 = $_POST['selected_user'];
            $user2 = rtrim($user1, ',');

            $myArray = explode(',', $user2);
			
			/*echo "<pre>";
			echo "selected";
			print_r($myArray);
			echo "</pre>";*/
			
        } else {
           // echo "all user"."<br/>";
            $User_Type = "Selected";
          //  echo "user type:-".$User_Type;
            $user1 = $_POST['all_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
            /*  echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>";*/
        }
	
	/************************************** end user group *****************************/
    $googleapiIOSPem = $push->getKeysPem($clientid);
    /*     * ************************************************************************************ */

    /*     * *********************************** Get User Image ******************************************** */
    $userimage = $push->getImage($USERID);
    $image = $userimage[0]['userImage'];
    //print_r($userimage);
    /*     * ********************************************************************************** */

    /*     * ********************* insert into database ************************************************ */
$teaser = "";
$device = 1;
    $result = $obj->create_Post($clientid, $POST_ID, $POST_TITLE, $POST_IMG, $thumb_img, $teaser, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment,$device);

    $type = 'Message';
    $result1 = $obj->createWelcomeData($clientid, $POST_ID, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID, $FLAG);

    $groupcount = count($myArray);
    for ($k = 0; $k < $groupcount; $k++) {
	//echo "group id".$myArray[$k];
        $result1 = $read->postSentToGroup($clientid, $maxid, $myArray[$k], $FLAG);
//echo $result1;
    }

    /*     * ****************  fetch all user employee id from user detail start **************************** */
    $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
    $token = json_decode($gcm_value, true);
   /* echo "hello user  id";
      echo "<pre>";
      print_r($token);
      echo "</pre>";*/


    /*     * *************************get group admin uuid  form group admin table if user type not= all *************************** */
    if ($User_Type != 'All') {
        $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);


        $adminuuid = json_decode($groupadminuuid, true);
       /*  echo "hello groupm admin id";
          echo "<pre>";
          print_r($adminuuid)."<br/>";
          echo "</pre>";*/
         

        $allempid = array_merge($token, $adminuuid);
        /* echo "<pre>";
		 echo "employee and admin";
          print_r($allempid);
          echo "<pre>";*/

         

        $allempid1 = array_values(array_unique($allempid));
         /*echo "unique id"."<br/>";
          echo "<pre>";
          print_r($allempid1);
          echo "<pre>"; */
    } else {
        $allempid1 = $token;
    }

    /*     * ******* insert into post sent to table for analytic sstart************ */

    $total = count($allempid1);
    /* echo "<pre>";
      print_r($allempid1);
      echo "<pre>"; */

    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
  //echo "post sent to empid:--".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->postSentTo($clientid, $maxid, $uuid, $FLAG);
        }
    }
    /*     * ******* insert into post sent to table for analytic sstart************ */

    /*     * *** get all registration token  for sending push **************** */
    $reg_token = $push->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
   /* echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>"; */

    /*     * *******************Create file of user which this post send  start******************** */
    $val[] = array();
    foreach ($token1 as $row) {
        array_push($val, $row["userUniqueId"] . "," . $row["registrationToken"]);
    }

    $file = fopen("../send_push_datafile/" . $maxid . ".csv", "w");

    foreach ($val as $line) {
        fputcsv($file, explode(',', $line));
    }
    fclose($file);
    /*     * *******************Create file of user which this post send End******************** */
    /*     * *******************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') {
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

            //array_push($ids,$row["registrationToken"]);
        }

        $data = array('Id' => $maxid, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
		
		//print_r($data);
		
//echo "hello";
//echo'<pre>';print_r($idsIOS);die;
        $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
        $rt = json_decode($revert, true);
		
		//print_r($rt);
		//print_r($IOSrevert);
		
		
//echo $IOSrevert;
        if ($rt['success'] == 1) {
            if ($dev == 'd2') {
                echo "<script>alert('Post Successfully Send');</script>";
                echo "<script>window.location='../postmessage.php'</script>";
//print_r($rt);
            } else {
                echo $revert;
            }
        }
    } else {
        echo "<script>alert('Post Successfully Send');</script>";
        echo "<script>window.location='../postmessage.php'</script>";
    }
} else {
    ?>

    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="device" value="d1">
        <input type="hidden" name="flagvalue" value="Message">
        <input type="hidden" name="push" value="PUSH_YES" id="textfield">
        <p> flag 1: fill all </p>
        <p> flag 2: fill only post content </p>
        <p> flag 3: fill only image and post content </p>
        <br/>
        <p>flag Value:
            <label for="textfield"></label>
            <select name="flag" id="textfield">
                <option selected>--select flag--</option>

                <option value='2'>2</option>

            </select>

        </p>
        <p>client id:
            <label for="textfield"></label>
            <input type="text" name="client_id" id="textfield" value="" required>

        </p>


        <p> google api key:
            <label for="textfield"></label>
            <input type="text" name="gpk" id="textfield" value="" required>

        </p>
        <p>Post content:
            <label for="textfield"></label>
            <textarea name="content" id="textfield"></textarea>

        </p>
        <p> Author(Valid user unique id)
            <label for="textfield"></label>
            <input type="text" name="author" id="textfield" value="" required>
        </p>

        <p> 
            <label for="textfield">Author name</label>
            <input type="text" name="auth" id="textfield" value="" required>
        </p>

        <p> 
            <label for="textfield">Like(Enable/Disable)</label>
            <input type="checkbox" name="like" id="textfield" value="LIKE_YES" checked>
        </p>

        <p> 
            <label for="textfield">Comment(Enable/Disable)</label>
            <input type="checkbox" name="comment" id="textfield" value="COMMENT_YES" checked>
        </p>

        <p>Select
            <label for="textfield"></label>
            <select name="user3" id="textfield">
                <option selected>--select flag--</option>

                <option value='All'>All</option>
                <option value='Selected'>Selected</option>

            </select>
        </p>
        <p>
            if selected write group id end with ,
            <input type="text" name="selected_user" id="textfield" placeholder="write group id end with ,">
        </p>
        <p>
            <input type="submit" name="news_post" id="button" value="Submit">
        </p>
    </form>

    <?php
}
?>
