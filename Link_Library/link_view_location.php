<?php
require_once('../Class_Library/class_client_location.php');
if(!empty($_POST))
{ 
$cid = $_POST['clientid'];

$location_obj = new ContactLocation();  // create object of class cl_module.php
$result =  $location_obj->viewLocation($cid);
//print_r($result);
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
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>