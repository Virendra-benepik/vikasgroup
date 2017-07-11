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

$countdiv = $_POST['countvalue']; //check count demography parameter
//echo "count value".$countdiv;
 $flag = 0;
for($k=0;$k<$countdiv;$k++)
{
    $name = 'group'.$k;
$columnName = $_POST[$name];          // find group array value in columnname

//echo "<pre>";
//print_r($columnName);
$countgroupvalue = count($columnName);
if($countgroupvalue <1)
{
    $flag++;
}
}
if($flag >0)
{
    echo "<script>alert('Please Select  Group parameter ');</script>";
           echo "<script>window.location='../addchannel.php?clientid=".$clientid."'</script>";
}
 else {
 $grouptype = 1;
/********************************* insert group details **********************************/
$groupdetails = $obj->createGroup($clientid,$groupmaxid,$groupname,$groupdesc,$createdby,$channel_date,$status,$grouptype);
$groupadmin = $obj->createGroupAdmin($clientid,$groupmaxid,$createdby,$createdby);
//echo $groupdetails['msg']."<br/>";

/************************** insert group admin******************************************/
$countadmin = $_POST['countadmin'];
$countadmin1 = $_POST['countadmin1'];
//echo "echo count admin:-".$countadmin."<br/>";

for($k=0;$k<$countadmin;$k++)
{
$val = 'adminid'.$k;
$adminempid = $_POST[$val];
//echo "<pre>";
//print_r($adminempid);
//echo $adminempid."<br/>";

$uid = $object->getUserUniqueId($clientid,$adminempid);
//echo "admin uuid: -".$uid."<br/>";
$uid1 = json_decode($uid, true);
$uniqueuserid = $uid1[0]['employeeId'];

$adminemailid = $object->getUserData($clientid,$createdby);
$uid2 = json_decode($adminemailid, true);
//print_r($uid2);
$emailid = $uid2[0]['emailId'];
$adminname = $uid2[0]['firstName']." ".$uid2[0]['lastName'];


$groupadmin = $obj->createGroupAdmin($clientid,$groupmaxid,$uniqueuserid,$createdby);
$adminmaxid = $obj->getAdminMaxId();
//echo "admin max id :- ".$adminmaxid."<br/>";
$subadmin = $obj->createSubAdmin($adminmaxid,$clientid,$uniqueuserid,$channel_date,$emailid);

/**************************** send mail to sub admin ****************************/
$subadmin_mail = $uid1[0]['emailId'];
$subadmin_name = $uid1[0]['firstName'];   
$groupname = $groupname;
        $createdby = $adminname.'('.$emailid.')';
        $createddate = $channel_date;

$to = $subadmin_mail;

$subject = 'Vikas Live Group Admin';

$from = "Vikas Live <vikaslive@benepik.com>";

// To send HTML mail, the Content-type header must be set

$headers  = 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 

// Create email headers

$headers .= 'From: '.$from."\r\n";

  

// Compose a simple HTML email message

$message = '<html><body>';

$message .= '<p>Dear '.$subadmin_name.', </p>';
$message .= '<p></p>';
$message .= '<p>You have been assigned as the sub admin for the following Group in Vikas Live:</p>';
$message .= '<p>Group Name: '.$groupname.'</p>';    
$message .= '<p>Created by: '.$createdby. '</p>';
$message .= '<p>Created Date: '.$createddate.'</p>';
$message .= '<p>Now, you can send updates, surveys and notifications to the group members.</p>';
$message .= '<p>Link for Vikas Live Content Management System (CMS): http://admin.vikaslive.in </p>';
$message .= '<p>Your Login id: '.$adminempid.' </p>';
$message .= '<p>Password:  your password will remain same as Vikas Live app </p>';
$message .= '<p></p>';
$message .= '<p>Regards,</p>';

$message .= '<p>Team Vikas Live</p>';

$message .= '</body></html>';

mail($to, $subject, $message, $headers);

// Sending email

/*if(mail($to, $subject, $message, $headers)){

    echo 'Your mail has been sent successfully.';

} else{

    echo 'Unable to send email. Please try again.';

}
*/

/********************************************/

}    
/************************** insert group  demo graphy ******************************************/

for($i=0;$i<$countdiv;$i++)
{
$name = 'group'.$i;
$columnName = $_POST[$name];          // find group array value in columnname
$countgroupvalue = count($columnName);
if($countgroupvalue <1)
{
     echo "<script>alert('Please Select  Group parameter ');</script>";
                echo "<script>window.location='../addchannel.php?clientid=".$clientid."'</script>";
}
//echo "this is count valu-".$countgroupvalue;
for($j=0;$j<$countgroupvalue;$j++)
{
$valdemo = explode('|',$columnName[$j]);
//echo "<pre>";
//print_r($valdemo);
//echo "column value= : ".$valdemo."<br/>";
if($valdemo[1] == 'All')
{
$result = $obj->createGroupDemoGraphy($clientid,$groupmaxid,$valdemo[0],$valdemo[1],$createdby);

break;
}	
else
{	
$valdemo1 = explode('|',$columnName[$j]);
//echo "<pre>";
//print_r($valdemo1);
$result = $obj->createGroupDemoGraphy($clientid,$groupmaxid,$valdemo1[0],$valdemo1[1],$createdby);
}
}
}
if($groupadmin['success'] == 1)
{
echo "<script>alert('Group successfully created')</script>";
echo "<script>window.location='../addchannel.php?clientid=".$clientid."'</script>";
//print_r($result);
}
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