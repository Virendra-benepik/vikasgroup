<?php
require_once('../Class_Library/class_client_location.php');
if(!empty($_POST))
{ 
$locid = $_POST['locationid'];

$location_obj = new ContactLocation();  // create object of class cl_module.php
$result =  $location_obj->deleteLocation($locid);
print_r($result);

}
else
{
?>
<form name="form1" method="post" action="">
  <p>location Id:
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