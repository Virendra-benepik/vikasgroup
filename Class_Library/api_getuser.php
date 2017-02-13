<?php
include_once('class_connect_db_admin.php');

    $db = new Connection();
      $connect = $db->getConnection();
 

//initial query
if (!empty($_REQUEST['username'])) {


try 
{
   $query5 = "select firstName,lastName,userId from UserDetails order by createdDate desc";
     $query_params5 = array();
    $stmt5   = $connect->prepare($query5);
    $result5 = $stmt5->execute($query_params5);
}
catch (PDOException $ex)
 {
    echo $ex->getTraceAsString();
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response));
}

$rows = $stmt5->fetchAll(PDO::FETCH_ASSOC);
    $response["success"] = 1;
    $response["message"] = "Posts Available";
    $response["posts"] = $rows;
echo $_GET['mm'].'('.json_encode($response).')';

}

else {
?>
    <h1>Login</h1> 
		<form action="api_getuser.php" method="post"> 
		    Username:<br /> 
		    <input type="text" name="username" placeholder="username" /> 
		    <br /><br /> 
		    <input type="submit" value="Login" /> 
		</form> 
		<a href="register.php">Register</a>
	<?php
}


?>