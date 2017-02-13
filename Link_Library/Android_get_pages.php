<?php
require_once('../Class_Library/class_getPages.php');

if(!empty($_POST))
{ 
$obj = new GetPages();

extract($_POST);

$result = $obj->getAllpagesFORandroid($clientid,$value);
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

  <p>initial value:
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