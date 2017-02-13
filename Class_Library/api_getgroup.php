<?php
include_once('class_connect_db_Communication.php');

if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        //echo json_encode($response);
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

$db = new Connection_Communication();
$connect = $db->getConnection_Communication();

if(!empty($_REQUEST['device'])){
    extract($_REQUEST);
}
else{
    $jsonArr = json_decode(file_get_contents("php://input"), true);
    extract($jsonArr);
}

if (!empty($userid) && !empty($clientid)) {

    $accessibleGroups = "";
    try {
        $query5 = "select gd.*,ga.* from Tbl_ClientGroupDetails as gd join Tbl_ClientGroupAdmin as ga on gd.groupId = ga.groupId 
    where ga.userUniqueId = :gid and gd.clientId=:cid";

        $stmt5 = $connect->prepare($query5);
        $stmt5->bindParam(':gid', $userid, PDO::PARAM_STR);
        $stmt5->bindParam(':cid', $clientid, PDO::PARAM_STR);
        if ($stmt5->execute()) {

            $rows = $stmt5->fetchAll(PDO::FETCH_ASSOC);
           
            if (count($rows) > 0) {
                $response["success"] = 1;
                $response["message"] = "Group Available";
                $response["posts"] = $rows;
            } else {
                $response["success"] = 0    ;
                $response["message"] = "No Group Available";
                $response["posts"] = $rows;
            }
            if (!empty($_REQUEST['device'])) {
                echo $_GET['callback'] . '(' . json_encode($response) . ')';
            } else {
                echo json_encode($response);
            }
        }
    } catch (PDOException $ex) {
        //  echo $ex->getTraceAsString();
        $response["success"] = 0;
        $response["message"] = $ex;
        // die(json_encode($response));
        echo $ex;
    }
} else {
    ?>
    <h1>Login</h1> 
    <form action="api_getgroup.php" method="post"> 
        User unique id:<br /> 
        <input type="text" name="userid" placeholder="user unique id" /> <br/>

        client Id:<br /> 
        <input type="text" name="clientid" placeholder="client id" /> <br/>

        device :<br /> 
        <input type="text" name="device" placeholder="device" value="" /> 
        <br /><br /> 
        <input type="submit" value="Login" /> 

    </form> 
    <a href="register.php">Register</a>
    <?php
}
?>