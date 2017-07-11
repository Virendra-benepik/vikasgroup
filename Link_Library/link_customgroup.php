<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../Class_Library/class_create_group.php');
if(!empty($_POST))
{ 
$obj = new Group();
$groupmaxid = $obj->getMaxId();

date_default_timezone_set('Asia/Calcutta');
$currentdate = date('Y-m-d H:i:s');

$clientid = $_POST['clientid'];
$createdby= $_POST['uuid'];
$groupname = $_POST['group_title'];
$groupdesc = $_POST['groupdesc'];
$filename = trim(str_replace(" ", "_", $_FILES['cgroup_csv_file']['name']));
$upload_file_name = $groupmaxid . "-" . $filename;
$filtempname = $_FILES['cgroup_csv_file']['tmp_name'];
$target = "../customgroupCSVfile/";
$target1 = "/customgroupCSVfile/";
$fullcsvpath = $target1 . $upload_file_name;
$grouptype = 2;
$status = "active";

/*********************** insert group details ***********************/
$groupdetails = $obj->createGroup($clientid,$groupmaxid,$groupname,$groupdesc,$createdby,$currentdate,$status,$grouptype);

$groupadmin = $obj->createGroupAdmin($clientid,$groupmaxid,$createdby,$createdby);

$customgroupres = $obj->createCustomGroup($clientid,$groupmaxid,$groupname,$filename, $filtempname, $fullcsvpath,$createdby,$currentdate);
$resdecode = json_decode($customgroupres, true);
//echo "<pre>";
//print_r($resdecode);
	if($resdecode['success'] == 1)
	{
	move_uploaded_file($filtempname, $target . $upload_file_name);
	echo "<script>alert('Custom Group created successfully')</script>";
	echo "<script>window.location='../addcustomgroup.php'</script>";
	}
	else
	{
	echo "<script>alert('Group Not created')</script>";
	echo "<script>window.location='../addcustomgroup.php'</script>";	
	}
}
?>
