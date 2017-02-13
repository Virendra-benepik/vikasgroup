<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_post.php');
require_once('../Class_Library/class_push_notification.php');

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');

 
$obj = new Post();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
//$db = new Connection_Client();

$read = new Reading();

$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/post_img/';   // folder name for storing data
$folder = 'images/post_img/';      //folder name for add with image insert into table

/********************************START HERE*************************************************/
if(!empty($_POST))
{ 

$flag_value = $_POST['flag'];
$flag_name = "Mahle Life : ";
$dev = $_POST['device'];
if(isset($_POST['news_post']))
{

if($dev == 'd1')
{
$USERID = $_POST['author'];
$BY =  $_POST['auth'];
$clientid = $_POST['client'];
}
if($dev == 'd2')
{
$USERID = $_POST['useruniqueid'];
$googleapi = $_POST['googleapi'];
//echo "user id - ".$USERID;
$BY =  $_SESSION['user_name'];
$clientid = $_SESSION['client_id'];
//echo $clientid;
}
$path = $_FILES['uploadimage']['name'];
$pathtemp = $_FILES['uploadimage']['tmp_name'];
//echo $path;
$path_name = $maxid."-".$path;

$imagepath = $target.$path_name;

$fullpath = "http://".$_SERVER['SERVER_NAME']."/images/post_img/".$path_name;
//echo $fullpath;
$obj->compress_image($pathtemp, $imagepath, 20);

/****************************************** check like & comment start ***********************/
$like = $_POST['like'];
if(!isset($like) && $like != 'LIKE_YES')
{
$like = 'LIKE_NO';
$like_val = 'No';
}
else
{
$like_val = 'Yes';
}

$comment =  $_POST['comment'];
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

/****************************************** check like & comment end ***********************/

$POST_ID  =   $maxid;
$POST_TITLE = trim($_POST['title']);
//echo "post title : ".$POST_TITLE."<br/>";
$POST_IMG =   $folder.$path_name;
$userabout = trim($_POST['userabout']);
//echo "user about : ".$userabout."<br/>";
$my_path = trim($_POST['mypath']);
//echo "MY path : ".$my_path."<br/>";
$my_life = trim($_POST['mylife']);
//echo "MY LIFE : ".strlen(strip_tags($my_life))."<br/>";
$myworkday = trim($_POST['myworkday']);
//echo "MY AS USUAL WORK DAY : ".strlen(strip_tags($myworkday))."<br/>";
$my_project = trim($_POST['projectdone']);
//echo "PROJECT I HAVE DONE : ".str_word_count(strip_tags($my_project))."<br/>";
$my_place = trim($_POST['placeiseen']);
//echo "PLACES I HAVE SEEN : ".strlen(strip_tags($my_place))."<br/>";
$my_personal_life = trim($_POST['mypersonallife']);
//echo "MY PERSONAL LIFE : ".$POST_CONTENT5."<br/>";

/*******************************************/
$POST_CONTENT = "";
if(!empty($userabout) && str_word_count(strip_tags($userabout))>0 )
{
$POST_CONTENT .= "<b>About Me</b>"."<br>".$userabout."<br><br>";
}

if(!empty($my_path) && str_word_count(strip_tags($my_path))>0)
{
$POST_CONTENT .="<b>My Path at Mahle</b>"."<br>".$my_path."<br><br>";
}


if(!empty($my_life) && str_word_count(strip_tags($my_life))>0 )
{
$POST_CONTENT .="<b>My Life at Mahle</b>"."<br>".$my_life."<br><br>";
}


if(!empty($myworkday) && str_word_count(strip_tags($myworkday))>0)
{
$POST_CONTENT .="<b>My usual day at work</b>"."<br>".$myworkday."<br><br>";
}


if(!empty($my_project) && str_word_count(strip_tags($my_project))>0)
{
$POST_CONTENT .="<b>Projects I'm Proud Of</b>"."<br>".$my_project."<br><br>";
}


if(!empty($my_place) && str_word_count(strip_tags($my_place))>0)
{
$POST_CONTENT .="<b>Places I have been</b>"."<br>".$my_place."<br><br>";
}

if(!empty($my_personal_life) && str_word_count(strip_tags($my_personal_life))>0)
{
$POST_CONTENT .="<b>My personal life</b>"."<br>".$my_personal_life."<br><br>";
}

/********************************************/
//echo $POST_CONTENT;
//$POST_CONTENT =$userabout."<br>".$my_path."<br>".$my_life."<br>".$myworkday."<br>".$my_project."<br>".$my_place."<br>".$my_personal_life;

$DATE  =  $post_date;
$FLAG = $flag_value;
$User_Type = $_POST['user3'];

	if($User_Type == 'Selected')
	{
	$user1 = $_POST['selected_user'];
	$user2 = rtrim($user1,',');
        $myArray = explode(',', $user2);
    /*   echo "selected user"."<br/>";
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
        
     

/********************************************* Get GoogleAPIKey and IOSPEM file **********************************/
$googleapiIOSPem = $push->getKeysPem($clientid);
/***************************************************************************************/   
        

/*********************** insert into database *************************************************/

$result = $obj->create_Post($clientid,$POST_ID,$POST_TITLE,$POST_IMG,$userabout,$POST_CONTENT,$DATE,$USERID,$BY,$FLAG,$like,$comment);

$type = 'LifeatMahle';
$result1 = $obj->createWelcomeData($clientid,$POST_ID,$type,$POST_TITLE,$POST_IMG,$DATE,$USERID);

$groupcount = count($myArray);
for($k=0;$k<$groupcount;$k++)
{
//echo "group id".$myArray[$k];
$result1 = $read->postSentToGroup($clientid,$maxid,$myArray[$k]);
//echo $result1;
}

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
//echo "within not all user type".$User_Type."<br/>";
$groupadminuuid = $push->getGroupAdminUUId($myArray,$clientid);
$adminuuid = json_decode($groupadminuuid, true);
/*echo "hello groupm admin id";
echo "<pre>";
print_r($adminuuid)."<br/>";
echo "</pre>";
echo "--------------all employee id---------";*/

$allempid = array_merge($token,$adminuuid);
/*echo "<pre>";
print_r($allempid);
echo "<pre>";

echo "--------------all unique employee id---------";*/

$allempid1 = array_values(array_unique($allempid));

/*echo "user unique id";
echo "<pre>";
print_r($allempid1);
echo "<pre>";*/

}
else
{
//echo "within all user type".$User_Type."<br/>";
$allempid1 = $token;
}

/********* insert into post sent to table for analytic sstart*************/

$total = count($allempid1);
for($i=0; $i<$total; $i++)
{
$uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
if(!empty($uuid))
{
$read->postSentTo($clientid,$maxid,$uuid);
}
else
{
continue;
}
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
 array_push($val,$row["clientId"].",".$row["userUniqueId"].",".$row["registrationToken"]);
}

$file = fopen("../send_push_datafile/".$maxid.".csv","w");

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
$idsIOS = array();
foreach($token1 as $row)
{
  
  if($row['deviceName'] == 'ios'){
      array_push($idsIOS,$row["registrationToken"]);
  }
  else{
      array_push($ids,$row["registrationToken"]);
  }
    //array_push($ids,$row["registrationToken"]);
}


$data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy'=> $BY, 'Picture'=> $hrimg, 'image' => $fullpath, 'Date' =>$DATE, 'flag'=>$FLAG,'flagValue'=>$flag_name,'success'=>$sf,'like'=>$like_val,'comment'=>$comment_val);

$IOSrevert = $push->sendAPNSPush($data,$idsIOS,$googleapiIOSPem['iosPemfile']);
 $revert = $push->sendGoogleCloudMessage($data,$ids,$googleapiIOSPem['googleApiKey']);
 $rt = json_decode($revert,true);

 if($rt)
 {
 if($dev == 'd1')
{
echo "<script>alert('Post Successfully Send');</script>";
echo $rt;
}
else
{
 echo "<script>alert('Post Successfully Send');</script>";
// print_r($rt);
 echo "<script>window.location='../mylifeatmahle.php'</script>";
//echo $revert;
}

 }
 }
 else
 {
 echo "<script>alert('Post Successfully Send');</script>";
 echo "<script>window.location='../mylifeatmahle.php'</script>";
 }


/****************************if condition 2 end*****************************************************************/
 }
 
}
else
{
?>
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
    <option value='1'>1</option>
   
    </select>
 
  </p>
  <p>Post Title:
    <label for="textfield"></label>
  <input type="text" name="title" id="textfield">
  </p>
   <p>CLIENT
    <label for="textfield"></label>
  <input type="text" name="CLIENTID" id="textfield">
  </p>
   <p>Post image:
    <label for="textfield"></label>
  <input type="file" name="uploadimage" id="textfield">
  </p>
  <p>Post teaser:
    <label for="textfield"></label>
  <input type="text" name="teasertext" id="textfield">
  </p>
   <p>Post content:
    <label for="textfield"></label>
    <textarea name="content" id="textfield"></textarea>
 </p>
<p> Author(Valid system generated  UU Id)<p>
    <label for="textfield"></label>
  <input type="Email" name="author" id="textfield">
  <p>
  <p>Client Id<p>
    <label for="textfield"></label>
  <input type="Email" name="client" id="textfield">
  <p>
  <p> Author name<p>
    <label for="textfield"></label>
  <input type="text" name="auth" id="textfield">
  <p>
 
   <input type="hidden" name="user3" id="textfield" value="All">
  	
    <input type="submit" name="news_post" id="button" value="Submit">
  </p>
</form>

<?php
}
?>