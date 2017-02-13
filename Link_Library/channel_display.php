<?php
require_once('../Class_Library/class_channel.php');

if(!empty($_POST))
{ 
$obj = new Channel();

extract($_POST);

$result = $obj->Channel_Users($client_id);
print_r($result);
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  
  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="client_id" id="textfield">
  </p>

  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>