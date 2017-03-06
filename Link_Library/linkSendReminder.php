<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$surveyid = $_GET['idpost'];
echo $surveyid;
?>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_HappinesQuestion.php');
require_once('../Class_Library/class_push_notification.php');
//include_once('../Class_Library/class_get_group.php');  // for getting all group
require_once('../Class_Library/class_reading.php');
//require_once('../Class_Library/class_welcomeTable.php');

$survey_obj = new HappinessQuestion();
//$obj_group = new Group();           //class_get_group.php

$read = new Reading();
$push_obj = new PushNotification();
//$welcome_obj = new WelcomePage();
date_default_timezone_set('Asia/Calcutta');
$post_date = date("Y-m-d H:i:s A");

if (!empty($_GET['idpost'])) 
    {
    /** ***************** check poll image and poll question exist or not ************************* */
    $FLAG = 20;
  //  $dev = $_POST['device'];
    $flag_name = "Survey : ";
  //  $USERID = $_POST['useruniqueid'];
    $POST_TITLE = "";
    $username = $_SESSION['user_name'];
    $clientid = $_SESSION['client_id'];
    $createdby = $_SESSION['user_unique_id'];
  //    $surveytitle = $_POST['surveytitle'];
  //  $enableComment = $_POST['surveychoice'];
  //  $ptime1 = $_POST['publish_date1'];
 //   $utime1 = $_POST['publish_date2'];
 //    $content = "Request Feedback";
  $surveyId = $_GET['idpost'];
  
	  //echo $PUSH_NOTIFICATION;
    /************************* option  start ****************** */
	
	/******************** find group *****************************
	
	$User_Type = $_POST['user3'];
	if ($User_Type == 'Selected') {
            $user1 = $_POST['selected_user'];
            $user2 = rtrim($user1, ',');

            $myArray = explode(',', $user2);
			
			/*echo "<pre>";
			echo "selected";
			print_r($myArray);
			echo "</pre>";*
			
        } else {
           // echo "all user"."<br/>";
            $User_Type = "Selected";
          //  echo "user type:-".$User_Type;
            $user1 = $_POST['all_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
            /*echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>";*
        }
	
	/*********************** end find group ***********************/
     
    $countsurvey = $survey_obj->getSurveyReminderUser($clientid,$surveyId);
    
    die;
    
    $value1 = json_decode($countsurvey,true);
   
    if($value1["success"] === 1)
            {
                 echo "<script>alert('survey is Available');</script>";
                 echo "<script>window.location='../createHappinessQuestion.php'</script>";
            }
 else {
     $total_option = $_POST['option'];
     $status = 1;
     $value = $survey_obj->createSurvey($clientid, $surveytitle, $total_option, $createdby, $createddate, $expiryDate,$startdate,$status);
    
     $surveyid = $value['lastid'];
     
    for ($t = 1; $t <= $total_option; $t++) 
    {
        $textname = "text" . $t;
        //echo $textname;
        $questiontext = $_POST[$textname];
        // echo "queq :".$t.$optiontext;
        $ansdbimage = "";

$response = $survey_obj->createSurveyques($surveyid,$clientid, $questiontext, $enableComment, $startdate, $expiryDate, $createdby, $createddate);
    }
     
	 
	 
	 /***************** add survey in post sent to group table ********************/
	 $groupcount = count($myArray);
    for ($k = 0; $k < $groupcount; $k++) {
	//echo "group id".$myArray[$k];
        $result1 = $read->postSentToGroup($clientid, $surveyid, $myArray[$k], $FLAG);
//echo $result1;
    }
	/******************** end add survey in post sent to group table ****************/
    /************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
    $googleapiIOSPem = $push_obj->getKeysPem($clientid);
   
    /******************  fetch all user employee id from user detail start **************************** */

    $gcm_value = $push_obj->get_Employee_details($User_Type, $myArray, $clientid);
    $token = json_decode($gcm_value, true);
 
    /*************get group admin uuid  form group admin table if user type not= all ************** */
      
    if ($User_Type != 'All') 
        {
        //$groupadminuuid = $push_obj->getGroupAdminUUId($myArray, $clientid);

       // $adminuuid = json_decode($groupadminuuid, true);
      /*  echo "hello groupm admin id";
          echo "<pre>";
          print_r($adminuuid)."<br/>";
          echo "</pre>"; */
        /******** "--------------all employee id---------"***/

        $allempid = array_merge($token);
       /*echo "admin id";
          echo "<pre>";
          print_r($allempid);
          echo "<pre>";*/
        

        /** ** "--------------all unique employee id---------"********** */

        $allempid1 = array_values(array_unique($allempid));
        /*echo "<pre>";
          print_r($allempid1);
          echo "<pre>";*/
    } 
    else 
        {
        $allempid1 = $token;
    }

	/*echo "<pre>";
          print_r($allempid1);
          echo "<pre>";*/
    /** ******* insert into post sent to table for analytic sstart************ */
 $total = count($allempid1);
   
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
  //echo "post sent to empid:--".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->postSentTo($clientid, $surveyid, $uuid, $FLAG);
        }
    }
    /** ******* insert into post sent to table for analytic sstart************ */

    /** *** get all registration token  for sending push **************** */
    $reg_token = $push_obj->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
    /*echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>";*/

    /*********************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') 
        {
        $fullpath = '';
        $hrimg = SITE_URL . $_SESSION['image_name'];
//echo "hr image:-".$hrimg;
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

       // $content = str_replace("\r\n", "", strip_tags($ques));
        $data = array('Id' => $surveyid, 'Title' => $POST_TITLE, 'Content' => $content, 'SendBy' => $username, 'image' => $fullpath, 'Picture' => $hrimg, 'Date' => $post_date,
            'Publishing_time' => $ptime, 'Unpublishing_time' => $utime, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);

			//print_r($data);
			
        $IOSrevert = $push_obj->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push_obj->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
        $rt = json_decode($revert, true);
		/*echo "<pre>";
		print_r($IOSrevert);
		print_r($rt);*/
        if ($rt['success'] == 1) {
          
               echo "<script>alert('Survey Successfully Created');</script>";
			   echo "<script>window.location='../createHappinessQuestion.php'</script>";
            
        }
		else
		{
			 echo "<script>alert('Survey Successfully Created');</script>";
			 echo "<script>window.location='../createHappinessQuestion.php'</script>";
		}
		
    } 
    else {
        echo "<script>alert('Survey Successfully Created');</script>";
        echo "<script>window.location='../createHappinessQuestion.php'</script>";
       }
    }
} 
else {
    echo "survey id not found";
}
?>