<?php
session_start();
require_once('../Class_Library/class_user.php');

$obj = new User();     //class object
$clientid = $_SESSION['client_id'];
$createBy = $_SESSION['user_email'];

//echo "user id-: ".$user;

if(!empty($_POST)){ 

	if(isset($_POST['user_form']))
	{
	$cid = $clientid;
	
	extract($_POST);
	
	$result = $obj->createAdmin($emp_code,$cid,$emp_uniq_Id,$accessibility,$createBy);
	print_r($result);
	if($result['success'] == '1') {
		echo "<script>alert('Admin created successfully');</script>";
		echo "<script>window.location='../mahle_add_new_admin.php'</script>";
	}
	
	}

}
else{ ?>

<form method="post" action="">
Employee Code
<input type="text" name="emp_code"  required >
<br><br>
User Unique Id
<input type="text" name="emp_uniq_Id"  required >
<br><br>
Accessibility
<select name="accessibility" >
<option value="">Select Accessibility</option>
<option value="Admin">Admin</option>
<option value="SubAdmin">SubAdmin</option>
</select>
<br><br>
<button type="submit" name="user_form" >Submit</button>
</form>
<?php } ?>