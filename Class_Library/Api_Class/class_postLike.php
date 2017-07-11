<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

class Like {

    public $DB;
    public $db_connect;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function create_Like($clientid, $pid, $likby, $flag, $device,$deviceId) {
        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_PostLike(clientId,postId,likeBy,likeDate,flagType,device,deviceId)
             values(:cli,:pt,:li,:cd,:flag,:device,:did)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $pid, PDO::PARAM_STR);
            $stmt->bindParam(':li', $likby, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
            $stmt->bindParam(':did', $deviceId, PDO::PARAM_STR);
            if ($stmt->execute()) {

                $query2 = "select count(postId) as total_likes from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli";
                $stmt2 = $this->DB->prepare($query2);
                $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt2->bindParam(':pi', $pid, PDO::PARAM_STR);
                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                $response["success"] = 1;
                $response["message"] = "You have liked this post successfully";
                $response['total_likes'] = $row2['total_likes'];
                $response["post"] = self::totallikes($clientid, $pid);
                return $response;
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "You already liked this post";
            return $response;
        }
    }

    /*     * **************************************************************************************** */

    function totallikes($clientid, $pid) {
        try {
            $query = "select count(likeBy) as total_likes from Tbl_Analytic_PostLike where clientId=:cli and postId=:pt";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $pid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                $response["success"] = 1;
                $response["message"] = "like here";
                $response["total_likes"] = $row["total_likes"];
                $response["postId"] = $pid;
            } else {
                $response["success"] = 0;
                $response["message"] = "No like here";
            }
            return $response;
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "No like";
            return $response;
        }
    }

    function getTotalLikeANDcomment($client, $postid, $FLAG) {
        $path = site_url;
        try {
            $query = "select *,DATE_FORMAT(likeDate,'%d %b %Y %h:%i %p') as likeDate from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli and flagType=:flag";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $client, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $FLAG, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {

                $response["Success"] = 1;
                $response["Message"] = "Like data display here";
                $response["Posts"] = array();

                foreach ($rows as $row) {
                    $post["postId"] = $row["postId"];
                    $post["uuid"] = $row["likeBy"];
                    $employeeid = $row["likeBy"];


                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post["name"] = $rows["firstName"];
                    $post["userImage"] = ($rows["userImage"] == "")?"":$path . $rows["userImage"];
                    $post["likeDate"] = $row["likeDate"];
                    $post["clientId"] = $row["clientId"];
                    array_push($response["Posts"], $post);
                }
            } else {
                $response["Success"] = 0;
                $response["Message"] = "There is no display like";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>