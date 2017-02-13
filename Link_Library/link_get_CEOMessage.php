<?php
require_once('../Class_Library/class_get_ceomessage.php');

if(!empty($_REQUEST['clientid']))
{ 
$obj = new GetCEOMessage();

extract($_REQUEST);

$result = $obj->getAllCEOMessageFORandroid($clientid,$value);


if ($device =="android")
   echo $result;
else
   echo $_GET['callback'].'('.$result.')';


}
else
{
?>
<form name="form1" method="post" action="link_get_CEOMessage.php" enctype="multipart/form-data">
  
  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="clientid">
  </p>

  <p>UUID:
    <label for="textfield"></label>
  <input type="text" name="uid" id="uid">
  </p>

  <p>value:
    <label for="textfield"></label>
  <input type="text" name="value" id="value">
  </p>

  <p>Device:
    <label for="textfield"></label>
  <input type="text" name="device" id="device">
  </p>

  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>