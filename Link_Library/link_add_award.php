<!--
Created By :- Monika Gupta
Created Date :- 26/10/2016
Description :- link files contain all fields from HTML file and create object of class files . call functions help of object and pass parameter into function for creating new client . 
-->
<?php
@session_start();
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
require_once('../Class_Library/class_award.php');
$obj = new award();
if(!empty($_POST))
{ 
	 $award_name = $_POST['award_name'];
	 $award_description = strip_tags($_POST['award_description']);
	 //$flag_value = $_POST['flag'];
     //$flag_name = $_POST['flagvalue'];
	 //$USERID = $_POST['useruniqueid'];
	 //$User_Type = $_POST['user3'];
	 $clientid = $_SESSION['client_id'];
	 $useruniqueid = $_SESSION['user_unique_id'];
	 
     $awardfolder = BASE_PATH.'/images/award_img/';  	 // folder name for storing data
	 
     $awardtarget = 'images/award_img/';             //folder name for add with image insert into table
	 $awardimgname = '';
	if(!empty($_FILES['uploadimage']['name']))
	{
	$awardimgname = $_FILES['uploadimage']['name'];
	
	$awardtempname = $_FILES['uploadimage']['tmp_name'];
	
	}
	else
	{
	$awarddbpath = "";
	}
	
	 $result = $obj->createAward($award_name,$award_description,$clientid,$awardimgname,$useruniqueid);
	
     if($result['success'] == 1)
	  {
		  //echo "hello i m here";
		  $maxid = $result['newawardid'];
		  if(!empty($awardimgname))
		  {
			  
		  $awardimgname1 = $maxid."-".$awardimgname;
		 // echo $awardimgname;
		  $awardfolderpath = $awardfolder.$awardimgname1;
		  echo $awardfolderpath;
		  //$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/images/";

       if (move_uploaded_file($awardtempname, $awardfolderpath)) {
       // echo "upload";
      } else {
    echo 'Upload directory is not writable, or does not exist.';
	 ini_set('log_errors',1);
}
		  
						 
					
		  }
		  
		 echo "<script>alert('".$result['msg']."')</script>";
		  echo "<script>window.location = '../add_award.php'</script>";
	 }
}
else
{
?><form action="" method="post">
	Award Name:<br />
	<input type="text" name="award_name" placeholder="Enter Award Name">
	<br /><br />
	Award Description:<br />
	<textarea name="award_description" placeholder="Enter Award Description"></textarea>
	<br /><br />
	<input type="submit" value="Add Award" /> 
</form>
<?php
}
?>