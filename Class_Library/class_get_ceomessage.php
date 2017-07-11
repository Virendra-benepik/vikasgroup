<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
if (!class_exists("Connection_Communication")) {
    require_once('class_connect_db_Communication.php');
}
include_once('Api_Class/class_find_groupid.php');

class GetCEOMessage {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $cid;
    public $eid;
    public $uid;

    function getAllCEOMessage($cid, $eid, $usertype) {
        $this->cid = $cid;
        $this->eid = $eid;
        $this->uid = $usertype;
        //$server_name = SITE_URL;
		$server_name = SITE;


        if ($this->uid == "SubAdmin") {
            $query = "SELECT Tbl_C_PostDetails . *, if(Tbl_C_PostDetails.post_img IS NULL or Tbl_C_PostDetails.post_img = '', '', Concat('" . SITE . "', Tbl_C_PostDetails.post_img )) AS post_img , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (

SELECT COUNT(distinct userUniqueId) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as ViewPostCount, (

SELECT COUNT(*) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as TotalCount,(

SELECT COUNT( * ) 
FROM Tbl_Analytic_PostComment
WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id
) as commentCount, (

SELECT COUNT( * ) 
FROM Tbl_Analytic_PostLike
WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id
) as likeCount 

FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 9 and Tbl_C_PostDetails.clientId = :cli and Tbl_C_PostDetails.userUniqueId =:cb order by Tbl_C_PostDetails.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->execute(array('cli' => $this->cid, 'cb' => $this->eid));
            } catch (PDOException $e) {
                echo $e;
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //$response=array();
            $response["success"] = 1;
            $response["message"] = "data fetched successfully";
            $response["posts"] = $rows;
        } else {
            $query = "SELECT Tbl_C_PostDetails . *,if(Tbl_C_PostDetails.post_img IS NULL or Tbl_C_PostDetails.post_img = '', '', Concat('" . SITE . "', Tbl_C_PostDetails.post_img )) AS post_img , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (

SELECT COUNT(distinct userUniqueId) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as ViewPostCount, (

SELECT COUNT(*) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as TotalCount, (

SELECT COUNT( * ) 
FROM Tbl_Analytic_PostComment
WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id
) as commentCount, (

SELECT COUNT( * ) 
FROM Tbl_Analytic_PostLike
WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id
) as likeCount 

FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 9 and Tbl_C_PostDetails.clientId = :cli order by Tbl_C_PostDetails.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->execute(array('cli' => $this->cid));
            } catch (PDOException $e) {
                echo $e;
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //  $response=array();
            $response["success"] = 1;
            $response["message"] = "data fetched successfully";
            $response["posts"] = $rows;
        }

        return json_encode($response);
    }

    /*     * ********************** get all   use lesss************************************** */

    function getStatusOfNo($pub, $unpub) {

        $pub1 = substr($pub, 0, 18);
        $pub2 = $pub1 . "00";

        $unpub1 = substr($unpub, 0, 18);
        $unpub2 = $unpub1 . "00";

        date_default_timezone_set("Asia/Kolkata");
        $dat1 = date("d-m-Y h:i:s");
        $dat = strtotime($dat1);
        echo "Created Date in seconds:- " . $dat;
        echo "<br>";
        $pubDat = strtotime($pub2);
        echo "<br>" . $pub2 . "  Publishing Time:- " . $pubDat;
        $unpubDat = strtotime($unpub2);
        echo "<br>" . $unpub2 . "  Unpublishing Time:- " . $unpubDat;
        echo "<br><br>";


        if (($dat >= $pubDat) && ($dat <= $unpubDat)) {
            echo "Live Notice";
        } else if ($dat < $pubDat) {
            echo "Have a time for publishing Notice";
        } else {
            echo "Expire Notice";
        }
    }

    /*     * ********************************Get Data for android **************************************************** */

    function getAllCEOMessageFORandroid($clientid, $uid, $val) {
        $this->idclient = $clientid;
        $this->value = $val;

        $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
        $stmt = $this->DB->prepare($query);
        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
        $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {

            $uuids = $rows[0]['employeeId'];

            $group_object = new FindGroup();    // this is object to find group id of given unique id 
            $getgroup = $group_object->groupBaseofUid($clientid, $uuids);
            $value = json_decode($getgroup, true);
            if (count($value['groups']) > 0) {
                $in = implode("', '", array_unique($value['groups']));
                try {
                    
                    $query2 = "select count(distinct(postId)) as total_posts from Tbl_Analytic_PostSentToGroup where clientId=:cli and status = 1 and flagType = 9 and groupId IN('" . $in . "')";

                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    // $stmt2->bindParam(':uid',$uuids, PDO::PARAM_STR);
                    $stmt2->execute();
                    $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    
                   
                    $query1 = "select distinct(postId) from Tbl_Analytic_PostSentToGroup where clientId=:cli and status = 1 and groupId IN('" . $in . "') and flagType = 9 order by autoId desc limit " . $this->value . ",5";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    //  $stmt1->bindParam(':uid',$uuids, PDO::PARAM_STR);
                    $stmt1->execute();
                    $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
if(count($rows1)>0)
{
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Leadership message available for you";

                    

                    $response["total_posts"] = $rows2["total_posts"];
                    $response["posts"] = array();

                    if ($rows1) {
                        foreach ($rows1 as $row) {
                            $post["postId"] = $row["postId"];
                            $postid = $row["postId"];

                            try {
                                $server_name = dirname(SITE_URL) . "/";
                                $query = "select *,if(post_img IS NULL or post_img = '', '',Concat('" . $server_name . "', post_img)) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 9 and status = 'Publish' and post_id=:postId";
                                $stmt = $this->DB->prepare($query);
                                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                $stmt->bindParam(':postId', $postid, PDO::PARAM_STR);
                                $stmt->execute();
                                $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                                array_push($response["posts"], $rows);
                            } catch (PDOException $e) {
                                $response["success"] = 0;
                                $response["message"] = "client id or initial value is incorrect" . $e;
                            }
                        }
                        return json_encode($response);
                    }
                }
                else
                {
                               $response["success"] = 0;
                                $response["message"] = "No More Post Available";
                                 $response["total_posts"] = $rows2["total_posts"];
                                 $response["posts"] = array();
                                
                }
                } catch (PDOException $e) {
                    echo $e;
                }
            }
        }
 else {
             $response["success"] = 0;
                                $response["message"] = "client id or initial value is incorrect";
        }

 return json_encode($response);
    }

    function getSinglePost($postid, $clientid) {
        $this->id = $postid;
        $this->cli = $clientid;
        $server_name = SITE;
        $query = "select *, DATE_FORMAT(created_date,'%d %b %Y') as created_date , if(post_img IS NULL or post_img = '', '',Concat('" . $server_name . "',post_img)) as post_img from Tbl_C_PostDetails where post_id =:pid and clientId=:cli";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->cli, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($rows);
        } catch (PDOException $e) {
            echo $e;
        }
    }
}

?>