<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/deepak_class_post.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_welcomeTable.php');


date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');
 
$obj = new Post();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();
$welcome_obj = new WelcomePage();

$maxid = $obj->maxId();  //---------get latest post_id
/********************************START HERE*************************************************/
if(!empty($_POST))
{ 
$flag_value = 3;

$comment = "";
$like = "";
$flag_name = "Picture : ";
/****************************if condition 2 end*****************************************************************/

$POST_ID  =   $maxid;
$POST_TITLE = "";
$POST_IMG =   $_POST['uploadimage'];
$POST_TEASER = "";
$POST_CONTENT = $_POST['content'];
$DATE  =  $post_date;
$User_Type = $_POST['user3'];
//echo $User_Type;
//$User_Type = "Selected";
$USERID = $_POST['author'];
$BY =  $_POST['auth'];
$clientid = $_POST['client_id'];
$googleapi = $_POST['googleapi'];
$FLAG = $flag_value; 
if($User_Type == 'Selected')
{
	$user1 = $_POST['selected_user'];
	 $user2 = rtrim($user1,',');
	
          $myArray = explode(',', $user2);
      //  print_r($myArray)."<br/>";
     }  

$comment = $_POST['comment'];
$like = $_POST['like'];

if(!isset($like) && $like != 'LIKE_YES')
{
$like = 'LIKE_NO';
$like1 = 'No';
}
else
{
$like1 = 'Yes';
}

if(!isset($comment) && $comment != 'COMMENT_YES')
{
$comment = 'COMMENT_NO';
$comment1 = 'No';
}
else
{
$comment1 = 'Yes';
}
 $push_noti =  $_POST['push'];
 /************************************* Get User Image *********************************************/
 $userimage = $push->getImage($USERID); 
 $image = $userimage[0]['userImage'];
 /*echo "hr image: ".$image."<br/>";
 echo "this sis hr image";
 echo "<pre>";
 print_r($userimage);
 echo "</pre>";*/
 /************************************************************************************8/
 
 
/*********************** insert into database *************************************************/

$number = $obj->randomNumber(12);
$imgname = $obj->convertintoimage($POST_IMG,$number);

//echo "image name ".$imgname;
$result = $obj->create_Post($clientid,$POST_ID,$POST_TITLE,$imgname,$POST_TEASER,$POST_CONTENT,$DATE,$USERID,$BY,$FLAG,$comment,$like);

//echo "result".$result;

$type = "Picture";
$result1 = $welcome_obj->createWelcomeData($clientid,$POST_ID,$type,$POST_CONTENT,$imgname,$DATE,$USERID);


$groupcount = count($myArray);
for($k=0;$k<$groupcount;$k++)
{
//echo "group id".$myArray[$k];
$result2 = $read->postSentToGroup($clientid,$POST_ID,$myArray[$k]);
//echo $result1;
}

/*
echo "value of result"."<br/>";
echo "<pre>";
print_r($result);
echo "</pre>";*/
	/******************  fetch all user employee id from user detail start *****************************/
$gcm_value = $push->get_Employee_details($User_Type,$myArray,$clientid);
$token = json_decode($gcm_value, true);
/*echo "hello user  id";
echo "<pre>";
print_r($token);
echo "</pre>";*/


/***************************get group admin uuid  form group admin table if user type not= all ****************************/
if($User_Type != 'All')
{
$groupadminuuid = $push->getGroupAdminUUId($myArray,$clientid);


$adminuuid = json_decode($groupadminuuid, true);
/*echo "hello groupm admin id";
echo "<pre>";
print_r($adminuuid)."<br/>";
echo "</pre>";*/
/******** "--------------all employee id---------"***/

$allempid = array_merge($token,$adminuuid);
/*echo "<pre>";
print_r($allempid);
echo "<pre>";*/

/**** "--------------all unique employee id---------"***********/

$allempid1 = array_unique($allempid);


}
else
{
$allempid1 = $token;
}
/*echo "<pre>";
print_r($allempid1);
echo "<pre>";*/
/********* insert into post sent to table for analytic sstart*************/

$total = count($allempid1);
for($i=0; $i<$total; $i++)
{
$uuid = $allempid1[$i];
//echo "post sent to :--".$uuid;
$read->postSentTo($clientid,$maxid,$uuid);
}
/********* insert into post sent to table for analytic sstart*************/

/***** get all registration token  for sending push *****************/
$reg_token = $push->getGCMDetails($allempid1,$clientid);
$token1 = json_decode($reg_token, true);
/*echo "----regtoken------";
echo "<pre>";
print_r($token1);
echo "<pre>";*/


/*********************Create file of user which this post send  start*********************/
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
/*********************Create file of user which this post send End*********************/
$hrimg = "http://admin.benepik.com/employee/virendra/benepik_admin/".$image;
//echo $hrimg;
$sf = "successfully send";
$ids = array();
foreach($token1 as $row)
{
 array_push($ids,$row["registrationToken"]);
}

$path = "http://admin.benepik.com/employee/virendra/benepik_client/".$imgname;
//echo $path;
$data = array('Id' => $maxid, 'Content' => $POST_CONTENT,'SendBy'=> $BY, 'Picture'=> $hrimg, 'image' => $path , 'Date' => $post_date,'flag' =>$FLAG,'flagValue'=>$flag_name,'success'=>$sf,'comment'=>$comment1,'like'=>$like1);

 $revert = $push->sendGoogleCloudMessage($data,$ids,$googleapi);
 $rt = json_decode($revert,true);

 if($revert)
 {

 //echo "<script>alert('Post Successfully Send');</script>";
// echo $path;
/*echo $revert."<br/><br/><br/>";
echo "<pre>";
print_r($rt);
echo "</pre>";*/

 }
 
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="device" value="d1">
<input type="hidden" name="push" value="PUSH_YES">
  <p> flag 1: fill all </p>
  <p> flag 2: fill only post content </p>
  <p> flag 3: fill only image and post content </p>
  <br/>
  <p>flag Value:
    <label for="textfield"></label>
    <select name="flag" id="textfield">
    <option selected>--select flag--</option>
    
    <option value='3'>3</option>
    </select>
 
  </p>
 <p>client id:
    <label for="textfield"></label>
  <input type="text" name="client_id" id="textfield">
  </p>
  <p>googleapi:
    <label for="textfield"></label>
  <input type="text" name="googleapi" id="textfield">
  </p>
   <p>Post image:
    <label for="textfield"></label>
  <input type="text" name="uploadimage" id="textfield">
  </p>
 
   <p>Post content:
    <label for="textfield"></label>
    <textarea name="content" id="textfield"></textarea>
 
  </p>
  <p> Author(Valid user unique Id)<p>
    <label for="textfield"></label>
  <input type="text" name="author" id="textfield">
  <p>
 
  <p> Author name<p>
    <label for="textfield"></label>
  <input type="text" name="auth" id="textfield">
  <p>
 
   Comment(Enable/Disable): <input type="checkbox" name="comment" id="comment" value="COMMENT_YES" checked/><br/>

     Like(Enable/Disable): <input type="checkbox" name="like" id="like" value="LIKE_YES" checked/><br/>

  Send push to All : <input type="text" name="user3" id="textfield" placeholder="write(All/Selected)" >
  <p>
 

<p>
 If Selected write Group Id end with ,
   <input type="text" name="selected_user" id="textfield" placeholder="write group id end with ," >
  <p>

  <p>
    <input type="submit" name="news_post" id="button" value="Submit">
  </p>
</form>

<?php
}
?>