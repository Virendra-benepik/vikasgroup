<?php
require_once('../Class_Library/class_get_group_data.php');
if(!empty($_REQUEST['clientid']))
{ 
$obj = new GetGroupData();

$clientid = $_REQUEST['clientid'];

$result = $obj->getClientDepartment($clientid);
echo $_GET['callback'].'('.$result.')';
//print_r($result);
}
else
{
?>
<form name="form1" method="post" action="">
  
  <p>Client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="clientid">
  </p>
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>