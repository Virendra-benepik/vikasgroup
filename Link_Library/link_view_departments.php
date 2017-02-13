<?php
require_once('../Class_Library/class_client_department.php');
if(!empty($_REQUEST['clientid']))
{ 
$cid = $_REQUEST['clientid'];
$locid = $_REQUEST['locationid'];


 $location_obj = new ContactDepartment();  
 $result =  $location_obj->viewDepartment($cid,$locid);
 echo $result;

}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="textfield">
  </p>
<p>Location id:
    <label for="textfield"></label>
  <input type="text" name="locationid" id="textfield">
  </p>

  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>