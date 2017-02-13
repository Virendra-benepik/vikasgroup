<?php
session_start();
require_once('../Class_Library/class_recognize.php');
require_once('../Class_Library/class_push_recognize.php');
 include_once ('../Class_Library/class_get_group.php');
 require_once('../Class_Library/class_reading.php');
 require_once('../Class_Library/class_push_notification.php');

$object = new Recognize();               //object of class_recognize.php
$pushobject = new PushRecognize();        //class_push_recognize.php
$obj_group = new Group();                  //class_get_group.php
$push = new PushNotification();            // class_push_notification.php
$read = new Reading();                    //   class_reading.php 


if(!empty($_POST))
{
$status = $_POST['status'];
//echo $status;
if($status == "Cancel")
{
echo "<script>window.location='../view_recognize.php'</script>";
}
else if($status == "Reject")
{
$rzid = $_POST['rcid'];
//echo "rec ".$rzid;
$cid = $_POST['clientid'];
$topic = $_POST['topic'];
$userid = $_POST['recozto'];
$point = $_POST['point'];

 $res = $object->updaterecognizestatus($rzid,$status,$cid,$topic,$userid,$point);
 
 $resp = json_decode($res,true);
if($resp['success'] == 1)
{
echo "<script>alert('Recognize Rejected')</script>";
 //echo "<script>window.location='../postnews.php'</script>";
echo "<script>window.location='../view_recognize.php'</script>";
}
}
else           /*************************************************************** main task start from here *********************/
{
$rzid = $_POST['rcid'];
$cid = $_POST['clientid'];
$topic = $_POST['topic'];
$userid = $_POST['recozto'];
$point = $_POST['point'];
$title = $_POST['title'];
$type = "Recognization";
$comment = $_POST['comment'];
$recognizeby = $_POST['recozby'];         // recognizr by userid
$recognizebyimage = $_POST['userimg'];
$image = $_POST['toimg'];
$byimage = $_POST['byimg'];
$usersname = $_POST['toname'].":".$_POST['byname'];
//echo "name = ".$usersname;
$er = explode("/",$image);
//print_r($er);
$n = count($er);
$imgname = $er[$n-1];
$user_image = "Client_img/user_img/".$imgname;
$PUSH_NOTIFICATION = "PUSH_YES";
$googleapi = $_SESSION['gpk'];
 date_default_timezone_set('Asia/Calcutta');
     $date = date("Y-m-d H:i:s A");
 $res = $object->updaterecognizestatus($rzid,$status,$cid,$topic,$userid,$recognizeby,$point);
 
 /*************** insert into welcome page *********************************/
 $call = $pushobject->addRecognize($cid,$rzid,$type,$title,$user_image,$userid);
 
 /*************************** find group *****************************/
 $result = $obj_group->getGroup($cid);
 $value = json_decode($result,true);
 $getcat = $value['posts'];
 
 $wholegroup = array();
 foreach($getcat as $groupid)
 {
   array_push($wholegroup,$groupid['groupId']);
 }
 /*echo "<pre>";
 print_r($wholegroup);
 echo "</pre>";
*/
/*********************recognize sent to group class reading ************************************/
 $groupcount = count($wholegroup);
for($k=0;$k<$groupcount;$k++)
{
$result1 = $read->recognizeSentToGroup($cid,$rzid,$wholegroup[$k]);
}
/***************************find employee id **********************/ 
$usertype = "All";
$emloyeeid = $push->get_Employee_details($usertype,$ur,$cid);
$rty1 = json_decode($emloyeeid,true);
/*echo "<pre>";
echo "all employee id";
print_r($rty1);
echo "</pre>";*/
$reg_token = $push->getGCMDetails($rty1,$cid);
$token1 = json_decode($reg_token, true);
/*
echo "<pre>";
echo "all employee id reg token";
print_r($token1);
echo "</pre>";
*/
/***************************************************/

/*********************Create file of user which this post send  start*********************/
$val[] = array();
foreach($token1 as $row)
{
 array_push($val,$row["clientId"].",".$row["userUniqueId"].",".$row["registrationToken"]);
}

$file = fopen("../send_push_datafile/".$rzid.".csv","w");

foreach ($val as $line)
  {
  fputcsv($file,explode(',',$line));
  }
fclose($file);

/*********************Create file of user which this post send End*********************/


/*********************check push notificaticon enabale or disable*********************/
if($PUSH_NOTIFICATION == 'PUSH_YES')
{

/********************* send push by  push notification*********************/

$hrimg = "http://admin.benepik.com/employee/virendra/benepik_admin/".$_SESSION['image_name'];
$sf = "successfully send";
$ids = array();
foreach($token1 as $row)
{
 array_push($ids,$row["registrationToken"]);
}
$FLAG = 10;
$flag_name = "Recognition : ";
$like_val = "yes";
$comment_val = "yes";


$data = array('Id' => $rzid, 'Title' => $title, 'Content' => $comment, 'SendBy'=> $usersname, 'Picture'=>$byimage, 'image' => $image, 'Date' =>$date, 'flag'=>$FLAG,'flagValue'=>$flag_name,'success'=>$topic,'like'=>$like_val,'comment'=>$comment_val);

 $revert = $push->sendGoogleCloudMessage($data,$ids,$googleapi);
 $rt = json_decode($revert,true);

//echo $revert;
 if($rt["success"] == 1)
 {
 echo "<script>alert('Recognize Approve')</script>";
 echo "<script>window.location='../view_recognize.php'</script>";
 }
 }
 else
 {
 echo "<script>alert('Recognize Approve')</script>";
 echo "<script>window.location='../view_recognize.php'</script>";
 }

/*
 $resp = json_decode($res,true);
if($resp['success'] == 1)
{
//echo "<script>alert('Recognize Approve')</script>";
//echo "<script>window.location='../view_recognize.php'</script>";
}
*/
}
}
else
{

}


?>