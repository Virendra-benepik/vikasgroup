<?php
require_once('../class_library/class_password.php');

if(!empty($_POST))
{ 

$idclient = $_POST['client_id'];
$idmail = $_POST['mail_id'];

$obj = new Password();

$result = $obj->resetPassword($idclient,$idmail);
print_r($result);

/*if($result)
{
echo "<script>alert('car details updated into database')</script>";
}*/
}
else
{
?>
<form name="form1" method="post" action="">
  <p>client id: 
    <label for="textfield2"></label>
    <input type="text" name="client_id" id="textfield2">
  </p>
  <p>Email id: 
    <label for="textfield2"></label>
    <input type="text" name="mail_id" id="textfield2">
  </p>

  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>
