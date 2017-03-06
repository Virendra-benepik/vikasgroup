<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('../Class_Library/class_notice.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_welcomeTable.php');

$obj1 = new Notice();
$read = new Reading();
$push_obj = new PushNotification(); 
$welcome_obj = new WelcomePage();

if(!empty($_POST))
{ 
    
$title = $_POST['noticetitle'];
$content = $_POST['noticecontent'];
$User_Type = $_POST['user3'];
$client = $_SESSION['client_id'];

	if($User_Type == 'Selected')
	{
	$user1 = $_POST['selected_user'];
	$user2 = rtrim($user1,',');
        $myArray = explode(',', $user2);
        /*echo "<pre>";
          print_r($myArray)."<br/>";
        echo "</pre>";*/
        }
        else
        {
       //$myArray[] = $User_Type; 
        // echo "all user"."<br/>";
        $User_Type = "Selected";
       // echo "user type:-".$User_Type;
        $user1 = $_POST['all_user'];
	$user2 = rtrim($user1,',');
        $myArray = explode(',', $user2);
         /*echo "<pre>";
        print_r($myArray)."<br/>";
        echo "</pre>";*/
        }

 date_default_timezone_set('Asia/Calcutta');
 $post_date = date('Y-m-d H:i:s A');
 
/************************fetch max id *************************************/
$maxid = $obj1->maxID();

$target = '../notice/';
$folder = 'notice/';
//$img_name = $folder.$path_name;
$createdby =  $_POST['uniqueuserid'];
$pagename = $folder.$maxid.".html";
$FLAG = $_POST['flag'];
$flag_name = "Notice : ";
$device = 1; // 1: for panel 2 : Android 3: for ios;

$ptime1 = $_POST['publish_date1']." ".$_POST['publish_time1'];
$utime1 = $_POST['unpublish_date1']." ".$_POST['unpublish_time1'];
if(empty($_POST['publish_date1']) || $_POST['publish_date1'] == "")
{
$ptime1 = $post_date;
}
if(empty($_POST['unpublish_date1']) || $_POST['unpublish_date1'] == "")
{
//$utime1 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($post_date)) . " + 365 day"));
$utime1 = date('Y-m-d', strtotime('+1 year'));
}

//echo "publish time1: - ".$ptime1."<br/>";
//echo "unpublish time1: - ".$utime1."<br/>";


//$gt = $_POST["push"];
//echo "push check:-".$gt."<br/>";

if(file_put_contents($target.$maxid.".html",$content))
{
  //  echo "<script>alert('file created')</script>";
  }
else
{
  //  echo "<script>alert('file not created')</script>";
   } 
 
$push_noti = (empty($_POST['push'])?"":$_POST['push']);
   // if (!isset($push_noti)) {
	if ($push_noti=="") {
        $PUSH_NOTIFICATION = 'PUSH_NO';
    } else {
        $PUSH_NOTIFICATION = 'PUSH_YES';
    }
    
  //echo $PUSH_NOTIFICATION; 
   /** ******************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push_obj->getKeysPem($client);
        /*         * ************************************************************************************ */
   $result = $obj1->addNotice($client,$maxid,$title,$pagename,$createdby,$ptime1,$utime1,$post_date, $FLAG, $device);
   //print_r($result);
   $type = 'Notice';
   $img = "";
$result1 = $welcome_obj->createWelcomeData($client,$maxid,$type,$title,$img,$post_date,$createdby,$FLAG);
//echo $result1;
  // $result1 = $obj1->addNoticeLocation($client,$maxid,$User_Type,$myArray); //add location into database
     $groupcount = count($myArray);
for($k=0;$k<$groupcount;$k++)
{
//echo "group id".$myArray[$k];
$result2 = $read->noticeSentToGroup($client,$maxid,$myArray[$k],$FLAG);
//echo $result1;
}

/******************  fetch all user employee id from user detail start *****************************/
$gcm_value = $push_obj->get_Employee_details($User_Type,$myArray,$client);
$token = json_decode($gcm_value, true);
/*echo "all user  id";
echo "<pre>";
print_r($token);
echo "</pre>";*/

/********************************* to send to admin ******************************/    
if($User_Type != 'All')
{

//echo "user type in selected case: ".$User_Type."<br/>";

$groupadminuuid = $push_obj->getGroupAdminUUId($myArray,$client);
$adminuuid = json_decode($groupadminuuid, true);
/*echo "hello groupm admin id";
echo "<pre>";   
print_r($adminuuid)."<br/>";
echo "</pre>";
echo "--------------all employee id---------";*/

//$allempid = array_merge($token,$adminuuid);
$allempid = array_merge($token);
/*echo "<pre>";
print_r($allempid);
echo "<pre>";

echo "--------------all unique employee id---------";*/

$allempid1 = array_values(array_unique($allempid));
/*echo "<pre>";
print_r($allempid1);
echo "<pre>";*/
}
else
{
//echo "user type in all case : ".$User_Type."<br/>";

$allempid1 = $token;
}


/********* insert into post sent to table for analytic sstart*************/

$total = count($allempid1);
for($i=0; $i<$total; $i++)
{
$uuid = $allempid1[$i];
//echo "post sent to :--".$uuid."<br/>";
$read->noticeSentTo($client,$maxid,$uuid);
}
/********* insert into post sent to table for analytic sstart*************/

/***** get all registration token  for sending push *****************/
$reg_token = $push_obj->getGCMDetails($allempid1,$client);
$token1 = json_decode($reg_token, true);
/*echo "----regtoken------";
echo "<pre>";
print_r($token1);
echo "<pre>";*/


/*********************check push notificaticon enabale or disable*********************/

//echo "push Notification -:".$PUSH_NOTIFICATION;

if($PUSH_NOTIFICATION == 'PUSH_YES')
{

/********************* send push by  push notification*********************/

$hrimg = dirname(SITE_URL).$_SESSION['image_name'];
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


$data = array('Id' =>$maxid,'Title' => $title,'Content' => $title, 'SendBy'=> $createdby, 'Picture'=> $hrimg, 
'Publishing_time'=>$ptime1,'Unpublishing_time'=>$utime1,'Date' => $post_date, 'flag'=>$FLAG,'flagValue'=>$flag_name,'success'=>$sf);

 $IOSrevert = $push_obj->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
  $revert = $push_obj->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
  $rt = json_decode($revert, true);
  $iosrt = json_decode($IOSrevert, true);
  print_r($rt);
	 if($rt['success'] == 1)
		 {
		 echo "<script>alert('Notice Successfully Created');</script>";
		 echo "<script>window.location='../create_notice.php'</script>";
		//print_r($rt);
		 }
	 else
		 {
		  echo "<script>alert('Notice Successfully Created');</script>";
		  echo "<script>window.location='../create_notice.php'</script>";
		 }
 }
else
{
echo "<script>alert('Notice Successfully Created');</script>";
echo "<script>window.location = '../create_notice.php'</script>";
}
}

				
/*********************** insert into database *************************************************/



else
{
?>
<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>

<form name="form1" method="post" action="" enctype="multipart/form-data">
 
  <p> Title:
    <label for="textfield"></label>
  <input type="text" name="noticetitle" id="textfield">
  </p>
  
  
   <p>Notice Content:
    <label for="textfield"></label>
    <textarea cols="80" id="editor1" name="noticecontent" rows="10">	
	</textarea>
  
 
 <p>Author:
    <label for="textfield"></label>
  <input type="text" name="page_author" id="textfield"> 
  </p>
 <p>created date:
    <label for="textfield"></label>
  <input type="date" name="date" id="textfield"> 
  </p>

  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<script>
		CKEDITOR.replace( 'editor1' );
	</script>
<?php
}
?>
