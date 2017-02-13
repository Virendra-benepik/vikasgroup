<?php
@session_start();
require_once('../Class_Library/class_post.php');
require_once('../Class_Library/class_push_notification.php');

date_default_timezone_set('Asia/Calcutta');
$post_date = date("Y-m-d h:i:sa",time());
 
$obj = new Post();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
$db = new Connection_Client();

$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/post_img/';   // folder name for storing data
$folder = 'images/post_img/';      //folder name for add with image insert into table

/********************************START HERE*************************************************/
if(!empty($_POST))
{ 
$flag_value = $_POST['flag'];
if(isset($_POST['news_post']))
{
//extract($_POST);

if($flag_value == 1)
{

$dev = $_POST['device'];
if($dev == 'd1')
{
$USEREMAIL = $_POST['author'];
$BY =  $_POST['auth'];
}
if($dev == 'd2')
{
$USEREMAIL = $_SESSION['user_email'];
$BY =  $_SESSION['user_name'];
}
$path = $_FILES['uploadimage']['name'];
$pathtemp = $_FILES['uploadimage']['tmp_name'];

$path_name = $maxid."-".$path;
 $fullpath = "http://admin.benepik.com/employee/virendra/benepik_client/images/post_img/".$path_name;
 if(move_uploaded_file($pathtemp, $target.$path_name))
				{
				  //  echo "img uploaded";
				}
				else
				{
				  echo "error";
				}

$POST_ID  =   $maxid;
$POST_TITLE = $_POST['title'];
$POST_IMG =   $folder.$path_name;
$POST_TEASER = $_POST['teasertext'];
$POST_CONTENT = $_POST['content'];
$DATE  =  $post_date;
$FLAG = $flag_value;
//$User_Type = $_POST['user3'];
$User_Type = "Selected";

	/*if($User_Type == 'Selected')
	{
	$user1 = $_POST['selected_user'];
	$user2 = rtrim($user1,',');
          $myArray = explode(',', $user2);
       //  print_r($myArray)."<br/>";
        }
        else
        {
       
        }*/
/*********************** insert into database *************************************************/

$result = $obj->create_Post($POST_ID,$POST_TITLE,$POST_IMG,$POST_TEASER,$POST_CONTENT,$DATE,$USEREMAIL,$BY,$FLAG);
			
				/******************  fetch gcm details *****************************/
//$user = array('manoj@gmail.com','sonam@gmail.com','ameen.benepik@gmail.com');
//print_r($user);
$myArray = array('Group-61','Group-60','Group-62','Group-63');
$gcm_value = $push->get_GCM_details($User_Type,$myArray);
//echo $gcm_value;
$token = json_decode($gcm_value, true);

/*********************Create file of user which this post send  start*********************/
$val[] = array();
foreach($token as $row)
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
$hrimg = "http://admin.benepik.com/employee/virendra/benepik_client/img/hr.jpg";
$sf = "successfully send";
$ids = array();
foreach($token as $row)
{
 array_push($ids,$row["registrationToken"]);
}
echo "<pre>";
print_r($ids);
echo "</pre>";

$data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy'=> $BY, 'Picture'=> $hrimg, 'image' => $fullpath, 'Date' =>$DATE, 'flag'=>$FLAG,'success'=>$sf);

 $revert = $push->sendGoogleCloudMessage($data, $ids);
 $rt = json_decode($revert,true);
// print_r($rt);
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
 echo "<script>window.location='../postnews.php'</script>";
}


 }

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
<p> Author(Valid Email Id)<p>
    <label for="textfield"></label>
  <input type="Email" name="author" id="textfield">
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
