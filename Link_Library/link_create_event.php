<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_event.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_welcomeTable.php');

date_default_timezone_set('Asia/Calcutta');
$event_date = date('Y-m-d H:i:s A');


$obj = new Event();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
//$db = new Connection_Mahle();
$read = new Reading();
$welcome_obj = new WelcomePage();

$maxeventid = $obj->getMaxEventId();  //---------get latest post_id

$folder = '../Event/event_img/';   // folder name for storing data
$target = 'Event/event_img/';      //folder name for add with image insert into table

/* * ******************************START HERE************************************************ */
if (!empty($_POST)) {

    $flag_value = $_POST['flag'];
    $dev = $_POST['device'];

    if ($dev == 'd2') {
        $USERID = $_POST['useruniqueid'];
        $googleapi = $_POST['googleapi'];
//echo "user id - ".$USERID;
        $BY = $_SESSION['user_name'];
        $clientid = $_SESSION['client_id'];
//echo $clientid;
    } else {
        $USERID = $_POST['author'];
        $BY = $_POST['auth'];
        $clientid = $_POST['client'];
    }


    $path = $_FILES['uploadimage']['name'];
    $pathtemp = $_FILES['uploadimage']['tmp_name'];
//echo $path;
    $path_name = $maxeventid . "-" . $path;

    $imagepath = $folder . $path_name;
    
    $fullpath = SITE_URL . $path_name;
//echo $fullpath;
    $push->compress_image($pathtemp, $imagepath, 20);

    /*     * **************************************** check like & comment start ********************** */
    /*     * *** no need this time

      $like = $_POST['like'];
      if(!isset($like) && $like != 'LIKE_YES')
      {
      $like = 'LIKE_NO';
      $like_val = 'No';
      }
      else
      {
      $like_val = 'Yes';
      }

      $comment =  $_POST['comment'];
      if(!isset($comment) && $comment != 'COMMENT_YES')
      {
      $comment = 'COMMENT_NO';
      $comment_val = 'No';
      }
      else
      {
      $comment_val = 'Yes';
      }
     */
//$push_noti =  "PUSH_YES";
    $push_noti = "";
    if (!isset($push_noti)) {
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

    $EVENT_ID = $maxeventid;
    $EVENT_TITLE = $_POST['title'];
	$flag_name = $_POST['flagvalue'];;
    $EVENT_IMG = $target . $path_name;
//echo "image name:-".$EVENT_IMG;
    $EVENT_VENUE = $_POST['venue'];
    $EVENT_CONTENT = $_POST['event_content'];
    $EVENT_DATE = $_POST['event_date'];
    $EVENT_TIME = $_POST['event_time'];
    $EVENT_FULL_TIME = $EVENT_DATE . " " . $EVENT_TIME;
    $REGISTRATION = $_POST['reg'];
	$COST = $_POST['cost'];
    $DATE = $event_date;
    $FLAG = $flag_value;
    $User_Type = $_POST['user3'];

    if ($User_Type == 'Selected') {
        $user1 = $_POST['selected_user'];
        $user2 = rtrim($user1, ',');
        $myArray = explode(',', $user2);
        /*  echo "selected group"."<br/>";
          echo "<pre>";
          print_r($myArray)."<br/>";
          echo "</pre>"; */
    } else {
        // echo "allgroup group"."<br/>";
        $User_Type = "Selected";
        $user1 = $_POST['all_user'];
        $user2 = rtrim($user1, ',');
        $myArray = explode(',', $user2);
        /*   echo "allgroup group"."<br/>";
          echo "<pre>";
          print_r($myArray)."<br/>";
          echo "</pre>"; */
    }

	if($popup_NOTIFICATION == 'POPUP_YES')
		{
			$res = $push->createpopup($EVENT_ID,$clientid,$EVENT_IMG,$FLAG,$DATE,$USERID);
			//print_r($res);
		}

    /** ********************* insert into database ************************************************ */
//createNewEvent($clientid,$eventid,$title,$imgname,$venue,$eventdate,$desc,$regis);
    $result = $obj->createNewEvent($clientid, $EVENT_ID, $EVENT_TITLE, $EVENT_IMG, $EVENT_VENUE, $EVENT_FULL_TIME, $EVENT_CONTENT, $REGISTRATION, $DATE, $USERID, $FLAG,$COST);

    $type = "Event";
    $img = "";
    $result1 = $welcome_obj->createWelcomeData($clientid, $EVENT_ID, $type, $EVENT_TITLE, $EVENT_IMG, $DATE, $USERID, $FLAG);

    $groupcount = count($myArray);
    for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
        $result1 = $read->eventSentToGroup($clientid, $EVENT_ID, $myArray[$k],$FLAG);
//echo $result1;
    }

// echo $result;

 /** ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push->getKeysPem($clientid);
        /*         * ************************************************************************************ */

    /*     * ****************  fetch all user employee id from user detail start **************************** */
    $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
    $token = json_decode($gcm_value, true);
    /* echo "hello user  id";
      echo "<pre>";
      print_r($token);
      echo "</pre>"; */


    /*     * *************************get group admin uuid  form group admin table if user type not= all *************************** */
    if ($User_Type != 'All') {
        $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);


        $adminuuid = json_decode($groupadminuuid, true);
        /* echo "hello groupm admin id";
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
        /* echo "<pre>";
          print_r($allempid1);
          echo "<pre>"; */
    } else {
        $allempid1 = $token;
    }

    /*     * ******* insert into post sent to table for analytic sstart************ */

    $total = count($allempid1);
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->eventSentTo($clientid, $maxeventid, $uuid);
        } else {
            continue;
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
//echo "Push notification :".$PUSH_NOTIFICATION."<br/>";
    /*     * *******************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') {

        /*         * ******************* send push by  push notification******************** */

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

               $content = str_replace("\r\n","",strip_tags($EVENT_CONTENT));
        $data = array('Id' => $maxeventid, 'Title' => $EVENT_TITLE, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG,'flagValue' => $flag_name, 'success' => $sf);
          
		   $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapi);
        $rt = json_decode($revert, true);

        if ($rt) {
            if ($dev == 'd1') {
                echo "<script>alert('Event Successfully Send');</script>";
                echo $rt;
            } else {
                echo "<script>alert('Event Successfully Send');</script>";
                //print_r($rt);
                echo "<script>window.location='../create_event.php'</script>";
            }
        }
    } else {
        echo "<script>alert('Event Successfully Send');</script>";
        echo "<script>window.location='../create_event.php'</script>";
    }


    /*     * **************************if condition 2 end**************************************************************** */
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="device" value="d1">
        <br/>

        <p>client id:
            <label for="textfield"></label>
            <input type="text" name="clientid" id="textfield">
        </p>
        <p>title
            <label for="textfield"></label>
            <input type="text" name="title" id="textfield">
        </p>
        <p>Event image:
            <label for="textfield"></label>
            <input type="file" name="eventimage" id="textfield">
        </p>
        <p>venue:
            <label for="textfield"></label>
            <input type="text" name="venue" id="textfield">
        </p>
        <p>event content:
            <label for="textfield"></label>
            <textarea name="content" id="textfield"></textarea>
        </p>
        <p> Author(Valid system generated  UU Id)<p>
            <label for="textfield"></label>
            <input type="text" name="author" id="textfield">
        <p>
        <p>register<p>
            <label for="textfield"></label>
            <select name="register">
                <option selected>--select registration option--</option>
                <option value='yes'>yes</option>
                <option value='no'>no</option>
            </select>
        <p>

            <input type="hidden" name="user3" id="textfield" value="All">

            <input type="submit" name="news_post" id="button" value="Submit">
        </p>
    </form>

    <?php
}
?>