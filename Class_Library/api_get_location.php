<?php
session_start();
include_once('class_connect_db_admin.php');

    $db = new Connection();
      $connect = $db->getConnection();
 

//initial query
if (!empty($_REQUEST['username'])) {
$cid = $_SESSION['client_id'];

try 
{
   $query5 = "select distinct(location) from UserDetails where clientId =:cid1 order by createdDate desc";
    // $query_params5 = array();
    $stmt5   = $connect->prepare($query5);
    $stmt5->bindParam(':cid1',$cid,PDO::PARAM_STR);
    $result5 = $stmt5->execute();
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
		<form action="api_get_location.php" method="post"> 
		    Username:<br /> 
		    <input type="text" name="username" placeholder="username" /> 
		    <br /><br /> 
		    <input type="submit" value="Login" /> 
		</form> 
		<a href="register.php">Register</a>
	<?php
}


?>