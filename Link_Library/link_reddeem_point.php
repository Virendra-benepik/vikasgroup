<?php
require_once('../Class_Library/class_create_redeempoint.php');
$obj = new RedeemPoint();

if(!empty($_REQUEST['client_id']))
{ 
extract($_REQUEST);

$result = $obj->createRedeemPoint($client_id,$userid,$vid,$vname,$vno,$vamount,$balance);
//$result1 = json_decode($result,true);
if($device_id == 'ios' || $device_id == 'IOS')
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
<form name="form1" method="post" action="">
  
   <p>Device id:
    <label for="textfield"></label>
  <input type="text" name="device_id" id="device_id" placeholder="ios or android">
  </p>
  
  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="client_id" id="client_id">
  </p>

   <p>User id:
    <label for="textfield"></label>
    <input type="text" name="userid" id="userid" />
  </p>
   <p>Voucher id:
    <label for="textfield"></label>
    <input type="text" name="vid" id="userid" />
  </p>
   <p>Voucher Name:
    <label for="textfield"></label>
    <input type="text" name="vname" id="userid" />
  </p>
  
   <p>No of Voucher:
    <label for="textfield"></label>
    <input type="text" name="vno" id="userid" />
  </p>
  
   <p>total amount of Voucher:
    <label for="textfield"></label>
    <input type="text" name="vamount" id="userid" />
  </p>
  
   <p>available balance:
    <label for="textfield"></label>
    <input type="text" name="balance" id="userid" />
  </p>
  
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>