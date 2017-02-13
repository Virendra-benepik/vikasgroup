<?php
require_once('../Class_Library/class_client_department.php');
if(!empty($_POST))
{ 
$locid = $_POST['departmentid'];

$location_obj = new ContactDepartment();  // create object of class cl_module.php
$result =  $location_obj->deleteDepartment($locid);
print_r($result);

}
else
{
?>
<form name="form1" method="post" action="">
  <p>department Id:
    <label for="textfield"></label>
  <input type="text" name="departmentid" id="textfield">
  </p>
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>