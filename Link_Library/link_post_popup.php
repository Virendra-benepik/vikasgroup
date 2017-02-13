<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_post_popup.php');

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');
 
$obj = new PostPopup();                                        // object of class post page

$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/popupimage/';   // folder name for storing data
$folder = 'images/popupimage/';      //folder name for add with image insert into table

/********************************START HERE*************************************************/
if(!empty($_POST))
{ 

$USERID = $_POST['useruniqueid'];

$clientid = $_SESSION['client_id'];

$path = $_FILES['uploadimage']['name'];
$pathtemp = $_FILES['uploadimage']['tmp_name'];

$path_name = $maxid."-".$path;

$imagepath = $target.$path_name;

$res = $obj->compress_image($pathtemp, $imagepath, 20);
 
/************************************** LIKE COMMENT PUSH END ************************/

$POST_IMG =   $folder.$path_name;
$POST_CONTENT = trim($_POST['content']);
$DATE  =  $post_date;

/*********************** insert into database *************************************************/
                            
$result = $obj->create_PopupPost($clientid,$POST_IMG,$POST_CONTENT,$DATE,$USERID);
$res = json_decode($result, true);
//echo $result;
if($res["status"] == 1)
 {
  echo "<script>alert('PopUp Posted');</script>";
  echo "<script>window.location='../postpopup.php'</script>";
 }
 else
 {
  echo "<script>alert('PopUp Not Posted ');</script>";
 echo "<script>window.location='../postpopup.php'</script>";
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
  <input type="file" name="uploadimage" id="textfield">
  </p>
 
   <p>Post content:
    <label for="textfield"></label>
    <textarea name="content" id="textfield"></textarea>
 
  </p>
  <p> Author(Valid user unique id)<p>
    <label for="textfield"></label>
  <input type="Email" name="author" id="textfield">
  <p>
 
  <p> Author name<p>
    <label for="textfield"></label>
  <input type="text" name="auth" id="textfield">
  <p>
 write(All/Selected):
   <input type="text" name="user3" id="textfield" value="">
  <p>
 <p>
 Group id:
   <input type="text" name="selected_user" id="textfield" placeholder="write group id end with ,">
  <p>
 

  <p>
    <input type="submit" name="news_post" id="button" value="Submit">
  </p>
</form>

<?php
}
?>