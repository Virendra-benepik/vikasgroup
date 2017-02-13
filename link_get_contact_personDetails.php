<?php
require_once('Class_Library/class_contact_directory.php');
if(!empty($_POST))
{
$dept_obj = new ContactPerson();  // create object of class cl_module.php

extract($_POST);

$result =  $dept_obj->clientContactPersonDetails($cpid,$clientid);
echo $result;

}
else
{
?>
<form name="form1" method="post" action="">

  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="textfield">
  </p>
  <p>Contact id:
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