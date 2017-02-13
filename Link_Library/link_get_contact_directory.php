<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../Class_Library/class_contact_directory.php');
if(!empty($_POST))
{ 

$cid = $_POST['cid'];
//$location = $_POST['location'];


 $dept_obj = new ContactPerson();  // create object of class cl_module.php
 $result =  $dept_obj->clientContactDetails($cid);
print_r($result);
 /*$res = json_decode($result,true);
 print_r($res);
 
 if($res['success'] == 1)
 {
 echo "<script>alert('".$res['msg']."')</script>";
 echo "<script>window.location='../add_contact_directory.php?id=$cid&name=$cname'</script>";
 }*/
	
}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id:
    <label for="textfield"></label>
  <input type="text" name="cid" id="textfield">
  </p>
 
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>