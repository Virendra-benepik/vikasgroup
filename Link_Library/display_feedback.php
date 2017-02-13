<?php
require_once('../Class_Library/class_feedback.php');

if(!empty($_POST))
{ 
$obj = new Feedback();

extract($_POST);
$result = $obj->getallfeedback($feedbackid,$startdate,$enddate);
print_r($result);
}
else
{
?>
<form name="form1" method="post" action="display_feedback.php" enctype="multipart/form-data">
  
  <p>Feedback ID:
    <label for="textfield"></label>
  <input type="text" name="feedbackid" id="textfield">
  </p>
  <p>Start date:
    <label for="textfield"></label>
  <input type="date" name="startdate" id="textfield">
  </p>
  <p>End Date:
    <label for="textfield"></label>
  <input type="date" name="enddate" id="textfield">
  </p>
  <p>
  <input type="submit" name="submit" id="button" value="Publish">
  </p>
</form>
<?php
}
?>