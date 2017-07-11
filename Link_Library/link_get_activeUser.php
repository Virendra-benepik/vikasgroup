<?php
require_once('../Class_Library/class_appAnalytic.php');
if(!empty($_POST))
{ 

extract($_POST);
$df = $_POST["datefrom"];
$dt = $_POST["dateto"];

$dept_obj = new AppAnalytic();  // create object of class cl_module.php
 $result =  $dept_obj->getActiveUser($df,$dt);
 $drt = json_decode($result, true);
 echo "<pre>";
 print_r($drt);
echo $result;

}
else
{
?>
<form name="form1" method="post" action="">
  <p>date from:
    <label for="textfield"></label>
    <input type="datetime" name="datefrom" id="textfield">
  </p>
  
   <p>date to: 
    <label for="textfield2"></label>
    <input type="datetime" name="dateto" id="textfield2" value="">
  </p> 

  
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>