<?php
require_once('../Class_Library/class_user_update.php');
if(!empty($_POST))
{ 
$cid = $_POST['searchdata'];
echo $cid; 
$search_obj = new User();  // create object of class cl_module.php
$result =  $search_obj->userForm($cid);
//print_r($result);
echo $result;
}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id:
    <label for="textfield"></label>
  <input type="text" name="searchdata" id="textfield">
  </p>
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>