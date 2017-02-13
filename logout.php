<?php 
session_start();
require_once('Class_Library/class_client_login.php');

$db = new ClientLogin();
$result = $db->logout();
//echo $result;
if($result)
{
echo "<script>alert('You are successfully logout')</script>";
echo "<script>window.location='index.php'</script>";

//$db->redirect('../index.php');
//header('Location:index.php');
}

?>