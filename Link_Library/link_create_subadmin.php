<?php 
@session_start();
require_once('../Class_Library/class_subadmin.php');
if(!empty($_POST))
{
$object = new SubAdmin();

$email = $_POST['sub_admin'];

$user =  $_POST['selected_user'];
$users = rtrim($user,',');
//echo $users;
$by = $_SESSION['user_email'];
$group = explode(',',$users);
$res = $object->createSubAdmin($email,$group,$by);

if($res['success']== 1)
{
echo "<script>window.location='../create_subadmin.php'</script>";
}
}
else
{
?>
<form method="post">
<p>Email id:
  <input type="text" name="subadmin" id="sub_admin">
  </p>
  <p>List of users:
  <input type="text" name="selected_user" id="selected_user">
  </p>
   <p>
  <input type="submit" name="sub" id="sub_admin" value="create sub admin">
  </p>
</form>
<?php
}
?>