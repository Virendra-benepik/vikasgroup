<?php

//error_reporting(E_ALL); ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class Comment {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $postid;
    public $commentedby;
    public $commentcontent;

    function create_Comment($client, $pid, $comby, $comcon, $flag, $device,$deviceId) {
        $this->clientid = $client;
        $this->postid = $pid;
        $this->commentedby = $comby;
        $this->commentcontent = $comcon;

        date_default_timezone_set('Asia/Calcutta');

        $cd = date('Y-m-d H:i:s');
        $st = "show";

        try {
            $max = "select max(autoid) from Tbl_Analytic_PostComment";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $commentid = "Comment-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }



        try {
            $query = "insert into Tbl_Analytic_PostComment(commentId,clientId,postId,comment,commentBy,commentDate,status,flagType,device,deviceId)
            values(:pid,:cli,:pt,:cc,:pi,:cd,:st,:flag,:device,:did)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $commentid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':cc', $this->commentcontent, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $this->commentedby, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':st', $st, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
              $stmt->bindParam(':did', $deviceId, PDO::PARAM_STR);

            if ($stmt->execute()) {
                try {
                    $query1 = "SELECT * , DATE_FORMAT(commentDate,'%d %b %Y %h:%i %p') as commentDate FROM Tbl_Analytic_PostComment WHERE postId = :pstid order by autoId desc";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':pstid', $this->postid, PDO::PARAM_STR);
                    $stmt1->execute();
                    $rows = $stmt1->fetchAll();

                    $response["posts"] = array();


                    if ($rows) {
                        $forimage = dirname(SITE_URL) . "/";

                        $query1 = "select count(commentId) as total_comments from Tbl_Analytic_PostComment where postId =:pi and clientId=:cli and status='show'";
                        $stmt1 = $this->DB->prepare($query1);
                        $stmt1->bindParam(':cli', $client, PDO::PARAM_STR);
                        $stmt1->bindParam(':pi', $pid, PDO::PARAM_STR);
                        $stmt1->execute();
                        $row = $stmt1->fetch(PDO::FETCH_ASSOC);

                        $query2 = "select count(postId) as total_likes from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli";
                        $stmt2 = $this->DB->prepare($query2);
                        $stmt2->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                        $stmt2->bindParam(':pi', $this->postid, PDO::PARAM_STR);
                        $stmt2->execute();
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);


                        $response["success"] = 1;
                        $response["message"] = "Comment posted successfully";
                        $response["total_comments"] = $row["total_comments"];
                        $response["total_likes"] = $row2["total_likes"];

                        for ($i = 0; $i < count($rows); $i++) {
                            $post = array();

                            $post["comment_id"] = $rows[$i]["commentId"];
                            $post["post_id"] = $rows[$i]["postId"];
                            $post["content"] = $rows[$i]["comment"];
                            $post["commentby"] = $rows[$i]["commentBy"];
                            $mailid = $rows[$i]["commentBy"];

                            $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $row = $stmt2->fetch();

                            $post["firstname"] = $row["firstName"];
                            $post["lastname"] = $row["lastName"];
                            $post["designation"] = $row["designation"];
                            $post["userImage"] = ($row["userImage"]=="")?"":$forimage . $row["userImage"];
                            $post["cdate"] = $rows[$i]["commentDate"];

                            array_push($response["posts"], $post);
                        }

                        return $response;
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "There is no comments for this post";
                        $response["total_likes"] = $row2["total_likes"];
                        return $response;
                    }
                } catch (PDOException $e) {
                    echo $e;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function Comment_display($clientid, $postid, $flag) {
        $path = site_url;
        try {
            $query = "select *,DATE_FORMAT(commentDate,'%d %b %Y %h:%i %p') as commentDate from Tbl_Analytic_PostComment where postId =:pi and clientId=:cli and flagType = :flag and status='show' order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            $query1 = "select count(commentId) as total_comments from Tbl_Analytic_PostComment where postId =:pi and clientId=:cli and flagType =:flag1 and status='show'";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt1->bindParam(':flag1', $flag, PDO::PARAM_STR);
            $stmt1->execute();
            $row = $stmt1->fetch(PDO::FETCH_ASSOC);

            $query2 = "select count(postId) as total_likes from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli and flagType = :flag2";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt2->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt2->bindParam(':flag2', $flag, PDO::PARAM_STR);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($row['total_comments'] > 0 or $row2['total_likes'] > 0) {
                $response["Success"] = 1;
                $response["Message"] = "Comments are display here";
                $response["total_comments"] = $row["total_comments"];
                $response["total_likes"] = $row2["total_likes"];
                $response["Posts"] = array();

                foreach ($rows as $row) {
                    $post["commentId"] = $row["commentId"];
                    $post["commentBy"] = $row["commentBy"];
                    $employeeid = $row["commentBy"];


                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post["name"] = $rows["firstName"] . " " . $rows["lastName"];
                    $post["userImage"] = !empty($rows["userImage"]) ? $path . $rows["userImage"] : "";
                    $post["designation"] = $rows["designation"];
                    $post["comment"] = $row["comment"];
                    $post["commentDate"] = $row["commentDate"];
                    array_push($response["Posts"], $post);
                }
            } else {
                $response["Success"] = 0;
                $response["Message"] = "There is no comment for this post";
                //$response["total_likes"] = $row2["total_likes"];
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getGroups($clientId, $postId, $flagcheck) {

        switch ($flagcheck) {
            /*             * ************************************** news ************************** */
            case 1:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_PostSentToGroup WHERE clientId=:cli and postId=:pId and flagType = 1";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ******************* album *********************** */
            case 11:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_AlbumSentToGroup WHERE clientId=:cli and albumId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ************************************ achiver story ********************* */
            case 16:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_StorySentToGroup WHERE clientId=:cli and storyId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ********************************* event **************************** */
            case 6:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_EventSentToGroup WHERE clientId=:cli and eventId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ************************** poll ************************ */
            case 4:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_PollSentToGroup WHERE clientId=:cli and pollId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ************************** Contributor ************************ */
            case 17:
                try {
                    $query = "SELECT * FROM Tbl_Analytic_PollSentToGroup WHERE clientId=:cli and pollId=:pId and flagType = 17";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
        }
    }

}

?>