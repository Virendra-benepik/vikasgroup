<?php
require_once('../Class_Library/class_client_department.php');
if(!empty($_POST))
{ 
$cid = $_POST['clientid'];
$lid = $_POST['locationid'];
$did = $_POST['departmentid'];
$dnam = $_POST['departmentname'];

$location_obj = new ContactDepartment();  // create object of class cl_module.php
$result =  $location_obj->updateDepartment($cid,$lid,$did,$dnam);
print_r($result);

}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="textfield">
  </p>
  <p>location id:
    <label for="textfield"></label>
  <input type="text" name="locationid" id="textfield">
  </p>
  <p>Department id:
    <label for="textfield"></label>
  <input type="text" name="departmentid" id="textfield">
  </p>
  <p>Department name:
    <label for="textfield"></label>
  <input type="text" name="departmentname" id="textfield">
  </p>
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>