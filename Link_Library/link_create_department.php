<?php
require_once('../Class_Library/class_client_department.php');
if(!empty($_POST))
{ 
$cid = $_POST['cid'];
$location = $_POST['location'];
$dept = $_POST['department'];

$dept_obj = new ContactDepartment();  // create object of class cl_module.php
 $result =  $dept_obj->createDepartment($cid,$location,$dept);
 $res = json_decode($result,true);
 if($res['success'] == 1)
 {
 echo "<script>alert('".$res['msg']."')</script>";
 echo "<script>window.location='../create_contact_directory.php'</script>";
 }
	
}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id:
    <label for="textfield"></label>
  <input type="text" name="cid" id="textfield">
  </p>
  <p>location id: 
    <label for="textfield2"></label>
    <input type="text" name="location" id="textfield2">
  </p>
   <p>department: 
    <label for="textfield2"></label>
    <input type="text" name="department" id="textfield2">
  </p>
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>