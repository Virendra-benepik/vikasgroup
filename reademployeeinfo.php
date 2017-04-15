<?php
require_once('Class_Library/class_training.php');
if(!empty($_REQUEST['searchid']))
{ 
$obj = new Training();

$clientid = "CO-27";
$keyword = $_REQUEST['searchid'];
$result = $obj->employeeinfo($clientid,$keyword);
//echo $result;
echo $_GET['callback'].'('.$result.')';
//$result1 = json_decode($result);
//echo "<pre>";
//print_r($result1);
//echo "</pre>";
}
else
{
?>
<form name="form1" method="post" action="">
  
  <p>search id:
    <label for="textfield"></label>
  <input type="text" name="searchid" id="searchid">
  </p>
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>