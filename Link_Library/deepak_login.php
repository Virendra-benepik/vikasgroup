<?php
require_once('../Class_Library/deepak_class_login.php');

if(!empty($_POST))
{ 
$email = $_POST['email'];
$pass = $_POST['password'];
$clientid ="CO-2";

$db = new ClientLogin();

$result = $db->clientLoginCheck($email,$pass,$clientid);
print_r($result);
}
else
{
?>


<form name="form1" method="post" action="">
 
  <p>email id:
    <label for="textfield"></label>
  <input type="text" name="email" id="textfield">
  </p>
  
 <p>password:
    <label for="textfield"></label>
  <input type="password" name="password" id="textfield"> 
  </p>
 
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>

<?php
}
?>
