<?php
require_once('../Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
if(!empty($_POST))
{

$cid=$_POST['cid'];
$uid=$_POST['uid'];
$val = $gt->getUserData($cid,$uid);
  $val1 = json_decode($val,true);
  echo "<pre>";
print_r($val1);
echo "</pre>";
}
else
{
?>
<form method="post" action= "link_get_userdata.php">
<p>
client id:
<input type="text" name="cid">
</p>
<p>
unique id:
<input type="text" name="uid">
</p>
<p><input type="submit" name="btn"></p>

</form>

<?php
}
?>