<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_subadminCreate.php');
if (!empty($_POST)) 
{

$obj = new subadmin();                                        // object of class post page
$subadminid = $obj->getMaxadminid(); 

	$companyname = $_POST['companyname'];
	$empcode = $_POST['empcode'];
	$uuid =  $_POST['useruniqueid'];
	$clientid = $_SESSION['client_id'];
	$createdby = $_SESSION['user_email'];
    $result = $obj->create_Subadmin($companyname,$empcode,$uuid,$subadminid,$clientid,$createdby);
	$resultdecode = json_decode($result , true);
	//print_r($result);
                if($resultdecode['success'] == 1) 
				{
                    echo "<script>alert('".$resultdecode['message']."');</script>";
					echo "<script>window.location='../subadmin_create.php'</script>";
                } 
				else 
				{
                    echo "<script>alert('".$resultdecode['message']."');</script>";
                    echo "<script>window.location='../subadmin_create.php'</script>";
                }

}
     
else 
{
?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">
	User Unique id :<br>
	<input type="text" name = "useruniqueid" placeholder="enter user unique id"/><br><br>
	Company Name :<br>
     <input type="text" name="companyname" id="companyname" placeholder="Enter Company name" /><br><br>
	 Employee Code :<br>
	 <input type="text" name="empcode" id="empcode" placeholder="Enter Employee Code" /><br><br>
	 <input type="submit" name="createsubadmin" value="submit">
	 </form>

<?php
}
?>