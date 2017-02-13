<?php
 @session_start();
require_once('../Class_Library/class_fetch_group.php');
$obj = new GetGroup();
if (!empty($_POST))
{
$k = rtrim("Group111,Group110,",',');
 $k1 = explode(',',$k);
 print_r($k1);
 $u_type = $_SESSION['user_type'];          
   echo $u_type."<br/>";
  $val = $obj->getSingleGroup($k1);               
}

else 
{
?>
    <h1>Store Deals</h1> 
    <form action="link_fetch_group.php" method="POST"> 
                    TEXT value<br>
		    <input type="text" name="textvalue" id="textvalue"/><br>
		    <input type="submit" value="Get Car Details" /> 
		</form> 
		
	<?php
}

?>