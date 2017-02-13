<?php

require_once('class_connect_db_Communication.php');

class Like {

    public $DB;
    public $db_connect;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $postid;
    public $likeby;

    function create_Like($pid, $likby) {
        $this->postid = $pid;
        $this->likeby = $likby;

        date_default_timezone_set('Asia/Calcutta');

        $cd = date("Y-m-d h:i:sa", time());


        try {
            $query = "select * from Tbl_Analytic_PostLike where postId = :pi and likeBy = :ei";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pi', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':ei', $this->likeby, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if ($rows) {

                try {
                    $query1 = "select count(postId) as count from Tbl_Analytic_PostLike where postId = :pi";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':pi', $this->postid, PDO::PARAM_STR);

                    $stmt1->execute();
                } catch (PDOException $e) {
                    echo $e;
                }

                $rows1 = $stmt1->fetch();

                $response = array();

                if ($rows1) {
                    $response["Total_likes"] = $rows1["count"];
                    $response["success"] = 1;
                    $response["message"] = "You already liked this post";
                    return json_encode($response);
                }
            } else {
                $query = "insert into Tbl_Analytic_PostLike(postId,likeBy,likeDate)
             values(:pt,:li,:cd)";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
                $stmt->bindParam(':li', $this->likeby, PDO::PARAM_STR);
                $stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
                if ($stmt->execute()) {

                    try {
                        $query1 = "select count(postId) as count from Tbl_Analytic_PostLike where postId = :pi";
                        $stmt1 = $this->DB->prepare($query1);
                        $stmt1->bindParam(':pi', $this->postid, PDO::PARAM_STR);

                        $stmt1->execute();
                    } catch (PDOException $e) {
                        echo $e;
                    }

                    $rows1 = $stmt1->fetch();

                    $response = array();

                    if ($rows1) {
                        $response["Total_likes"] = $rows1["count"];
                        $response["success"] = 1;
                        $response["message"] = "like post successfully";
                        return json_encode($response);
                    }
                } else {
                    $val = "Data not inserted";
                    return $val;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $postids;

    function like_display($pid) {
        $this->postids = $pid;
        try {
            $query1 = "SELECT *,DATE_FORMAT(likeDate,'%d %b %Y %h:%i %p') as likeDate FROM Tbl_Analytic_PostLike WHERE postId = :pstid";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':pstid', $this->postids, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();
            $count = count($rows);
            $response["posts"] = array();
            $response["total_like"] = $count;
//            print_r($rows);die;
            if ($rows) {
//                $forimage = "http://admin.benepik.com/employee/virendra/benepik_admin/";
                $forimage = SITE_URL;

                $response["success"] = 1;
                $response["message"] = "comments available";

                $i = 0;
                while ($i < count($rows)) {
                    $post = array();

                    $post["post_id"] = $rows[$i]["postId"];

                    $post["likeby"] = $rows[$i]["likeBy"];
                    $mailid = $rows[$i]["likeBy"];

                    $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";

                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                    $stmt2->execute();
                    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

                    //echo'<pre>';print_r($row);
                    $post["firstname"] = $row["firstName"];
                    $post["lastname"] = $row["lastName"];
                    $post["designation"] = $row["designation"];
                    $post["userimage"] = $forimage . $row["userImage"];
                    $post["cdate"] = $rows[$i]["likeDate"];
                    //$posts[] = $post;
                    //echo'<pre>';print_r($posts);

                    array_push($response["posts"], $post);
                    $i++;
                }
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no Like for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $post_id;

    function getlike($postid) {
        $this->post_id = $postid;

        try {
            $query = "SELECT count(Tbl_Analytic_PostLike.postId), Tbl_EmployeeDetails_Master . * , Tbl_EmployeePersonalDetails . * , Tbl_Analytic_PostLike . * 
FROM Tbl_EmployeeDetails_Master
JOIN Tbl_EmployeePersonalDetails ON Tbl_EmployeeDetails_Master.emailId = Tbl_EmployeePersonalDetails.emailId
JOIN Tbl_Analytic_PostLike ON Tbl_EmployeeDetails_Master.emailId = Tbl_Analytic_PostLike.likeBy
WHERE Tbl_Analytic_PostLike.postId =:pi";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pi', $this->post_id, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();

        //return json_encode($rows);
        if ($rows) {
            $rows["success"] = 1;
            $rows["message"] = "like success";
            echo json_encode($rows);
        } else {
            $response["success"] = 0;
            $response["message"] = "no display like";
            echo json_encode($response);
        }
    }

    public $post_ids;

    function getlike1($postid) {
        $this->post_ids = $postid;

        try {
            $query = "select count(postId) as count from Tbl_Analytic_PostLike where postId = :pi";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pi', $this->post_ids, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetch();

        /* if($rows)
          {
          $rows["success"] = 1;
          $rows["message"] = "like success";
          echo json_encode($rows);
          }
          else
          {
          $response["success"] = 0;
          $response["message"] = "no display like";
          echo json_encode($response);
          } */

        try {
            $query1 = "select count(commentId) as count from Tbl_Analytic_PostComment where postId = :pi";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':pi', $this->post_ids, PDO::PARAM_STR);

            $stmt1->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $row = $stmt1->fetch();

        $responses = array();

        if ($row) {

            $posts["result"] = array();
            $posts["success"] = 1;
            $posts["message"] = "total successfull";

            $response["total_likes"] = $rows["count"];
            $response["total_comments"] = $row["count"];

            array_push($posts["result"], $response);
            echo json_encode($posts);
        } else {
            $response["success"] = 0;
            $response["message"] = "no display like";
            echo json_encode($response);
        }
    }

    function getTotalLikeANDcomment($postid) {
        $this->post_ids = $postid;

        try {
            $query = "select count(postId) as count from Tbl_Analytic_PostLike where postId = :pi";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pi', $this->post_ids, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch();
        } catch (PDOException $e) {
            echo $e;
        }
        try {
            $query1 = "select count(commentId) as count from Tbl_Analytic_PostComment where postId = :pi";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':pi', $this->post_ids, PDO::PARAM_STR);
            $stmt1->execute();
            $row = $stmt1->fetch();
        } catch (PDOException $e) {
            echo $e;
        }

        if ($rows["count"] > 0 or $row["count"] > 0) {
            $response = array();

            $response["success"] = 1;
            $response["message"] = "total successfull";
            $response["total_likes"] = $rows["count"];
            $response["total_comments"] = $row["count"];

            $response["details"] = array();


            $query = "select likeBy from Tbl_Analytic_PostLike where postId = :pi";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pi', $this->post_ids, PDO::PARAM_STR);
            $stmt->execute();
            $srow = $stmt->fetchAll();
            if ($srow) {
//                $path = "http://admin.benepik.com/employee/virendra/benepik_admin/";
                $path = SITE_URL;
                foreach ($srow as $row) {

                    $post["likeBy"] = $row["likeBy"];
                    $mail = $row["likeBy"];

                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.emailId = Tbl_EmployeePersonalDetails.emailId where Tbl_EmployeeDetails_Master.emailId=:mal";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':mal', $mail, PDO::PARAM_STR);
                    $stmt->execute();
                    $ssrow = $stmt->fetchAll();

                    $post["userImage"] = $path . $ssrow[0]["userImage"];
                    $post["firstName"] = $ssrow[0]["firstName"];

                    array_push($response["details"], $post);
                }
            }
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "no display like";
            $response["total_likes"] = 0;
            $response["total_comments"] = 0;
            echo json_encode($response);
        }
    }
	
/**************************************** view like **************************************************/

function likeView($postid,$clientid,$flag) {        
        try {
            $query1 = "SELECT *,DATE_FORMAT(likeDate,'%d %b %Y %h:%i %p') as likeDate FROM Tbl_Analytic_PostLike WHERE clientId= :clientid AND postId = :pid And flagType=:flag ";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':clientid', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt1->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();
            $count = count($rows);
            $response["posts"] = array();
            $response["total_like"] = $count;
//            print_r($rows);die;
            if ($rows) {
//                $forimage = "http://admin.benepik.com/employee/virendra/benepik_admin/";
                $forimage = SITE;

                $response["success"] = 1;
                $response["message"] = "Likes available";

                $i = 0;
                while ($i < count($rows)) {
                    $post = array();

                    $post["post_id"] = $rows[$i]["postId"];

                    $post["likeby"] = $rows[$i]["likeBy"];
                    $mailid = $rows[$i]["likeBy"];

                    $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";

                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                    $stmt2->execute();
                    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

                    //echo'<pre>';print_r($row);
                    $post["firstname"] = $row["firstName"];
                    $post["lastname"] = $row["lastName"];
                    $post["designation"] = $row["designation"];
                    //$post["userimage"] = $forimage . $row["userImage"];
                    
					$post["userimage"] = ($row["linkedIn"]=='1'?$row["userImage"]:($row["userImage"]==''?'':$forimage . $row["userImage"]));
					
					$post["cdate"] = $rows[$i]["likeDate"];
                    //$posts[] = $post;
                    //echo'<pre>';print_r($posts);

                    array_push($response["posts"], $post);
                    $i++;
                }
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no Like for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

/******************************** end view like ********************************************************/
	
}

?>