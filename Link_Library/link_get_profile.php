<?php
require_once('../Class_Library/class_user_profile.php');

if(!empty($_POST))
{ 
$obj = new Profile();

extract($_POST);
$result = $obj->getuserprofile($client_id,$userid);
print_r($result);
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  
  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="client_id" id="client_id">
  </p>

   <p>User id:
    <label for="textfield"></label>
    <textarea name="userid" id="userid"></textarea>
  </p>
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>