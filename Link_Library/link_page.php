<?php
session_start();
require_once('../Class_Library/class_page.php');
$obj = new Page();
if(!empty($_POST))
{ 
$title = $_POST['pagetitle'];
$content = $_POST['pagecontent'];

 date_default_timezone_set('Asia/Calcutta');
 $post_date = date("Y-m-d H:i:s",time());
 
/************************fetch max id *************************************/
$maxid = $obj->maxID();

$path = $_FILES['pageimage']['name'];
$pathtemp = $_FILES['pageimage']['tmp_name'];

$target = '../HRPolicies/page_img/';   // folder name for storing data
$folder1 = 'HRPolicies/page_img/';      //folder name for add with image insert into table

$path_name = $maxid."-".$path;
 //$fullpath = "http://admin.benepik.com/employee/virendra/benepik_client/images/page_img/".$path_name;
 if( move_uploaded_file($pathtemp, $target.$path_name))
				{
				  //  echo "img uploaded";
				}
				else
				{
				 // echo "error";
				}




$target = '../HRPolicies/';
$folder = 'HRPolicies/';
$img_name = $folder1.$path_name;
$createdby =  $_POST['useruniqueid'];
$pagename = $folder.$maxid.".html";
$client_id = $_SESSION['client_id'];

$pubtime1 = $_POST['publish_date1'].$_POST['publish_time1'];
$utime1 = $_POST['publish_date2']." ".$_POST['publish_time2'];
//$utime1 = date(Y-m-d h:i:s ,strtotime($unpubtime1));


if(empty($_POST['publish_date1']) || $_POST['publish_date1'] == "")
{
$ptime1 = $post_date;
}
if(empty($_POST['unpublish_date1']) || $_POST['unpublish_date1'] == "")
{
//$utime1 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($post_date)) . " + 365 day"));
$utime1 = date('Y-m-d', strtotime('+1 year'));

}

/*if(empty($ptime1))
{
echo $ptime = ""; 
echo "<script>alert('it is empty')</script>";
}
else
{echo $ptime = $ptime1; }

if(empty($utime1))
{echo $utime = ""; echo "<script>alert('it is empty')</script>";}
else
{echo $utime = $utime1; }*/

/*
$date = date_create($ptime1);
$ptime =  date_format($date,"d-M-Y h:i:A");

$date1 = date_create($utime1);
$utime =  date_format($date1,"d-M-Y h:i:A");*/


if(file_put_contents($target.$maxid.".html",$content))
{
  //  echo "<script>alert('file created')</script>";
  }
else
{
   // echo "<script>alert('file not created')</script>";
   } 
   
$result = $obj->addPage($maxid,$client_id,$title,$img_name,$pagename,$createdby,$post_date,$ptime1,$utime1);
if($result['success'] == 1)
{
echo "<script>alert('HR Policy Successfully Created');</script>";
echo "<script>window.location = '../addpage.php'</script>";
}
}

				
/*********************** insert into database *************************************************/



else
{
?>
<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>

<form name="form1" method="post" action="" enctype="multipart/form-data">
 
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