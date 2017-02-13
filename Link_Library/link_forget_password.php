<?php
require_once('../Class_Library/class_client_login.php');

if(!empty($_POST))
{ 
$db = new ClientLogin();

$email = $_POST['emailid'];


$result = $db->forgetPassword($email);
$res = json_decode($result, true);

if($res['success'] == '0')
{
echo "<script>alert('Please check  Your Email Id')</script>";
echo "<script>window.location='../index.php'</script>";
}
else 
{
echo "<script>alert('Password has been sent in your eamil id')</script>";
echo "<script>window.location='../index.php'</script>";
}
}
else
{
?>


<form name="form1" method="post" action="">
  <p>email id:
    <label for="textfield"></label>
  <input type="text" name="emailid" id="textfield">
  </p>
  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>

<?php
}
?>
