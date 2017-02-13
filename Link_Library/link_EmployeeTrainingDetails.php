<?php
session_start();
require_once('../Class_Library/class_training.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_get_useruniqueid.php');
require_once('../Class_Library/class_training.php');     

$obj = new Training();
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();
$userobj = new UserUniqueId();
$maxid = $obj->maxID();
$learning_obj = new Training();

 $emptrainingid = $maxid;

/********************************START HERE*************************************************/
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
 
/*************************************************************************************************/
if(!empty($_POST))
{ 
	 $clientid = $_POST['clientid'];
	 $flag_value = $_POST['flag'];
	 $flag_name = $_POST['flagvalue'];
	 $dev = $_POST['device'];
	 date_default_timezone_set('Asia/Calcutta');
	 $createddate = date('Y-m-d H:i:s');
	 $type = "Learning";
	 $status = 1;
	
if($_POST['device'] == 'd2')
{
 $googleapi = $_POST['googleapi'];
 $useruniqueid= $_POST['useruniqueid'];
 $trainingid = $_POST['trainingid'];
   
 $employee_id = $_POST['employee_id'];
 $trainingdate = $_POST['trainingdate'];
 $device = $_POST['device'];
 $remark = $_POST['remark'];

			$data['useruniqueid'] = $useruniqueid;
			$data['googleapi'] = $googleapi;
			$data['trainingid'] = $trainingid;
			$data['employee_id'] = $employee_id;
			$data['trainingdate'] = $trainingdate;
			$data['remark'] = $remark;
			$data['device'] = $device;
			
		$postdata = json_encode($data);
		//print_r($postdata);
}
else
{
		 $postdata = file_get_contents("php://input",true); 
}
if(!empty($postdata))
	{ 
			 $User_Type = $_POST['user3'];
			 $FLAG = $flag_value;
			 $BY =  $_SESSION['user_name'];
			 $push_noti =  "PUSH_YES";
			 $comment = "COMMENT_YES";
			 $like = "LIKE_YES";
			
/****************************************** check like , comment and notification start ***********************/
				if(!isset($like) && $like != 'LIKE_YES')
				{
				$like = 'LIKE_NO';
				$like_val = 'No';
				}
				else
				{
				$like_val = 'Yes';
				}

				//$comment =  $_POST['comment'];
				if(!isset($comment) && $comment != 'COMMENT_YES')
				{
				$comment = 'COMMENT_NO';
				$comment_val = 'No';
				}
				else
				{
				$comment_val = 'Yes';
				}


				$push_noti =  $_POST['push'];
				if(!isset($push_noti) && $push_noti != 'PUSH_YES')
				{
				$PUSH_NOTIFICATION = 'PUSH_NO';
				}
				else
				{
				$PUSH_NOTIFICATION = 'PUSH_YES';
				}
				
/****************************************** check like , comment and notification end ***********************/
      $request = json_decode($postdata, true);
		/* echo "<pre>";
		 print_r($request);
		 
		 echo "</pre>";*/
		 /******************************get** user details************************************************/
		 $userimage1 = '';
		 $userdata = $userobj->getUserData($clientid,$employee_id);
		
		 $userdata1 = json_decode($userdata,true);
		//print_r($userdata1);
		 $userimage1 = $userdata1[0]['userImage'];
		// echo "this is user image=".$userimage1;
		$trainingdata1 = $learning_obj->viewemployeelearining($clientid,$trainingid);
		$trainingdata = json_decode($trainingdata1,true);
	//	print_r($trainingdata1);
		$trainingname = $trainingdata['trainingName'];
		
		 /******************************************************************************************/
	if($User_Type == 'Selected')
		{
			$user1 = $_POST['selected_user'];
			$user2 = rtrim($user1,',');
			$myArray = explode(',', $user2);
			//echo "selected";
			//print_r($myArray);
		 }
		 
		  else
		 {
			// echo "all user"."<br/>";
			 $User_Type = "Selected";
			// echo "user type:-".$User_Type;
			 $user1 = $_POST['all_user'];
			 $user2 = rtrim($user1,',');
			 $myArray = explode(',', $user2);
			// print_r($myArray);
			
		 } 
/************************************************* insert into database *********************************************/
				
		/**************************************** insert into Tbl_EmployeeTraining **********************************/	
		$addemployeetraining = $obj->addEmployeeTrainingDetails($clientid,$useruniqueid,$trainingid,$employee_id,$trainingdate,$remark,$createddate,$status);
		$result = json_decode($addemployeetraining, true);

		/**************************************** end insert into Tbl_EmployeeTraining ****************************/
		
		$result1 = $obj->createWelcomeData($clientid,$emptrainingid,$type,$remark,$createddate,$useruniqueid);
		
		/****************************************end  insert into Tbl_C_WelcomeDetails **********************************/
	
/********************************************* Get GoogleAPIKey and IOSPEM file **********************************/
$googleapiIOSPem = $push->getKeysPem($clientid);

/***************************************************************************************/
		/************************************** sent to Tbl_Analytic_LearnSentToGroup ******************************/
		
		$groupcount = count($myArray);
		for($k=0;$k<$groupcount;$k++)
		{
		$result2 = $read->learningSentToGroup($clientid,$emptrainingid,$myArray[$k]);	
		}
		
		/************************************** sent to Tbl_Analytic_AwardSentToGroup ******************************/	
		/******************  fetch all user employee id from user detail start *****************************/
		$gcm_value = $push->get_Employee_details($User_Type,$myArray,$clientid);
		$token = json_decode($gcm_value, true);
		
		/***************************get group admin uuid  form group admin table if user type not= all ****************************/
		if($User_Type != 'All')
		{
		$groupadminuuid = $push->getGroupAdminUUId($myArray,$clientid);
		$adminuuid = json_decode($groupadminuuid, true);
		
		/******************************************all employee id**************************************************/
		$allempid = array_merge($token,$adminuuid);
		
		/******************************************all unique employee id*******************************************/

		$allempid1 = array_values(array_unique($allempid));
		}
		else
		{
		$allempid1 = $token;
		}
		
		/***** get all registration token  for sending push *****************/
		
		$reg_token = $push->getGCMDetails($allempid1,$clientid);
		$token1 = json_decode($reg_token, true);

		/*********************Create file of user which this post send End*********************/
		
		$sf = "successfully send";
		$ids = array();
		$idsIOS = array();
		foreach($token1 as $row)
		{
		       if($row['deviceName'] == 'ios'){
               array_push($idsIOS,$row["registrationToken"]);
			  }
			  else{
				  array_push($ids,$row["registrationToken"]);
			  }
				//
		}

	$data = array('Id' => $emptrainingid, 'Title' => $trainingname, 'Content' => $remark,'SendBy'=> $BY,'Date' => $trainingdate,'flag' =>$FLAG, 'flagValue'=>$flag_name,'Picture'=> $userimage1,'success'=>$sf,'like'=>$like_val,'comment'=>$comment_val);
	
	$IOSrevert = $push->sendAPNSPush($data,$idsIOS,$googleapiIOSPem['iosPemfile']);
	$revert = $push->sendGoogleCloudMessage($data,$ids,$googleapiIOSPem['googleApiKey']);
		$rt = json_decode($revert,true);
		echo $IOSrevert;
		echo $revert;
		 if($revert)
		 {
		 echo "<script>alert('Post Successfully Send');</script>"; 
		echo "<script>window.location='../addEmpLearning.php'</script>";
		 }			
	
	} // !empty($postdata)
}
?>