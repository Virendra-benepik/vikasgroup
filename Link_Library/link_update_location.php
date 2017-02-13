<?php
require_once('../Class_Library/class_client_location.php');
if(!empty($_POST))
{ 
$cid = $_POST['clientid'];
$lid = $_POST['locationid'];
$lnam = $_POST['locationname'];

$location_obj = new ContactLocation();  // create object of class cl_module.php
$result =  $location_obj->updateLocation($cid,$lid,$lnam);
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
  <p>location name:
    <label for="textfield"></label>
  <input type="text" name="locationname" id="textfield">
  </p>
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>