<?php
//error_reporting(E_ALL);
//ini_set('display error', 1);
session_start();
include_once('../Class_Library/class_upload_album.php');
require_once('../Class_Library/class_push_notification.php');
include_once('../Class_Library/class_get_group.php');  // for getting all group
require_once('../Class_Library/class_reading.php');

if (!empty($_POST)) {
    $uploader = new Album();
    $obj_group = new Group();                  //class_get_group.php
    $push = new PushNotification();            // class_push_notification.php
    $read = new Reading();
      
    $albumid = $_POST['albumeid'];
    $title = $_POST['title'];
    $clientid = $_POST['clientid'];
    $uuid = $_POST['useruniqueid'];
    $BY = $_SESSION['user_name'];
    $createdby = $uuid;
    $date = date("Y-m-d H:i:s");
    $googleapi = $_SESSION['gpk'];
    $FLAG = 11;

    $target_dir = "../upload_album/";
    $target_db = "upload_album/";
    $uploadOk = 1;
	$User_Type = 'Selected';
    $k = $_FILES['album']['name'];
    $k1 = $_FILES['album'];

    $type = 'Album';
    $img = "";
    $countfiles = count($k);
    for ($i = 0; $i < $countfiles; $i++) {

        $albumThumbImg = $albumid . "-" . basename($_FILES["album"]["name"][$i]);
        $target_file1 = $target_db . $albumid . "-" . basename($_FILES["album"]["name"][$i]);
        $target_file = $target_dir . $albumid . "-" . basename($_FILES["album"]["name"][$i]);
        $caption = "";
        $imageCaption = $_POST['imageCaption'][$i];
        $temppath = $_FILES["album"]["tmp_name"][$i];

        $res = $uploader->compress_image($temppath, $target_file, 20);
	   
        //$thumb_image = $push->makeThumbnails($target_dir, $albumThumbImg, 20);
        //$thumb_img = str_replace('../', '', $thumb_image);
        $thumb_img = '';
		
        $imgupload = $uploader->saveImage($albumid, $target_file1, $title, $thumb_img, $imageCaption);
        
    }

    $userimage = $push->getImage($uuid);
   $imageuser = $userimage[0]['userImage'];

    /******************** Get GoogleAPIKey and IOSPEM file *****************************/
    $googleapiIOSPem = $push->getKeysPem($clientid);
	//print_r($googleapiIOSPem);
    /***************************************************************************/

	/********************** push *****************************/
   // $PUSH_NOTIFICATION = "PUSH_YES";
   // $push_noti = $_POST['push'];
    if (!isset($_POST['push']) || $_POST['push'] != 'PUSH_YES') {
        $PUSH_NOTIFICATION = 'PUSH_NO';
    } else {
        $PUSH_NOTIFICATION = 'PUSH_YES';
    }
    //echo $PUSH_NOTIFICATION;
   /************************************************************/
   
    /*************************send push notification ***************/
    /************************** find group **************************** */
     $result = $obj_group->getPostedGroupDetails($clientid,$albumid,$FLAG);
      $value = json_decode($result, true);
      $wholegroup = array();
      foreach ($value as $groupid) {
      array_push($wholegroup, $groupid['groupId']);
      }
	  
    /*echo "<pre>";
    print_r($wholegroup);*/
	 
	$groupcount = count($wholegroup);
    $general_group = array();
    $custom_group = array();
	
    for ($k = 0; $k < $groupcount; $k++) {

        /***********************  custom group ******************** */
        $groupdetails = $read->getGroupDetails($clientid, $wholegroup[$k]);  //get all groupdetails

        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $wholegroup[$k]);
        } else {
            array_push($general_group, $wholegroup[$k]);
        }
    }
	
	/*echo "custom";
	print_r($custom_group);
	echo "general";
	print_r($general_group);*/
	  
    /**********************************************************************/

    /**************************find employee id ********************* */
    if (count($general_group) > 0) {

        $gcm_value = $push->get_Employee_details($User_Type, $general_group, $clientid);
        $generaluserid = json_decode($gcm_value, true);
    } else {
        $generaluserid = array();
    }
	
	/*echo "<pre>";
	echo "general id";
	print_r($generaluserid);*/
	
    if (count($custom_group) > 0) {
        $gcm_value1 = $obj_group->getCustomGroupUser($clientid, $custom_group);
        $customuserid = json_decode($gcm_value1, true);
    } else {
        $customuserid = array();
    }
		/*echo "<pre>";
		echo "custom id";
		print_r($customuserid);*/
    /******************* get group admin uuid form group admin table if user type not equal all ******************* */
    if ($User_Type != 'All') {
       
        $allempid = array_merge($generaluserid, $customuserid);
		
        /****************** all unique employee id *********************** */
        $allempid1 = array_values(array_unique($allempid));
       
    } else {
        $allempid1 = $generaluserid;
//         echo "all user unique id";
//          echo "<pre>";
//          print_r($allempid1);
//          echo "</pre>"; 
    }
	
	/*echo "<pre>";
	echo "all emp id";
	print_r($allempid1);*/
	
    /*     * **************** end get group admin uuid form group admin table if user type not equal all **************** */

    $reg_token = $push->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);

      /*echo "<pre>";
      echo "all employee id reg token";
      print_r($token1);
      echo "</pre>";*/
	 

    /********Create file of user which this post send  start******************** */
//    $val[] = array();
//    foreach ($token1 as $row) {
//        array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
//    }
//
//    $file = fopen("../send_push_datafile/" . $albumid . ".csv", "w");
//
//    foreach ($val as $line) {
//        fputcsv($file, explode(',', $line));
//    }
//    fclose($file);

    /*     * *******************Create file of user which this post send End******************** */


    /*     * *******************check push notificaticon enabale or disable******************** */
   
   if ($PUSH_NOTIFICATION == 'PUSH_YES') {

        /********************* send push by  push notification******************** */

        //$hrimg = SITE_URL . $_SESSION['image_name'];
        $hrimg = SITE_URL . $imageuser;
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


        $flag_name = "Album : ";
        $like_val = "yes";
        $comment_val = "yes";
        $usersname = "";
        $image = "";

        $data = array('Id' => $albumid, 'Title' => $title, 'Content' => $title, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $image, 'Date' => $date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
		
		/*echo "<pre>";
        print_r($data);
*/
        $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
        $rt = json_decode($revert, true);
//echo $revert;
	/*echo "<pre>";
	print_r($IOSrevert);
	print_r($rt);*/

        if ($rt["success"] == 1) {
            echo "<script>alert('Image Successfully Uploaded');</script>";
            echo "<script>window.location='../full_view_album.php?albumid=".$albumid."'</script>";
        }
		
        else {
            echo "<script>alert('Image Successfully Uploaded');</script>";
            echo "<script>window.location='../full_view_album.php?albumid=".$albumid."'</script>";
        }
    } else {
        echo "<script>alert('Image Successfully Uploaded');</script>";
        echo "<script>window.location='../full_view_album.php?albumid=".$albumid."'</script>";
    }
} else {
    ?>
    <form action="link_album.php" method="post" enctype="multipart/form-data">
        clientid:<input type="text" name="clientid"><br>
        title :  <input type="text" name="title"><br>
        upload multiple image :   <input type="file" name="album[]" id="filer_input2" multiple><br>
        description : <textarea name="desc"></textarea><br>
        <input type="submit" value="Submit">
    </form>
    <?php
}
?>
