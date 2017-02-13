<?php

include_once('class_connect_db_Communication.php');

class GetPost {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $postid;
    public $clientid;
    public $useruniqueid;
    public $usertype;

    // public $pdate;
    // public $author;

    function getAllNews($clientid, $user_uniqueid, $user_type) {
        $this->clientid = $clientid;
        $this->useruniqueid = $user_uniqueid;
        $this->usertype = $user_type;

        if ($user_type == "SubAdmin") {

            $query = "
            SELECT Tbl_C_PostDetails . * , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostComment.flagType = 1
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostLike.flagType = 1
            ) as likeCount , (

            SELECT COUNT(distinct userUniqueId) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostView.flagType = 1
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostView.flagType = 1
            ) as TotalCount

            FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 1 and Tbl_C_PostDetails.clientId = :cli and Tbl_C_PostDetails.userUniqueId =:eid1 order by Tbl_C_PostDetails.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                $stmt->bindParam(':eid1', $this->useruniqueid, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            $query = "SELECT Tbl_C_PostDetails . * , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (
            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostComment.flagType = 1
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostLike.flagType = 1
            ) as likeCount , (

            SELECT COUNT(distinct userUniqueId) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostView.flagType = 1
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostView.flagType = 1
            ) as TotalCount

            FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 1 and Tbl_C_PostDetails.clientId =:cli order by Tbl_C_PostDetails.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    /*     * ***********************************************  getting message start from here ************************** */

    function getAllMessage($clientid, $user_uniqueid, $user_type) {

        $this->clientid = $clientid;
        $this->useruniqueid = $user_uniqueid;
        $this->usertype = $user_type;

        if ($user_type == "SubAdmin") {

            $query = "
            SELECT Tbl_C_PostDetails . * , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date ,(

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id
            ) as likeCount , (

            SELECT COUNT(distinct email_id) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as TotalCount

            FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 2 and Tbl_C_PostDetails.clientId = '$this->clientid' and Tbl_C_PostDetails.userUniqueId ='$this->useruniqueid' order by Tbl_C_PostDetails.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                $stmt->bindParam(':eid1', $this->useruniqueid, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            $query = "SELECT Tbl_C_PostDetails . * , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (
            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id
            ) as likeCount , (

            SELECT COUNT(distinct email_id) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as TotalCount

            FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 2 and Tbl_C_PostDetails.clientId =:cli order by Tbl_C_PostDetails.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        }

        $rows = $stmt->fetchAll();

        return json_encode($rows);
    }

    /*     * ***************************************** getting picture  start from here ********************** */

    function getAllPicture($clientid, $user_uniqueid, $user_type) {

        $this->clientid = $clientid;
        $this->useruniqueid = $user_uniqueid;
        $this->usertype = $user_type;
        if ($user_type == "SubAdmin") {
            $query = "
            SELECT Tbl_C_PostDetails . * , DATE_FORMAT(PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id
            ) as likeCount , (

            SELECT COUNT(distinct email_id) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as TotalCount

            FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 3 and Tbl_C_PostDetails.clientId = :cli and Tbl_C_PostDetails.userUniqueId =:eid1 order by Tbl_C_PostDetails.auto_id desc";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                $stmt->bindParam(':eid1', $this->useruniqueid, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            $query = "SELECT Tbl_C_PostDetails . * , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (
            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id
            ) as likeCount , (

            SELECT COUNT(distinct email_id) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
            ) as TotalCount

            FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 3 and Tbl_C_PostDetails.clientId =:cli order by Tbl_C_PostDetails.auto_id desc";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        }
        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /* --------------------------------these for index page client communication module --------------------------------- */

    function getIndexPost() {
        $query = "select * , DATE_FORMAT(PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date  from Tbl_C_PostDetails where flagCheck = 1 order by created_date desc limit 0,3";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    public $id;

    function getSinglePost($k) {
        $this->id = $k;
        $query = "select *, DATE_FORMAT(created_date,'%d %b %Y %h:%i %p') as created_date  from Tbl_C_PostDetails where flagCheck = 1 and post_id ='" . $this->id . "'";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    public $pstid;

    function View_Post_count($com) {
        $this->pstid = $com;

        try {
            $query = "SELECT count(post_id) FROM  Tbl_Analytic_PostView WHERE post_id =:comm";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->pstid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll();
            if ($row) {
                return json_encode($row);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>