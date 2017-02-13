<?php
require_once('../Class_Library/class_complaints.php');
if(!empty($_POST))
{ 

$client_id = $_POST['cid'];
$dept_obj = new Complaint();  // create object of class cl_module.php
 $result =  $dept_obj->getSuggestion($client_id);
echo $result;
}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id:
    <label for="textfield"></label>
  <input type="text" name="cid" id="textfield">
  </p>
  
 <!--  <p>device id: 
    <label for="textfield2"></label>
    <input type="text" name="device" id="textfield2" value="">
  </p> -->

  
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>