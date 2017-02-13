<?php
require_once('../Class_Library/class_channel.php');

if (!empty($_REQUEST['textvalue'])) {

$obj = new Channel();

$char = $_REQUEST['textvalue'];
$result = $obj->getallusers($char);
print_r($result);
}

else 
{
?>
    <h1>Store Deals</h1> 
    <form action="get_users.php" method="POST"> 
                    TEXT value<br>
		    <input type="text" name="textvalue" id="textvalue"/><br>
		    <input type="submit" value="Get Car Details" /> 
		</form> 
		
	<?php
}

?>