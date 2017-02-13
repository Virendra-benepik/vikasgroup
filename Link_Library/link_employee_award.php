<!--
Created By :- Monika Gupta
Created Date :- 26/10/2016
Description :- link files contain all fields from HTML file and create object of class files . call functions help of object and pass parameter into function for creating new client . 
-->
<?php
@session_start();
require_once('../class_library/class_award.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_push_notification.php');

$object = new award();									// object of class award page
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();									// object of class reading page

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
		 $flag_value = $_POST['flag'];
		 $flag_name = $_POST['flagvalue'];
		 $dev = $_POST['device'];
		 $clientid = $_POST['clientid'];
		
	if(isset($_POST['employeeAddAward']))
	{
		if($_POST['device'] == 'd2')
		{
		$employeeid = $_POST['employee_id'];
		$awardid = $_POST['award_id'];
		$awarddate = $_POST['awarddate'];
		$commentdescription = strip_tags($_POST['comment_description']);
		$uniqueuserid = $_POST['uniqueuserid'];
		$googleapi = $_POST['googleapi'];
		 
    	
			$data['employee_id'] = $employeeid;
			$data['award_id'] = $awardid;
			$data['awarddate'] = $awarddate;
			$data['comment_description'] = $commentdescription;
			$data['uniqueuserid'] = $uniqueuserid;
			$data['googleapi'] = $googleapi;
		
		$postdata = json_encode($data);
		//print_r($postdata);
		 }
		 else
		 {
		 $postdata = file_get_contents("php://input");
		 }
		 
		 
		if(!empty($postdata))
		{ 
		
			$User_Type = $_POST['user3'];
			$FLAG = $flag_value;
			$BY =  $_SESSION['user_name'];
			$DATE  =  $awarddate;
			$push_noti =  "PUSH_YES";
			$comment = "COMMENT_YES";
			$like = "LIKE_YES";

				/****************************************** check like , comment and notification start ***********************/
				//$like = $_POST['like'];
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
		 //echo "<pre>";
		 //print_r($request);
		 //echo "</pre>";
		 
		 
	if($User_Type == 'Selected')
	{
	$user1 = $_POST['selected_user'];
	$user2 = rtrim($user1,',');
    $myArray = explode(',', $user2);
	
	 /* echo "selected user"."<br/>";
        echo "<pre>";
        print_r($myArray)."<br/>";
        echo "</pre>";*/
     }
     else
     {
      // echo "all user"."<br/>";
     $User_Type = "Selected";
      //  echo "user type:-".$User_Type;
     $user1 = $_POST['all_user'];
	 $user2 = rtrim($user1,',');
     $myArray = explode(',', $user2);
	 
        /* echo "<pre>";
        print_r($myArray)."<br/>";
        echo "</pre>";*/
     } 
	$result = $object->employeeAward($employeeid,$awardid,$commentdescription,$awarddate,$clientid);
     
	if(isset($result))
	  {
		 echo "<script>alert('".$result['msg']."')</script>";
	     echo "<script>window.location = '../employeeAdd_Awards.php'</script>";
	  }
	 
	 
	    $groupcount = count($myArray);
		for($k=0;$k<$groupcount;$k++)
		{
		//echo "group id".$myArray[$k];
		$result2 = $read->awardSentToGroup($clientid,$awardid,$myArray[$k]);
		//echo $result2;
		}
		
		/******************  fetch all user employee id from user detail start *****************************/
		$gcm_value = $push->get_Employee_details($User_Type,$myArray,$clientid);
		$token = json_decode($gcm_value, true);
		//echo "hello user  id";
		//echo "<pre>";
		//print_r($token);
		//echo "</pre>";
		
		
		
		/***************************get group admin uuid  form group admin table if user type not= all ****************************/
		if($User_Type != 'All')
		{
		$groupadminuuid = $push->getGroupAdminUUId($myArray,$clientid);


		$adminuuid = json_decode($groupadminuuid, true);
		//echo "hello groupm admin id";
		//echo "<pre>";
		//print_r($adminuuid)."<br/>";
		//echo "</pre>";
		/******** "--------------all employee id---------"***/

		$allempid = array_merge($token,$adminuuid);
		//echo "mearg both array"."<br>";
		//echo "<pre>";
		//print_r($allempid);
		//echo "<pre>";
		
		/**** "--------------all unique employee id---------"***********/

		$allempid1 = array_values(array_unique($allempid));


		}
		else
		{
		$allempid1 = $token;
		}
		//echo "<pre>";
		//print_r($allempid1);
		//echo "<pre>";
		
		
		
		/********* insert into post sent to table for analytic sstart*************/

		$total = count($allempid1);
		//echo   "total user:-".$total."<br>";
		for($i=0; $i<$total; $i++)
		{
		$uuid = $allempid1[$i];
		//echo "post sent to :--".$uuid."<br>";
		$result3 = $read->awardSentTo($clientid,$awardid,$uuid);
		//echo $result3;
		}
		
		/********* insert into post sent to table for analytic sstart*************/

		/***** get all registration token  for sending push *****************/
		
		$reg_token = $push->getGCMDetails($allempid1,$clientid);
		$token1 = json_decode($reg_token, true);
		
		//echo "----regtoken------";
		//echo "<pre>";
		//print_r($token1);
		//echo "<pre>";
		

		
		/*********************Create file of user which this post send  start*********************/
		/*
		$val[] = array();
		foreach($token1 as $row)
		{
		 array_push($val,$row["email"].",".$row["registrationToken"]);
		}

		$file = fopen("../send_push_datafile/".$maxid.".csv","w");

		foreach ($val as $line)
		  {
		  fputcsv($file,explode(',',$line));
		  }
		fclose($file);
		*/
		/*********************Create file of user which this post send End*********************/
		
		//$hrimg = "http://admin.benepik.com/employee/virendra/benepik_admin/".$image;
		//echo "this si hr img:=".$hrimg;
		$sf = "successfully send";
		$ids = array();
		foreach($token1 as $row)
		{
		 array_push($ids,$row["registrationToken"]);
		}

		//$path = "http://admin.benepik.com/employee/virendra/benepik_client/".$imgname;
		//echo $path;
		//$data = array('Id' => $maxid, 'Content' => $POST_CONTENT,'SendBy'=> $BY, 'Picture'=> $hrimg, 'image' => $path , 'Date' => $post_date,'flag' =>$FLAG, 'flagValue'=>$flag_name,'success'=>$sf,'comment'=>$comment1,'like'=>$like1);
		$data = array('Id' => $clientid, 'Content' => $commentdescription,'SendBy'=> $BY,'Date' => $DATE,'flag' =>$FLAG, 'flagValue'=>$flag_name,'success'=>$sf,'like'=>$like_val,'comment'=>$comment_val);
		//echo "<pre>";
		//print_r($data);
		$revert = $push->sendGoogleCloudMessage($data,$ids,$googleapi);
		$rt = json_decode($revert,true);

		 if($revert)
		 {

		 //echo "<script>alert('Post Successfully Send');</script>";
		// echo $path;
		//echo "<br>";
		//echo $revert;
		//echo "<pre>";
		//print_r($rt);
		//echo "</pre>";
		
		 }
		 
		 
		}    // !empty(postdata) end
	  
	}
}
else
{
?>
<form action="" method="post">
	Employee Name:<br />
	<select name="employee_id">
							<option selected>-----Select Employee---</option>
							<?php 
							$row = $object->viewemployeedetails();
							$id = json_decode($row, true);
							$count = count($id['Data']);
							for($i=0;$i<$count;$i++)
							{
						   $autoId = $id['Data'][$i]['autoId'];
						   $Name = $id['Data'][$i]['firstName'];
						   echo  "<option value=".$autoId.">".$Name."</option>";
							} 
							?>
	</select>
	<br /><br />
	Award Name:<br />
	<select name="award_id">
							<option selected>-----Select Award---</option>
							<?php 
							$row = $object->viewawards();
							$id = json_decode($row, true);
							$count = count($id['Data']);
							for($i=0;$i<$count;$i++)
							{
						       $award_id = $id['Data'][$i]['awardId'];
						       $award_name = $id['Data'][$i]['awardName'];
						   echo  "<option value=".$award_id.">".$award_name."</option>";
							} 
							?>
	</select>
	<br /><br />
	Select Date:<br />
	<input type="date" name="awarddate">
	<br /><br />
	Comment Description:<br />
	<textarea name="comment_description" placeholder="Comment Description"></textarea>
	<br /><br />
	<input type="submit" value="Submit" /> 
</form>
<?php
}
?>
