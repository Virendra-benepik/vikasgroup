<?php
session_start();
require_once('../Class_Library/class_page.php');
$obj = new Page();
if(!empty($_POST))
{ 
$cid = $_POST['client'];
$title = $_POST['pagetitle'];
$content = $_POST['pagecontent'];
$pid = $_POST['pageid'];

 date_default_timezone_set('Asia/Calcutta');
 $post_date = date("Y-m-d h:i:sa",time());
 
/************************fetch max id *************************************/
/*
$path = $_FILES['pageimage']['name'];
$pathtemp = $_FILES['pageimage']['tmp_name'];

$target = '../HRPolicies/page_img/';   // folder name for storing data
$folder1 = 'HRPolicies/page_img/';      //folder name for add with image insert into table

$path_name = $pid."-".$path;
 //$fullpath = "http://admin.benepik.com/employee/virendra/benepik_client/images/page_img/".$path_name;
 if( move_uploaded_file($pathtemp, $target.$path_name))
				{
				  //  echo "img uploaded";
				}
				else
				{
				  //echo "error";
				}
*/



$target = '../HRPolicies/';
$folder = 'HRPolicies/';
//$img_name = $folder1.$path_name;
$createdby =  $_SESSION['user_email'];
$pagename = $target.$pid.".html";

unlink($pagename);
if(file_put_contents($target.$pid.".html",$content))
{
  //  echo "<script>alert('file created')</script>";
  }
else
{
   // echo "<script>alert('file not created')</script>";
   } 
   
$result = $obj->updatePage($cid,$pid,$title,$post_date);
if($result['success'] == 1)
{
echo "<script>alert('Page Updated successfully');</script>";
echo "<script>window.location = '../view_page.php'</script>";
}
}

				
/*********************** insert into databse *************************************************/



else
{
?>
<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>

<form name="form1" method="post" action="" enctype="multipart/form-data">
  <p>Page Id:
    <label for="textfield"></label>
  <input type="text" name="pageid" id="textfield">
  </p> 
  <p>Page Title:
    <label for="textfield"></label>
  <input type="text" name="pagetitle" id="textfield">
  </p>
  
  <p>Page image:
    <label for="textfield"></label>
  <input type="file" name="pageimage" id="textfield">
  </p>
   <p>Page Content:
    <label for="textfield"></label>
    <textarea cols="80" id="editor1" name="pagecontent" rows="10">	
	</textarea>
  
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
