<?php
require_once('../Class_Library/class_get_recognition_user_account.php');
$obj = new RecognizeUserAccount();

if(!empty($_REQUEST['client_id']))
{ 
extract($_REQUEST);
$result = $obj->getUserAccountBalance($client_id,$userid);
//$result1 = json_decode($result,true);

if($device_id == 'ios'|| $device_id == 'Ios')
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
<form name="form1" method="post" action="link_get_account_balance.php">
  
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
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>