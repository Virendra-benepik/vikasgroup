<?php

include_once('class_connect_db_Communication.php');

class Comment {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $postid;
    public $commentedby;
    public $commentcontent;

    function create_Comment($pid, $comby, $comcon) {
        $this->postid = $pid;
        $this->commentedby = $comby;
        $this->commentcontent = $comcon;

        date_default_timezone_set('Asia/Calcutta');

        $cd = date('d M Y, h:i A');
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
            $query = "insert into Tbl_Analytic_PostComment(commentId,postId,comment,commentBy,commentDate,status)
            values(:pid,:pt,:cc,:pi,:cb,:cd)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $commentid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':cc', $this->commentcontent, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $this->commentedby, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $st, PDO::PARAM_STR);

            if ($stmt->execute()) {
                /* $ft = 'True';
                  return $ft; */
                try {
                    /* $query = "select * from PostComment where postId = :postid"; */
                    $query1 = "SELECT * FROM Tbl_EmployeeDetails_Master INNER JOIN Tbl_Analytic_PostComment ON Tbl_Analytic_PostComment.commentBy = Tbl_EmployeeDetails_Master.emailId
WHERE Tbl_Analytic_PostComment.postId = :pstid";

                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':pstid', $this->postid, PDO::PARAM_STR);
                    $stmt1->execute();
                    $rows = $stmt1->fetchAll();

                    $response["posts"] = array();


                    if ($rows) {

//                        $forimage = "http://admin.benepik.com/employee/virendra/benepik_client/post_img/";
                        $forimage = SITE_URL;

                        $response["success"] = 1;
                        $response["message"] = "comments available";

                        for ($i = 0; $i < count($rows); $i++) {
                            $post = array();
                            $post["firstname"] = $rows[$i]["firstName"];
                            $post["lastname"] = $rows[$i]["lastName"];
                            $post["userimage"] = $forimage . $rows[$i]["userImg"];

                            $post["comment_id"] = $rows[$i]["commentId"];
                            $post["post_id"] = $rows[$i]["postId"];
                            $post["content"] = $rows[$i]["comment"];
                            $post["commentby"] = $rows[$i]["commentBy"];
                            $post["cdate"] = $rows[$i]["commentDate"];
                            $post["designation"] = $rows[$i]["designation"];
                            array_push($response["posts"], $post);
                        }

                        return json_encode($response);
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "There is no comments for this post";
                        return json_encode($response);
                    }
                } catch (PDOException $e) {
                    echo $e;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $postids;

    function Comment_display($pid) {
        $this->postids = $pid;

        try {
            $query1 = "SELECT *,DATE_FORMAT(commentDate,'%d %b %Y %h:%i %p') as commentDate FROM Tbl_Analytic_PostComment WHERE postId = :pstid and status = 'show'";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':pstid', $this->postids, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();

            $response["posts"] = array();


            if ($rows) {
//                $forimage = "http://admin.benepik.com/employee/virendra/benepik_admin/";
                $forimage = SITE_URL;
                
                $response["success"] = 1;
                $response["message"] = "comments available";

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
                    $row = $stmt2->fetchAll();

                    $post["firstname"] = $row[0]["firstName"];
                    $post["lastname"] = $row[0]["lastName"];
                    $post["designation"] = $row[0]["designation"];
                    $post["userimage"] = $forimage . $row[0]["userImage"];
                    $post["cdate"] = $rows[$i]["commentDate"];


                    array_push($response["posts"], $post);
                }

                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no comments for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $post_id;

    function getcommentdetails($p) {
        $this->post_id = $p;

        try {
            /* $query = "select * from PostComment where postId = :postid"; */
            $query = "SELECT * FROM Tbl_EmployeeDetails_Master
INNER JOIN Tbl_Analytic_PostComment ON Tbl_Analytic_PostComment.commentBy = Tbl_EmployeeDetails_Master.emailId
WHERE Tbl_Analytic_PostComment.postId = :postid";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':postid', $this->post_id, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $response["posts"] = array();


            if ($rows) {

//                $forimage = "http://admin.benepik.com/employee/virendra/benepik_client/post_img/";
                $forimage = SITE_URL;

                $response["success"] = 1;
                $response["message"] = "comments available";

                for ($i = 0; $i < count($rows); $i++) {
                    $post = array();
                    $post["firstname"] = $rows[$i]["firstName"];
                    $post["lastname"] = $rows[$i]["lastName"];
                    $post["userimage"] = $forimage . $rows[$i]["userImg"];

                    $post["comment_id"] = $rows[$i]["commentId"];
                    $post["post_id"] = $rows[$i]["postId"];
                    $post["content"] = $rows[$i]["comment"];
                    $post["commentby"] = $rows[$i]["commentBy"];
                    $post["cdate"] = $rows[$i]["commentDate"];
                    $post["designation"] = $rows[$i]["designation"];
                    array_push($response["posts"], $post);
                }

                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no comments for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $commentid;

    function delete_Comment($com) {
        $this->commentid = $com;
        try {
            $query = "delete from Tbl_Analytic_PostComment where commentId = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->commentid, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Comment delete successfully";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $comentid;
    public $comentstatus;

    function status_Comment($com, $coms) {

        $this->comentid = $com;
        $this->comentstatus = $coms;

        $status = "";
        try {
            $query = "update Tbl_Analytic_PostComment set status = :sta where commentId = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->comentid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->comentstatus, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Comment status has changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
/***************************************** view post comment ********************************************/

function CommentView($postid,$clientid,$flag) {
       
        try {
            $query1 = "SELECT *,DATE_FORMAT(commentDate,'%d %b %Y %h:%i %p') as commentDate FROM Tbl_Analytic_PostComment WHERE clientId = :clientid AND postId = :pid and flagType = :flag AND status = 'show'";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':clientid', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt1->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();

            $response["posts"] = array();


            if ($rows) {
//                $forimage = "http://admin.benepik.com/employee/virendra/benepik_admin/";
                $forimage = SITE;
                
                $response["success"] = 1;
                $response["message"] = "comments available";

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
                    $row = $stmt2->fetchAll();

                    $post["firstname"] = $row[0]["firstName"];
                    $post["lastname"] = $row[0]["lastName"];
                    $post["designation"] = $row[0]["designation"];
                    $post["userimage"] = ($row[0]["linkedIn"]=='1'?$row[0]["userImage"]:($row[0]["userImage"]==''?'':$forimage . $row[0]["userImage"])) ;
					$post["cdate"] = $rows[$i]["commentDate"];


                    array_push($response["posts"], $post);
                }

                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no comments for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

/**************************************** end view post comment *****************************************/

}

?>