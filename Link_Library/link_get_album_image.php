<?php
require_once('../Class_Library/class_upload_album.php');

if(!empty($_REQUEST['clientid']))
{ 
$obj = new Album();

extract($_REQUEST);
$result = $obj->getAlbumImage($aid);

if($device=='android')
echo $result;
else
echo $_GET['callback'].'('.$result.')';

}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  
  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="clientid">
  </p>
  <p>album id:
    <label for="textfield"></label>
  <input type="text" name="aid" id="aid">
  </p>
   <p>Device:
    <label for="textfield"></label>
  <input type="text" name="device" id="uuidid">
  </p>
 
  <p>
  <input type="submit" name="submit" id="button" value="send">
  </p>
</form>
<?php
}
?>