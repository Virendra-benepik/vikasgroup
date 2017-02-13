<?php
require_once('../Class_Library/class_thought.php');

if(!empty($_POST))
{ 
$obj = new ThoughtOfDay();

extract($_POST);

$result = $obj->thoughtDetailsFORandroid($clientid,$value);
print_r($result);
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  
  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="clientid">
  </p>

  <p>value:
    <label for="textfield"></label>
  <input type="text" name="value" id="value">
  </p>

  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>