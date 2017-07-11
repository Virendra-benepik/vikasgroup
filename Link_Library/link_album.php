<?php
session_start();
include_once('../Class_Library/class_upload_album.php');
require_once('../Class_Library/class_push_notification.php');
include_once('../Class_Library/class_get_group.php');  // for getting all group
require_once('../Class_Library/class_welcomeTable.php');

if (!empty($_POST)) {
    $uploader = new Album();
    $obj_group = new Group();                  //class_get_group.php
    $push = new PushNotification();            // class_push_notification.php
    $welcome_obj = new WelcomePage();

    $albumid = $uploader->maxId();
	$User_Type = $_POST['user3'];
	
    $title = $_POST['title'];
    $clientid = $_POST['clientid'];
    $uuid = $_POST['useruniqueid'];
	
	/**************************** fetch group ********************************/
	
	if($User_Type == 'Selected')
		{
			$user1 = $_POST['selected_user'];
			$user2 = rtrim($user1,',');
			$myArray = explode(',', $user2);
		//	echo "selected";
		//	print_r($myArray);
		 }
		 
		  else
		 {
			 
			 $User_Type = "Selected";
			 $user1 = $_POST['all_user'];
			 $user2 = rtrim($user1,',');
			 $myArray = explode(',', $user2);
		//	 echo "all";
		//	 print_r($myArray);
			
		 } 
		 
	
	/************************* end fetch group ***********************************/
//    if ($User_Type == 'Selected') {
//        $user1 = $_POST['selected_user'];
//        $user2 = rtrim($user1, ',');
//        $myArray = explode(',', $user2);
//        /* echo "<pre>";
//          print_r($myArray)."<br/>";
//          echo "</pre>"; */
//    } else {
//        //$myArray[] = $User_Type; 
//        // echo "all user"."<br/>";
//        $User_Type = "Selected";
//        //echo "user type:-".$User_Type;
//        $user1 = $_POST['all_user'];
//        $user2 = rtrim($user1, ',');
//        $myArray = explode(',', $user2);
//        /*   echo "<pre>";
//          print_r($myArray)."<br/>";
//          echo "</pre>"; */
//    }
    //echo "title : ".$title."<br>";
    //echo "clientid : ".$clientid."<br>";
    // echo " description :".$desc."<br>";
    // echo "uuid-".$uuid;
    $createdby = $uuid;
    $date = date("Y-m-d H:i:s");
    $googleapi = $_SESSION['gpk'];
    $FLAG = 11;

  
  $insertdata = $uploader->createAlbum($clientid, $albumid, $title, $createdby, $date);

    $target_dir = "../upload_album/";
    $target_db = "upload_album/";
    $uploadOk = 1;

//    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $k = $_FILES['album']['name'];
    $k1 = $_FILES['album'];

    $type = 'Album';
    $img = "";
    $result1 = $welcome_obj->createWelcomeData($clientid, $albumid, $type, $title, $img, $date, $createdby, $FLAG);

    $countfiles = count($k);
    for ($i = 0; $i < $countfiles; $i++) 
    {     
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
        /* if($imgupload == 'True')
          {
          echo "<script>alert('Image Successfully Uploaded');</script>";
          echo "<script>window.location='../multipleImageUpload.php'</script>";
          } */
    }


    /*     * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
    $googleapiIOSPem = $push->getKeysPem($clientid);
    /*     * ************************************************************************************ */


    $PUSH_NOTIFICATION = "PUSH_YES";
	$push_noti =  $_POST['push'];
	if(!isset($push_noti) || $push_noti != 'PUSH_YES')
	{
	$PUSH_NOTIFICATION = 'PUSH_NO';
	}
	else
	{
	$PUSH_NOTIFICATION = 'PUSH_YES';
	}
    /*     * ***************************************************************send push notification **************************************************************** */
    /*     * ************************* find group **************************** */
    /*$result = $obj_group->getGroup($clientid);
    $value = json_decode($result, true);
    $getcat = $value['posts'];

    $wholegroup = array();
    foreach ($getcat as $groupid) {
        array_push($wholegroup, $groupid['groupId']);
    }
*/
	
	
	 $groupcount = count($myArray);
     for ($k = 0; $k < $groupcount; $k++) 
	 {

//    $groupcount = count($myArray);
    //$groupcount = count($wholegroup);
    //for ($j = 0; $j < $groupcount; $j++) {
//echo "group id".$myArray[$k];
        $result2 = $uploader->albumSentToGroup($clientid, $albumid, $myArray[$k]);
//echo $result1;
    }

    /*     * ******************************************************************** */

    /*     * *************************find employee id ********************* */
    //$usertype = "All";
    $emloyeeid = $push->get_Employee_details($User_Type, $myArray, $clientid);   //case of Selected $ur have some group
    //$rty1 = json_decode($emloyeeid, true);
    /* echo "<pre>";
      echo "all employee id";
      print_r($rty1);
      echo "</pre>";
     */
	 
	$token = json_decode($emloyeeid, true);
	/*echo "<pre>";
          print_r($token);
          echo "</pre>";*/
	
	
	
	/******************** get group admin uuid form group admin table if user type not equal all ********************/
        
		if($User_Type != 'All')
		{
		//$groupadminuuid = $push->getGroupAdminUUId($myArray,$clientid);
		//$adminuuid = json_decode($groupadminuuid, true);
		/*echo "user unique id";
		echo "<pre>";
		print_r($adminuuid);
		echo "</pre>";*/
		
		/******************************************all employee id**************************************************/
		//$allempid = array_merge($token,$adminuuid);
                $allempid = array_merge($token);
	/*	echo "array merge";
		echo "<pre>";
		print_r($allempid);
		echo "</pre>";*/
		/******************************************all unique employee id*******************************************/
		$allempid1 = array_values(array_unique($allempid));
		/*echo "all unique employee id";
		echo "<pre>";
		print_r($allempid1);
		echo "</pre>";*/
		}
		else
		{
		$allempid1 = $token;
		/*echo "all user unique id";
		echo "<pre>";
		print_r($allempid1);
		echo "</pre>";	*/
		}		
		//print_r($allempid1);
	/****************** end get group admin uuid form group admin table if user type not equal all *****************/
	
	$reg_token = $push->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);

     /*echo "<pre>";
      echo "all employee id reg token";
      print_r($token1);
      echo "</pre>";*/
    
    /*     * ************************************************ */

    /*     * *******************Create file of user which this post send  start******************** */
    $val[] = array();
    foreach ($token1 as $row) {
        array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
    }

    $file = fopen("../send_push_datafile/" . $albumid . ".csv", "w");

    foreach ($val as $line) {
        fputcsv($file, explode(',', $line));
    }
    fclose($file);

    /*     * *******************Create file of user which this post send End******************** */


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


        $flag_name = "Album : ";
		$like_val = "yes";
        $comment_val = "yes";
        $usersname = "";
        $image = "";
		
        $data = array('Id' => $albumid, 'Title' => $title, 'Content' => $title, 'SendBy' => $usersname, 'Picture' => $hrimg, 'image' => $image, 'Date' => $date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);

		//print_r($data);
		
        $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
        $rt = json_decode($revert, true);
		
		//print_r($IOSrevert);
		//print_r($rt);
		
		
//echo $revert;
        if ($rt["success"] == 1) {
            echo "<script>alert('Image Successfully Uploaded');</script>";
            echo "<script>window.location='../multipleImageUpload.php'</script>";
        }
    } else {
        echo "<script>alert('Image Successfully Uploaded');</script>";
        echo "<script>window.location='../multipleImageUpload.php'</script>";
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
