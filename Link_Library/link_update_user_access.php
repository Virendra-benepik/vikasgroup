<?php
require_once('../Class_Library/class_update_user.php');
//$user_id = $_GET['user_id'];
//$user_status = $_GET['user_status'];
if(!empty($_POST))
{ 
$obj = new UserUpdate();

extract($_POST);
//echo "<script>alert('".$user_id."')</script>";
//echo "<script>alert('".$user_status."')</script>";
$result = $obj->userAccess($user_id,$user_status);
print_r($result);

}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">

  
<p>User id:
  <label for="textfield"></label>
  <input type="text" name="user_id" id="textfield">
  </p>
<p>Accessibility:
  <label for="textfield"></label>
  <input type="text" name="user_status" id="textfield">
  </p>
  
   <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>