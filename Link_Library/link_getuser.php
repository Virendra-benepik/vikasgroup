<?php

require("configurations.php");

require("config.old.php");

//initial query
if (!empty($_REQUEST['username'])) {

  $query4 = "select * from login where email = :email";
     $query_params4 = array(
      ':email' => $_REQUEST["username"]
);

try 
{
    $stmt4   = $db_old->prepare($query4);
    $result4 = $stmt4->execute($query_params4);
}
catch (PDOException $ex)
 {
   
    echo $ex->getTraceAsString();
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response)); 

 }

$row = $stmt4->fetch();

if($row)
{      
  $query5 = "select distinct city_name from merchant_city ";
     $query_params5 = array(
      
);

try 
{
    $stmt5   = $db->prepare($query5);
    $result5 = $stmt5->execute($query_params5);
}
catch (PDOException $ex)
 {
    echo $ex->getTraceAsString();
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response));
}

$rows = $stmt5->fetchAll();
$response["cities"] = array();
if($rows)
foreach($rows as $row)
{
  $post["state"] = $row["city_name"];
  array_push($response["cities"],$post);
}
echo $_GET['mm'].'('.json_encode($response).')';

}

}

else {
?>
    <h1>Login</h1> 
		<form action="locations.php" method="post"> 
		    Username:<br /> 
		    <input type="text" name="username" placeholder="username" /> 
		    <br /><br /> 
		    <input type="submit" value="Login" /> 
		</form> 
		<a href="register.php">Register</a>
	<?php
}


?>