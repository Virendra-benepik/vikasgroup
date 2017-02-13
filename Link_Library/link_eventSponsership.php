<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_eventSponsership.php');
require_once('../Class_Library/class_push_notification.php');

$obj = new Sponsership();                                       
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();

$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/contributor/';   // folder name for storing data
$folder = 'images/contributor/';      //folder name for add with image insert into table


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
	 $type = "Contributor";
	 $status = "Publish";

			 if($_POST['device'] == 'd2')
			{
			 $googleapi = $_POST['googleapi'];
			 $useruniqueid= $_POST['useruniqueid'];
			 $title = $_POST['title']; 
			 $description = $_POST['content'];
			 /***************************************** image *************************************/
				$path = $_FILES['uploadimage']['name'];
				$pathtemp = $_FILES['uploadimage']['tmp_name'];
				$path_name = $maxid . "-" . $path;
				$imagepath = $target . $path_name;
				$fullpath = SITE_URL . "images/contributor/" . $path_name;
				$image = $obj->compress_image($pathtemp, $imagepath, 20);
				//echo "this is img path-".$imagepath; 
			 /*************************************************************************************/	 
				$postimage = $folder . $path_name;
			 
					$data['useruniqueid'] = $useruniqueid;
					$data['googleapi'] = $googleapi;
					$data['title'] = $title;
					$data['content'] = $description;
					$data['postimage'] = $postimage;
					
			$postdata = json_encode($data);
			//echo "this is postdata<br>";
			//print_r($postdata);
			}
			else
			{
			$postdata = file_get_contents("php://input",true); 
			}
	 
	 if(!empty($postdata))
	{ 
			 $User_Type = $_POST['user3'];
	
			 $BY = $_SESSION['user_name'];
			 $push_noti =  "PUSH_YES";
			 $comment = "COMMENT_YES";
			 $like = "LIKE_YES";
			
             /**************** check like , comment and notification start ************/
				$like = $_POST['like'];
				if(!isset($like) || $like != 'LIKE_YES')
				{
				$like = 'LIKE_NO';
				$like_val = 'No';
				}
				else
				{
				$like_val = 'Yes';
				}

				$comment =  $_POST['comment'];
				if(!isset($comment) || $comment != 'COMMENT_YES')
				{
				$comment = 'COMMENT_NO';
				$comment_val = 'No';
				}
				else
				{
				$comment_val = 'Yes';
				}


				$push_noti =  $_POST['push'];
				if(!isset($push_noti) || $push_noti != 'PUSH_YES')
				{
				$PUSH_NOTIFICATION = 'PUSH_NO';
				}
				else
				{
				$PUSH_NOTIFICATION = 'PUSH_YES';
				}
				
				$popup_NOTIFICATION = "";
		  if (!isset($_POST['popup'])) 
		{
            $popup_NOTIFICATION = 'POPUP_NO';
        } else {
            $popup_NOTIFICATION = 'POPUP_YES';
        }
    /************************ check like , comment and notification end ***********************/
	/**************************** decode postdata and get group ********************************/
	$request = json_decode($postdata, true);
	//echo "<pre>";
	//print_r($request);
	//echo "</pre>";
	$uuid = $request['useruniqueid'];
	$gapi = $request['googleapi'];
	$eventtitle = $request['title'];
	$eventcontent = $request['content'];
	$eventpostimage = $request['postimage'];
	
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
			 //echo "all";
			 //print_r($myArray);
			
		 } 
		 
		 if($popup_NOTIFICATION == 'POPUP_YES')
		{
			$res = $push->createpopup($maxid,$clientid,$eventpostimage,$flag_value,$createddate,$uuid);
			//print_r($res);
		}
	/*********************************** decode postdata and get group *****************************************/
		
	/**************************************** Get GoogleAPIKey and IOSPEM file **********************************/
	$googleapiIOSPem = $push->getKeysPem($clientid);
	//print_r($googleapiIOSPem);
	/***************************************************************************************/
	
		 
	
	/******************************************** add event sponsership *****************************************/	
	$addeventspon = $obj->addEventSponsership($clientid,$maxid,$eventtitle,$eventpostimage,$eventcontent,$createddate ,$BY,$uuid,$flag_value,$like,$comment,$status);
	$result = json_decode($addeventspon, true);
	//print_r($result);
	/**************************************** end add event sponsership *******************************************/
	
	
	/***************************************** post sent to group ***********************************************/
	 $groupcount = count($myArray);
     for ($k = 0; $k < $groupcount; $k++) 
	 {
	 //echo "group id".$myArray[$k];
     $sendeventtogroup = $read->postSentToGroup($clientid, $maxid, $myArray[$k],$flag_value);
     $result1 = json_decode($sendeventtogroup , true);
	 //print_r($result1);
     }
	/******************************************* end post sent to group *****************************************/
	
	/**************************************** get employee details **********************************************/
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
        $token = json_decode($gcm_value, true);
          /*echo "<pre>";
          print_r($token);
          echo "</pre>";*/
	/**************************************** end get employee details ********************************************/
	
	/******************** get group admin uuid form group admin table if user type not equal all ********************/
		if($User_Type != 'All')
		{
		$groupadminuuid = $push->getGroupAdminUUId($myArray,$clientid);
		$adminuuid = json_decode($groupadminuuid, true);
		/*echo "user unique id";
		echo "<pre>";
		print_r($adminuuid);
		echo "</pre>";*/
		
		/******************************************all employee id**************************************************/
		$allempid = array_merge($token,$adminuuid);
		/*echo "array merge";
		echo "<pre>";
		print_r($allempid);
		echo "</pre>";*/
		/******************************************all unique employee id*******************************************/
		$allempid1 = array_values(array_unique($allempid));
	/*	echo "all unique employee id";
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
		echo "</pre>";*/	
		}		
	/****************** end get group admin uuid form group admin table if user type not equal all *****************/
	
	/************************************** insert into post sent to table ************************************/
       $total = count($allempid1);
        for ($i = 0; $i < $total; $i++) 
		{
            $uuid = $allempid1[$i];
			//echo "count no.:-".$i."->".$uuid."<br/>";
            if (!empty($uuid)) 
			{
				$read->postSentTo($clientid, $maxid, $uuid, $flag_value);
            } else 
			{
                continue;
            }
        }
    /*********************************** end insert into post sent to table **********************************/
	
	/*************************************** insert into welcome table ****************************************/
		$type = 'Contributor';
        $result2 = $obj->createWelcomeData($clientid,$maxid,$type,$eventtitle,$eventpostimage,$createddate,$uuid,$flag_value);
		//echo $result2;
	/*************************************** end insert into welcome table *****************************************/
	
	/********************************* get all registration token for sending push *********************************/
		$reg_token = $push->getGCMDetails($allempid1,$clientid);
		$token1 = json_decode($reg_token, true);
		/*echo "gcm details , registration token";
		echo "<pre>";
		print_r($token1);
		echo "</pre>";*/
	/************************** end get all registration token for sending push *********************************/
	
	/************************************* send push notification ***********************************************/
	/*********************Create file of user which this post send End*********************/
		if ($PUSH_NOTIFICATION == 'PUSH_YES') 
		{
			$hrimg = SITE_URL . $_SESSION['image_name'];
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
					
			}
            $content = str_replace("\r\n","",strip_tags($eventcontent));
			$data = array('Id' => $maxid, 'Title' => $eventtitle, 'Content' => $content,'SendBy'=> $BY,'Date' => $createddate,'flag' => $flag_value, 'flagValue'=>$flag_name,'Picture' => $hrimg, 'image' => $fullpath,'success'=>$sf,'like'=>$like_val,'comment'=>$comment_val);
			
			$IOSrevert = $push->sendAPNSPush($data,$idsIOS,$googleapiIOSPem['iosPemfile']);
			$revert = $push->sendGoogleCloudMessage($data,$ids,$googleapiIOSPem['googleApiKey']);
			$rt = json_decode($revert,true);
				echo $IOSrevert;
				echo $revert;
				print_r($rt);
			if ($rt) 
			{
                if ($dev == 'd1') 
				{
                    echo "<script>alert('Post Successfully Send');</script>";
                } else 
				{
                    echo "<script>alert('Post Successfully Send');</script>";
                  //  echo "<script>window.location='../eventsponsorship.php'</script>";
                }
            }
		}
		else 
		{
            echo "<script>alert('Post Successfully Send');</script>";
          //  echo "<script>window.location='../eventsponsorship.php'</script>";
        }
	/************************************* end send push notification *******************************************/
	
	
	}     // closing bracket !empty(postdata);
}

?>