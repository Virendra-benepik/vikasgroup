<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_poll.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_welcomeTable.php');

$poll_obj = new Poll();
$poll_maxid = $poll_obj->pollMaxId();
$read = new Reading();
$push_obj = new PushNotification(); 
$welcome_obj = new WelcomePage();


date_default_timezone_set('Asia/Calcutta');
$post_date = date("Y-m-d H:i:s A");
$ansfolder = "../Poll/poll_ansimg/";
$anstarget = "Poll/poll_ansimg/";

if(!empty($_POST))
{
/******************* check poll image and poll question exist or not **************************/
$FLAG = $_POST['flag'];
//echo "flag value=: ".$FLAG."<br/>";
$dev = $_POST['device'];
$flag_name = "Poll : ";

$USERID = $_POST['useruniqueid'];
$POST_TITLE = "";
$username = $_SESSION['user_name'];
$clientid =  $_SESSION['client_id'];
$googleapi = $_POST['googleapi'];


$ptime1 = $_POST['publish_date1']." ".$_POST['publish_time1'];
$utime1 = $_POST['publish_date2']." ".$_POST['publish_time2'];

//echo "publish time 1 : ".$ptime1."<br/>";
//echo "unpublish time 1 : ".$utime1."<br/>";


$timestamp = strtotime($ptime1);
$ptime = date("Y-m-d H:i:s", $timestamp);

if($_POST['publish_date2'] == "")
{
$timestamp1 = strtotime($utime1);
$utime = date('Y-m-d H:i:s', strtotime("+1 month", $timestamp1));
}
else
{
$timestamp1 = strtotime($utime1);
$utime = date("Y-m-d H:i:s", $timestamp1);
}

//echo "publish Time before format :".$ptime."<br/>";
//echo "unpublish Time before format :".$utime."<br/>";

$ques = $_POST['poll_question'];

$User_Type = $_POST['user3'];


//echo $User_Type;
	if($User_Type == 'Selected')
	{
	$user1 = $_POST['selected_user'];
	$user2 = rtrim($user1,',');
          $myArray = explode(',', $user2);
          $groupdata = json_encode($myArray);
  /*     echo "selected group   id";
echo "<pre>";
print_r($myArray);
echo "</pre>";*/
        }
        else
        {
      // $groupdata = $User_Type;
      $User_Type = "Selected";
       $user1 = $_POST['all_user'];
	$user2 = rtrim($user1,',');
          $myArray = explode(',', $user2);
          $groupdata = json_encode($myArray);
      /*  echo "all group  id";
echo "<pre>";
print_r($myArray);
echo "</pre>";*/
        }
        
       // $PUSH_NOTIFICATION == 'PUSH_YES';
        //$push = "Yes";
        
        $push_noti =  $_POST['push'];
       // echo $push_noti;
if(!isset($push_noti) && $push_noti != 'PUSH_YES')
{
$PUSH_NOTIFICATION = 'PUSH_NO';
$push = "No";
}
else
{
$PUSH_NOTIFICATION = 'PUSH_YES';
$push = "Yes";
}
        
        
    /************************* option  start *******************/    
      
        
        $total_option = $_POST['option'];
        
       // echo "this is total option-:".$total_option."<br/>";
        
        for($t=1; $t<=$total_option;$t++)
        {
        
        $option_maxid = $poll_obj->optionMaxId();      //----------------------maximum  option id
      
         $choice = $_POST['choice'];             //----------------------option choice text or image
        //echo "option choice:-".$choice."<br/>";
        
        if($choice == 'optiontext')
        {
         $textname = "text".$t;
         $optiontext = $_POST[$textname];
         $ansdbimage = "";
         //echo "ans db image : = ".$ansdbimage."<br/>";
         $poll_obj->insertAnswerOptions($clientid,$poll_maxid,$option_maxid,$optiontext,$ansdbimage);
         
        }
        else
        {
        $imagename = "image".$t;
        
        $ansimg = $_FILES[$imagename]['name'];
      //  echo "this is answer imag:- ".$ansimg."<br/>";
        $ansimgtemp = $_FILES[$imagename]['tmp_name'];
        
      $ansimage_name = $option_maxid."-".$ansimg;
      
       //echo "this is answer full name imag:- ".$ansimage_name."<br/>";
      $ansimagepath = $ansfolder.$ansimage_name;
      $ansdbimage = $anstarget.$ansimage_name;
      $poll_obj->compress_image($ansimgtemp, $ansimagepath, 30);
      
      $optiontext = "";
       $poll_obj->insertAnswerOptions($clientid,$poll_maxid,$option_maxid,$optiontext,$ansdbimage);
      
        }
         
        
        }
        
          /************************* option  end *******************/  
    /** ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push_obj->getKeysPem($clientid);
        /*         * ************************************************************************************ */


/*********************** insert into database *************************************************/
   $img  = "Poll/welcome_pollShow.jpg";     
$pollresult = $poll_obj->createPoll($poll_maxid,$clientid,$img,$ques,$groupdata,$USERID,$ptime,$utime,$post_date,$FLAG);

$type = "Poll";

$result1 = $welcome_obj->createWelcomeData($clientid,$poll_maxid,$type,$ques,$img,$post_date,$USERID,$FLAG);

if($pollresult == 'True')
{
//echo "data send";
}
  $groupcount = count($myArray);
for($k=0;$k<$groupcount;$k++)
{
//echo "group id".$myArray[$k];
$result1 = $read->pollSentToGroup($clientid,$poll_maxid,$myArray[$k],$FLAG);
//echo $result1;
}

/******************  fetch all user employee id from user detail start *****************************/
//echo "user type".$User_Type."<br>";
$gcm_value = $push_obj->get_Employee_details($User_Type,$myArray,$clientid);
$token = json_decode($gcm_value, true);
/*echo "hello user  id";
echo "<pre>";
print_r($token);
echo "</pre>";*/


/***************************get group admin uuid  form group admin table if user type not= all ****************************/
if($User_Type != 'All')
{
$groupadminuuid = $push_obj->getGroupAdminUUId($myArray,$clientid);

$adminuuid = json_decode($groupadminuuid, true);
/*echo "hello groupm admin id";
echo "<pre>";
print_r($adminuuid)."<br/>";
echo "</pre>";*/
/******** "--------------all employee id---------"***/

$allempid = array_merge($token,$adminuuid);
/*echo "admin id";
echo "<pre>";
print_r($allempid);
echo "<pre>";*/

/**** "--------------all unique employee id---------"***********/

$allempid1 = array_values(array_unique($allempid));
/*echo "<pre>";
print_r($allempid1);
echo "<pre>";*/

}
else
{
$allempid1 = $token;
}

/********* insert into poll sent to table for analytic sstart*************/

$total = count($allempid1);
for($i=0; $i<$total; $i++)
{
$uuid = $allempid1[$i];
$read->PollSentTo($clientid,$poll_maxid,$uuid);
}
/********* insert into poll sent to table for analytic sstart*************/

/***** get all registration token  for sending push *****************/
$reg_token = $push_obj->getGCMDetails($allempid1,$clientid);
$token1 = json_decode($reg_token, true);
/*echo "----regtoken------";
echo "<pre>";
print_r($token1);
echo "<pre>";*/

/*********************check push notificaticon enabale or disable*********************/
if($PUSH_NOTIFICATION == 'PUSH_YES')
{
$fullpath = '';
$hrimg = SITE_URL.$_SESSION['image_name'];
//echo "hr image:-".$hrimg;
$sf = "successfully send";
$ids = array();
$idsIOS = array();
            foreach ($token1 as $row) {

                if ($row['deviceName'] == 'ios') {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
                //array_push($ids,$row["registrationToken"]);
            }
			
			$content = str_replace("\r\n","",strip_tags($ques));
$data = array('Id' => $poll_maxid, 'Title' => $POST_TITLE, 'Content' => $content,'SendBy'=>$username, 'image' => $fullpath,'Picture'=> $hrimg, 'Date' => $post_date,
'Publishing_time' => $ptime,'Unpublishing_time' => $utime,'flag' =>$FLAG,'flagValue'=>$flag_name,'success'=>$sf);

            $IOSrevert = $push_obj->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
            $revert = $push_obj->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
 $rt = json_decode($revert,true);
// print_r($rt);
 if($rt)
 {
  if($dev == 'd2')
{
echo "<script>alert('Post Successfully Send');</script>";
echo "<script>window.location='../create_poll.php'</script>";
//echo $revert;
}
else
{
echo "<script>alert('Post Successfully Send');</script>";
echo $rt;
}

 }
 }
else
 {
echo "<script>alert('Post Successfully Send');</script>";
echo "<script>window.location='../create_poll.php'</script>";
 }
 

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
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <p>Choose  Image : 
    <label for="fileField"></label>
  <input type="file" name="poll_img" id="fileField" />
  </p>
  <p>Question : 
    <label for="textarea"></label>
    <textarea name="poll_question" id="textarea" cols="45" rows="5"></textarea>
  </p>
  <p>Options..............................................</p>
  <p>1: 
    <label for="fileField2"></label>
  </p>
  <table width="200" border="0">
    <tr>
      <td>Option No.</td>
      <td>Select Image (If Any)</td>
      <td>Answer</td>
    </tr>
    <tr>
      <td>1:</td>
      <td><label for="fileField2"></label>
      <input type="file" name="ansimg1" id="fileField2" /></td>
      <td><label for="textarea2"></label>
      <textarea name="ans1" id="textarea2" cols="25" rows="2"></textarea></td>
    </tr>
    <tr>
      <td>2:</td>
      <td><label for="fileField2"></label>
      <input type="file" name="ansimg2" id="fileField2" /></td>
      <td><label for="textarea2"></label>
      <textarea name="ans2" id="textarea2" cols="25" rows="2"></textarea></td>
    </tr>
    <tr>
      <td>3:</td>
      <td><label for="fileField2"></label>
      <input type="file" name="ansimg3" id="fileField2" /></td>
      <td><label for="textarea2"></label>
      <textarea name="ans3" id="textarea2" cols="25" rows="2"></textarea></td>
    </tr>
    <tr>
      <td>4:</td>
      <td><label for="fileField2"></label>
      <input type="file" name="ansimg4" id="fileField2" /></td>
      <td><label for="textarea2"></label>
      <textarea name="ans4" id="textarea2" cols="25" rows="2"></textarea></td>
    </tr>
  </table> 
  <p>Send To All  : 
    <label for="select"></label>
    <select name="user3" id="select">
    <option selected> ----------select -----------</option>
    <option value="All"> All </option>
    <option value="Selected"> Selected </option>
    </select>
  </p>
  <p>Write group Id IF(Select Selected):
    <label for="textfield"></label>
    <input type="text" name="groupid" id="textfield" />
  </p>
publishing time:<input type="date" name="publish1" /><br>
unpublishing time:<input type="date" name="publish2" />
  <p>
    <input type="submit" name="button" id="button" value="Submit" />
  </p>
  <p>&nbsp; </p>
</form>
</body>
</html>
<?php
}
?>