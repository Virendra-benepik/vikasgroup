<?php
require_once('../Class_Library/class_get_group.php');
if(!empty($_REQUEST['clientid']))
{ 

$obj = new Group();

$clientid =$_REQUEST["clientid"];
$groupid = $_REQUEST["groupid"];

$result = $obj->GrgetGroupDetails($clientid,$groupid);
echo $_GET['callback'].'('.$result.')';

}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">

<p>Client id:
  <label for="textfield"></label>
  <input type="text" name="clientid" id="textfield">
  </p>
<p>Group id:
  <label for="textfield"></label>
  <input type="text" name="groupid" id="textfield">
  </p>
  
   <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>