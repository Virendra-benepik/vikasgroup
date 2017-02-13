<?php
require_once('../Class_Library/class_disable_coupon.php');

if(!empty($_POST))
{ 
$obj = new Coupon();
extract($_POST);
$result = $obj->disableCoupon($dealid,$coupon);
if($device == "ios")
{
 echo $_GET['callback'].'('.$result.')';
}
else
{
echo $result;
}
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  
  <p>Deal id:
    <label for="textfield"></label>
  <input type="text" name="dealid" id="clientid">
  </p>
  <p>Coupon Code:
    <label for="textfield"></label>
  <input type="text" name="coupon" id="clientid">
  </p>
  <p>Device:
    <label for="textfield"></label>
  <input type="text" name="device" id="device" placeholder = 'ios/android'>
  </p>
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>