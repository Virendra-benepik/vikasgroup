<?php
require_once('../Class_Library/class_get_useridbygroupid.php');
$push = new PushNotification1(); 
if(!empty($_POST))
{

$cid=$_POST['cid'];
echo "clientId ".$cid."<br>";
$User_Type = $_POST['user3'];

echo "user type".$User_Type."<br>";
	if($User_Type == 'Selected')
	{
	$user1 = $_POST['selected_user'];
	$user2 = rtrim($user1,',');
        $myArray = explode(',', $user2);
     echo "selected user"."<br/>";
     echo "<pre>";
        print_r($myArray)."<br/>";
        echo "</pre>";
        }
        else
        {
       echo "all user"."<br/>";
        $User_Type = "Selected";
        echo "user type:-".$User_Type;
        $user1 = $_POST['all_user'];
	$user2 = rtrim($user1,',');
        $myArray = explode(',', $user2);
         echo "<pre>";
        print_r($myArray)."<br/>";
        echo "</pre>";
        }

$gcm_value = $push->get_Employee_details($User_Type,$myArray,$cid);
$token = json_decode($gcm_value, true);
echo "hello user  id";
echo "<pre>";
print_r($token);
echo "</pre>";
}
else
{
?>
<form method="post" action= "link_getuseridbygroupid.php">
<p>
client id:
<input type="text" name="cid">
</p>

<p>
ussertype(ALL/Selected):
<input type="text" name="user3" value="Selected">
</p>

<p>
groupiD seprated by ,
<input type="text" name="selected_user">
</p>
<p><input type="submit" name="btn"></p>
</form>

<?php
}
?>