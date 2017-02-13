<?php
require_once('../Class_Library/class_client_location.php');
if(!empty($_POST))
{ 
$cid = $_POST['clientid'];
$cname = $_POST['client_name'];

$location = $_POST['contact_location'];

$location_obj = new ContactLocation();  // create object of class cl_module.php
$result =  $location_obj->createLocation($cid,$location);

 /*$res = json_decode($result,true);

 if($res['success'] == 1)
 {
 echo "<script>alert('".$res['msg']."')</script>";
 echo "<script>window.location='../create_contact_directory.php'</script>";
 }*/
	
}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="textfield">
  </p>
  <p>location: 
    <label for="textfield2"></label>
    <input type="text" name="contact_location" id="textfield2">
  </p>
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>