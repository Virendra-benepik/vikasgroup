<?php
include_once('class_connect_db_Communication.php');

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
        $server_name = SITE;
        if ($this->uid == "SubAdmin") {
            $query = 
"SELECT Tbl_C_PostDetails . *, Concat('".SITE_URL."', Tbl_C_PostDetails.post_img ) AS post_img , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (

SELECT COUNT(distinct userUniqueId) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as ViewPostCount, (

SELECT COUNT(*) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as TotalCount

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
        } 
		else {
            $query = "SELECT Tbl_C_PostDetails . *, Concat('".SITE_URL."', Tbl_C_PostDetails.post_img ) AS post_img , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (

SELECT COUNT(distinct userUniqueId) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as ViewPostCount, (

SELECT COUNT(*) 
FROM Tbl_Analytic_PostView
WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id
) as TotalCount

FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 9 and Tbl_C_PostDetails.clientId = :cli and Tbl_C_PostDetails.userUniqueId =:eid1 order by Tbl_C_PostDetails.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->execute(array('cli' => $this->cid,'eid1'=>$this->eid));
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

    function getAllCEOMessageFORandroid($clientid, $val) {
        $this->idclient = $clientid;
        $this->value = $val;
//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";
        try {
            $server_name = dirname(SITE_URL)."/";
            $query = "select *,if(thumb_post_img IS NULL or thumb_post_img = '',Concat('" . $server_name . "', post_img), Concat('" . $server_name . "', thumb_post_img)) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 9 order by auto_id desc limit " . $this->value . " , 5";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if (count($rows) > 0) {

                $query1 = "select count(post_id) as totals from Tbl_C_PostDetails where clientId=:cli and flagCheck = 9";
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt1->execute();
                $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["totals"] = $rows1[0]["totals"];
                $response["posts"] = $rows;
                /*
                  foreach($rows as $row)
                  {
                  $post["autoId"] = $row["autoId"];
                  $post["clientId"] = $row["clientId"];
                  $post["post_id"] = $row["post_id"];
                  $post["noticeTitle"] = $row["noticeTitle"];
                  $post["fileName"] = $path.$row["fileName"];
                  $post["location"] = $row["location"];
                  $post["createdBy"] = $row["createdBy"];
                  $post["createdDate"] = $row["createdDate"];
                  $post["status"] = $row["status"];
                  $post["publishingTime"] = $row["publishingTime"];
                  $post["unpublishingTime"] = $row["unpublishingTime"];
                  array_push($response["posts"],$post);
                  } */

                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No More Posts Available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            //  echo $e;
            $response["success"] = 0;
            $response["message"] = "client id or initial value is incorrect".$e;
            return json_encode($response);
        }

        //$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //	 return json_encode($rows);
    }

    function getSinglePost($postid, $clientid) {
        $this->id = $postid;
        $this->cli = $clientid;
        $server_name = SITE;
        $query = "select *, DATE_FORMAT(created_date,'%d %b %Y') as created_date , Concat('" . $server_name . "',post_img) as post_img  from Tbl_C_PostDetails where post_id =:pid and clientId=:cli";
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

    function updateNoticeStatus($pid, $sta) {
        $this->noticeid = $pid;
        $this->status = $sta;

        $query = "update NoticeDetails set status=:sta where noticeId =:pid";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->noticeid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response[success] = 1;
                $response[message] = "Successfully notice status changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function deleteNotice($nid) {
        $this->noticeid = $nid;

        $query = "delete from NoticeDetails where noticeId =:nid";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':nid', $this->noticeid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response[success] = 1;
                $response[message] = "Successfully notice deleted";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>