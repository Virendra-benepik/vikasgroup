<?php
require_once('../Class_Library/class_update_group.php');
if(!empty($_POST))
{ 
$obj = new Group();
$groupmaxid = $_POST['idgroup'];

date_default_timezone_set('Asia/Calcutta');
$channel_date = date('d M Y, h:i A');

$clientid = $_POST['id_author'];
$createdby= $_POST['channel_author'];

$groupname = $_POST['group_title'];
//echo "group title-: ".$groupname."<br/>";
$groupdesc = $_POST['groupdesc'];
//echo "groupdesc -: ".$groupdesc."<br/>";

$status = 'active';
/********************************* insert group details **********************************/
$obj->deleteAllData($clientid,$groupmaxid);

$groupdetails = $obj->createGroup($clientid,$groupmaxid,$groupname,$groupdesc,$createdby,$channel_date,$status);
//$groupadmin = $obj->createGroupAdmin($clientid,$groupmaxid,$createdby);
//echo $groupdetails['msg'];

/************************** insert group admin******************************************/
$countadmin = $_POST['countadmin'];
//echo $countadmin;
for($k=0;$k<$countadmin;$k++)
{
$val = 'admin'.$k;
$adminemail = $_POST[$val];
//echo $adminemail."<br/>";

$groupadmin = $obj->createGroupAdmin($clientid,$groupmaxid,$adminemail);
}
echo $groupadmin['msg'];
/************************** insert group  demo graphy ******************************************/
$countdiv = $_POST['countvalue']; //check count demography parameter 
for($i=0;$i<$countdiv;$i++)
{
$name = 'group'.$i;
echo "group array:= ".$name."<br/>";
$columnName = $_POST[$name];          // find group array value in columnname
$countgroupvalue = count($columnName);

for($j=0;$j<$countgroupvalue;$j++)
{
$valdemo = explode('|',$columnName[$j]);	
if($valdemo[1] == 'All')
{
$result = $obj->createGroupDemoGraphy($clientid,$groupmaxid,$valdemo[0],$valdemo[1]);

break;
}	
else
{	
$valdemo1 = explode('|',$columnName[$j]);
$result = $obj->createGroupDemoGraphy($clientid,$groupmaxid,$valdemo1[0],$valdemo1[1]);

}	

}

}
if($groupadmin['success'] == 1)
{
echo "<script>alert('Group updated successfully')</script>";
echo "<script>window.location='../viewchannel.php'</script>";
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