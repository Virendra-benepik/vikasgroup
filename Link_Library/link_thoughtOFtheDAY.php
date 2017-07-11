<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_welcomeTable.php');
require_once('../Class_Library/class_thought.php');
require_once('../Class_Library/class_push_notification.php');
include_once('../Class_Library/class_get_group.php');

$obj_group = new Group();
$thought_obj = new ThoughtOfDay();
$thought_maxid = $thought_obj->thoughtMaxId();
//echo "maximunm id -: ".$thought_maxid."<br/>";
$read = new Reading();
$push_obj = new PushNotification();     
$welcome_obj = new WelcomePage();

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');

$folder = '../images/ThoughtsOFtheDAY/';   // folder name for storing data
$target = 'images/ThoughtsOFtheDAY/';      //folder name for add with image insert into table

if(!empty($_POST))
{

/******************* check poll image and poll question exist or not **************************/
$FLAG = $_POST['flag'];
$dev = $_POST['device'];
$flag_name = "Thought : ";
$googleapi = $_POST['googleapi'];
if($_FILES['thoughtimage']['name'] != "")
{
$timg = $_FILES['thoughtimage']['name'];
$timgtemp = $_FILES['thoughtimage']['tmp_name'];
$image_name = $thought_maxid."-".$timg;

//echo "image name = :-".$image_name;
$imagepath = $folder.$image_name;
$dbimage = $target.$image_name;
$url = $thought_obj->compress_image($timgtemp, $imagepath, 30);
$fullpath = SITE_URL ."images/ThoughtsOFtheDAY/".$image_name;
}
else
{
$fullpath = "";
$dbimage = "";
}
//echo "image url-: ".$url."<br/>";

if($_POST['content'])
{
$thoughttext = $_POST['content'];
}
else
{
$thoughttext = "";
}


$USEREMAIL = $_POST['useruniqueid'];
//echo "$user email : ".$USEREMAIL."<br/>";
$clientid =  $_SESSION['client_id'];


/*$ptime1 = $_POST['publish_date1']." ".$_POST['publish_time1'];
$utime1 = $_POST['publish_date2']." ".$_POST['publish_time2'];

$timestamp = strtotime($ptime1);
$ptime = date("Y-m-d H:i:s", $timestamp);

if($utime1 == "")
{
$timestamp1 = strtotime($utime1);
$utime = date('Y-m-d H:i:s', strtotime("+1 month", $timestamp1));
}
else
{
$timestamp1 = strtotime($utime1);
$utime = date("Y-m-d H:i:s", $timestamp1);
}
*/
$ptime = ""; 
$utime = "";

//$User_Type = "All";
$User_Type = "Selected";
/****************************************************************/
/*if ($User_Type == 'Selected') {
            $user1 = $_POST['selected_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
           
        } else {
            // echo "all user"."<br/>";
            $User_Type = "Selected";
            //  echo "user type:-".$User_Type;
            $user1 = $_POST['all_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
           
        }
*/

/****************************************************************/
/******************************** fetch group *************************/
/*************************** find group **************************** */
    $result = $obj_group->getGroup($clientid);
    $value = json_decode($result, true);
    $getcat = $value['posts'];

    $myArray = array();
    foreach ($getcat as $groupid) 
        {
        array_push($myArray, $groupid['groupId']);
    }
	//echo "<pre>";
	//print_r($myArray);
	
/********************** end fetch group *******************************/
    
    if(isset($_POST['push']) && $_POST['push'] == 'PUSH_YES') 
    {   
        $PUSH_NOTIFICATION = 'PUSH_YES';
        }
        else
        {
       $PUSH_NOTIFICATION = 'PUSH_No';
        }
    
   //echo $PUSH_NOTIFICATION;
   
/************************* get key pem *****************************/
   $googleapiIOSPem = $push_obj->getKeysPem($clientid);
       //print_r($googleapiIOSPem);   
/************************* end get key pem *************************/   
   

/*********************** insert into database *************************************************/
 //  echo "thought maxid : ".$thought_maxid."<br/>";
$thoughtresult = $thought_obj->createThought($clientid,$thought_maxid,$thoughttext,$dbimage,$FLAG,$USEREMAIL,$ptime,$utime,$post_date);
if($thoughtresult == 'True')
{
//echo "data send";
}
 $type = 'Thought';
   $img = "";
$result1 = $welcome_obj->createWelcomeData($clientid,$thought_maxid,$type,$thoughttext,$dbimage,$post_date,$USEREMAIL,$FLAG);

$groupcount = count($myArray);
$general_group = array();
$custom_group = array();
for($k=0;$k<$groupcount;$k++)
{
//echo "group id".$myArray[$k];
$result1 = $read->thoughtSentToGroup($clientid,$thought_maxid,$myArray[$k],$FLAG);
//echo $result1;

/*********************** get group detail ****************/

$groupdetails = $read->getGroupDetails($clientid, $myArray[$k]);  //get all groupdetails
        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $myArray[$k]);
        } else {
            array_push($general_group, $myArray[$k]);
        }

/********************** / get group detail ***************/

}

/*echo "general";
print_r($general_group);
echo "custom";
print_r($custom_group);*/

/******************  fetch all user employee id from user detail start *****************************/

if (count($general_group) > 0) 
	{
        $gcm_value = $push_obj->get_Employee_details($User_Type, $general_group, $clientid);
        $generaluserid = json_decode($gcm_value, true);
    }
else
	{   
               $generaluserid = array();
    }
if (count($custom_group) > 0) 
	{
        $gcm_value1 = $obj_group->getCustomGroupUser($clientid, $custom_group);
        $customuserid = json_decode($gcm_value1, true);
    }
else
	{
              $customuserid = array();
    }
	
/*echo "general";
print_r($generaluserid);
echo "custom";
print_r($customuserid);*/

//$gcm_value = $push_obj->get_Employee_details($User_Type,$myArray,$clientid);
//$token = json_decode($gcm_value, true);
/*echo "hello user  id";
echo "<pre>";
print_r($token);
echo "</pre>";*/


/***************************get group admin uuid  form group admin table if user type not= all ****************************/


if($User_Type != 'All')
{
	
	$allempid = array_merge($generaluserid, $customuserid);
	$allempid1 = array_values(array_unique($allempid));
//$groupadminuuid = $push_obj->getGroupAdminUUId($myArray,$clientid);


//$adminuuid = json_decode($groupadminuuid, true);
/*echo "hello groupm admin id";
echo "<pre>";
print_r($adminuuid)."<br/>";
echo "</pre>";*/
/******** "--------------all employee id---------"***/

//$allempid = array_merge($token,$adminuuid);
//$allempid = array_merge($token);
/*echo "<pre>";
print_r($allempid);
echo "<pre>";*/

/**** "--------------all unique employee id---------"***********/

//$allempid1 = array_unique($allempid);
/*echo "<pre>";
print_r($allempid1);
echo "<pre>";*/

}
else
{
$allempid1 = $generaluserid;
//$allempid1 = $token;
}

//print_r($allempid1);
//print_r($allempid);

/********* insert into post sent to table for analytic sstart*************/

$total = count($allempid1);
for($i=0; $i<$total; $i++)
{
	$uuid = $allempid1[$i];
	//echo "post sent to :--".$uuid."<br/>";
	if (!empty($uuid)) {
	$read->thoughtSentTo($clientid,$thought_maxid,$uuid);
	}else 
	{
	   continue;
	}
}
/********* insert into post sent to table for analytic sstart*************/

/***** get all registration token  for sending push *****************/
$reg_token = $push_obj->getGCMDetails($allempid1,$clientid);
$token1 = json_decode($reg_token, true);
/*echo "----regtoken------";
echo "<pre>";
print_r($token1);
echo "<pre>";*/

 /*********************Create file of user which this post send  start******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = fopen("../send_push_datafile/" . $thought_maxid . ".csv", "w");

        foreach ($val as $line) {
            @fputcsv($file, @explode(',', $line));
        }
        @fclose($file);

        /********************Create file of user which this post send End*********************/


/*********************check push notificaticon enabale or disable*********************/

if($PUSH_NOTIFICATION == 'PUSH_YES')
{

/********************* send push by  push notification*********************/

$hrimg = ($_SESSION['image_name']=='')?'':SITE_URL . $_SESSION['image_name'];

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
			
			/*$data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);*/
            
            /*$data = array('Id' => $thought_maxid,'Content' => $thoughttext, 'SendBy'=> $USEREMAIL, 'Picture'=> $hrimg, 'image' => $fullpath, 
'Publishing_time'=>$ptime,'Unpublishing_time'=>$utime, 'flag'=>$FLAG,'flagValue'=>$flag_name,'success'=>$sf);*/

$data = array('Id' => $thought_maxid,'Title' => $thoughttext,'Content' => $thoughttext, 'SendBy'=> $USEREMAIL, 'Picture'=> $hrimg, 'image' => $fullpath,'Date' => $post_date, 
'Publishing_time'=>$ptime,'Unpublishing_time'=>$utime, 'flag'=>$FLAG,'flagValue'=>$flag_name,'success'=>$sf);

			//print_r($data);
			
           $IOSrevert = $push_obj->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
            $revert = $push_obj->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

            $rt = json_decode($revert, true);
            $iosrt = json_decode($IOSrevert, true);

//		echo "<pre>";
		//print_r($iosrt);
		//print_r($rt);

 if($rt['success'] == 1)
 {
echo "<script>alert('Thought Posted Successfully');</script>";
echo "<script>window.location='../todays_thought.php'</script>";
//echo $rt;
}
else
{
 echo "<script>alert('Thought Posted Successfully');</script>";
echo "<script>window.location='../todays_thought.php'</script>";
//print_r($rt);
}

 
 }
 else
 {
 echo "<script>alert('Thought Post Successfully');</script>";
 echo "<script>window.location='../todays_thought.php'</script>";
 }

/****************************if condition 2 end*****************************************************************/
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
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
    <option value='5'>5</option>
   
    </select>
 
  </p>
  
   <p>thought image:
    <label for="textfield"></label>
  <input type="file" name="thoughtimage" id="textfield">
  </p>
 
   <p>thought content:
    <label for="textfield"></label>
    <textarea name="content" id="textfield"></textarea>
 </p>
<p> Author(Valid Email Id)<p>
    <label for="textfield"></label>
  <input type="Email" name="author" id="textfield">
  <p>
  

publish time <input type="date" name="publish_time1" id"publish_time1"><br>
unpublish time <input type="date" name="publish_time2" id"publish_time2">

  <p> Author name<p>
    <label for="textfield"></label>
  <input type="text" name="auth" id="textfield">
  <p>
 this thought send to all:
   <input type="hidden" name="user3" id="textfield" value="All">
  	
    <input type="submit" name="news_post" id="button" value="Submit">
  </p>
</form>
</body>
</html>
<?php
}
?>