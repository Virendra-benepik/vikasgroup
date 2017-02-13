<?php
require_once('../Class_Library/class_feedback.php');

if(!empty($_POST))
{ 
$obj = new Feedback();
extract($_POST);
$feedbackval = ($feedid == "h1")?10:(($feedid=="s1")?-10:0);
//echo $feedbackval;
$result = $obj->create_Feedback($feedid,$feedbackval,$feedcontent,$feedby);
print_r($result);
}
else
{
?>
<form name="form1" method="post" action="link_send_feedback.php">
  <p>feedback id <b>h1</b> for happy</p>
  <p>feedback id <b>s1</b> for sad</p>
  <p>feedback id <b>a1</b> for average</p>
  <p>-----------------------</p>
  
  <p>Feedback ID:
    <label for="textfield"></label>
  <input type="text" name="feedid" id="textfield">
  </p>
  <p>Feedback message:
    <label for="textfield"></label>
  <input type="text" name="feedcontent" id="textfield">
  </p>
  <p>By(email id):
    <label for="textfield"></label>
  <input type="text" name="feedby" id="textfield">
  </p>

  <p>
  <input type="submit" name="submit" id="button" value="save">
  </p>
</form>
<?php
}
?>