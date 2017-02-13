<?php
require_once('../Class_Library/class_contact_directory.php');
if(!empty($_POST))
{ 

$cid = $_POST['cpid'];

 $dept1_obj = new ContactPerson();  // create object of class cl_module.php
 $result =  $dept1_obj->deleteContactDirectory($cid);
 echo $result;
//print_r($result);
 /*$res = json_decode($result,true);
 print_r($res);
 
 if($res['success'] == 1)admin/employee/virendra/benepik_admin/lib/link_delete_contact_directory.php
 {
 echo "<script>alert('".$res['msg']."')</script>";
 echo "<script>window.location='../add_contact_directory.php?id=$cid&name=$cname'</script>";
 }*/
	
}
else
{
?>
<form name="form1" method="post" action="">
  <p>contact person id:
    <label for="textfield"></label>
  <input type="text" name="cpid" id="textfield">
  </p>
 
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>