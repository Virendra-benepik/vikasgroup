<?php
require_once('../Class_Library/class_create_group.php');
require_once('../Class_Library/class_get_useruniqueid.php');   // this class for getting user unique id

if(!empty($_POST))
{ 
$obj = new Group();
$object = new UserUniqueId();

$groupmaxid = $obj->getMaxId();

date_default_timezone_set('Asia/Calcutta');
$channel_date = date('Y-m-d H:i:s');

$clientid = $_POST['id_author'];
$createdby= $_POST['channel_author'];

$groupname = $_POST['group_title'];
//echo "group title-: ".$groupname."<br/>";
$groupdesc = $_POST['groupdesc'];
//echo "groupdesc -: ".$groupdesc."<br/>";

$status = 'active';
/********************************* insert group details **********************************/
$groupdetails = $obj->createGroup($clientid,$groupmaxid,$groupname,$groupdesc,$createdby,$channel_date,$status);
$groupadmin = $obj->createGroupAdmin($clientid,$groupmaxid,$createdby,$createdby);
//echo $groupdetails['msg']."<br/>";

/************************** insert group admin******************************************/
$countadmin = $_POST['countadmin'];
$countadmin1 = $_POST['countadmin1'];
//echo "echo count admin:-".$countadmin."<br/>";

for($k=0;$k<$countadmin;$k++)
{
$val = 'admin'.$k;
$adminempid = $_POST[$val];
//echo $adminempid."<br/>";

$uid = $object->getUserUniqueId($clientid,$adminempid);
//echo "admin uuid: -".$uid."<br/>";
$uid1 = json_decode($uid, true);
$uniqueuserid = $uid1[0]['employeeId'];

$adminemailid = $object->getUserData($clientid,$createdby);
$uid2 = json_decode($adminemailid, true);
//print_r($uid2);
$emailid = $uid2[0]['emailId'];


$groupadmin = $obj->createGroupAdmin($clientid,$groupmaxid,$uniqueuserid,$createdby);
$adminmaxid = $obj->getAdminMaxId();
//echo "admin max id :- ".$adminmaxid."<br/>";
$subadmin = $obj->createSubAdmin($adminmaxid,$clientid,$uniqueuserid,$channel_date,$emailid);
//echo "<pre>";
//print_r($subadmin);
//echo "</pre>";
}
//echo $groupadmin['msg'];
/************************** insert group  demo graphy ******************************************/
$countdiv = $_POST['countvalue']; //check count demography parameter 
//echo "no. of demo graphy.:-".$countdiv."<br/>";
//echo "<script>alert($countdiv);</script>";

for($i=0;$i<$countdiv;$i++)
{
$name = 'group'.$i;
//echo "group array: = ".$name."<br/>";
$columnName = $_POST[$name];          // find group array value in columnname
//print_r($columnName)."<br/>";
$countgroupvalue = count($columnName);

for($j=0;$j<$countgroupvalue;$j++)
{
$valdemo = explode('|',$columnName[$j]);	
//echo "column value= : ".$valdemo."<br/>";
if($valdemo[1] == 'All')
{
$result = $obj->createGroupDemoGraphy($clientid,$groupmaxid,$valdemo[0],$valdemo[1],$createdby);

break;
}	
else
{	
$valdemo1 = explode('|',$columnName[$j]);
$result = $obj->createGroupDemoGraphy($clientid,$groupmaxid,$valdemo1[0],$valdemo1[1],$createdby);

}	

}

}
if($groupadmin['success'] == 1)
{
echo "<script>alert('Group successfully created')</script>";
//
echo "<script>window.location='../addchannel.php?clientid=".$clientid."'</script>";
//print_r($result);
}
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  <p>Group Aadmin:
    <label for="textfield"></label>
  <input type="text" name="adminemail" id="textfield"> 
  </p>
  <p>Group Name:
    <label for="textfield"></label>
  <input type="text" name="group_title" id="textfield">
  </p>

   <p>Group Description:
    <label for="textfield"></label>
    <textarea name="groupdesc" id="textfield"></textarea>
 
  </p>
 <p>Channel Author:
    <label for="textfield"></label>
  <input type="text" name="channel_author" id="textfield"> 
  </p>
  
  <p>
    <label for="textfield">select location</label>
  <input type="Checkbox" name="chan-all" id="textfield" value="All-Location"> All Department
  </p>
  
  <p>Location:
    <label for="textfield"></label>
  <input type="text" name="location" id="textfield"> 
  </p>
   <p>
    <label for="textfield">select department</label>
  <input type="Checkbox" name="dept-all" id="textfield" value="All-dept"> All Department
  </p>
  <p>Department:
    <label for="textfield"></label>
  <input type="text" name="department" id="textfield"> 
  </p>
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>