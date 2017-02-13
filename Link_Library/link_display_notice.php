<?php
require_once('../Class_Library/class_notice.php');
if(!empty($_POST))
{ 
$obj1 = new Notice();

$id_client = $_POST['clientid'];
$result = $obj1->displayNotice($id_client);
print_r($result);

}				
else
{
?>

<form name="form1" method="post" action="" enctype="multipart/form-data">
 
  <p> client id:
    <label for="textfield"></label>
  <input type="text" name="clientid" id="textfield">
  </p>


  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>
