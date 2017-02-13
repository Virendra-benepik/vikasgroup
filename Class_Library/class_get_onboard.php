<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}
require_once('class_get_useruniqueid.php');

class GetWelcomeOnboard {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $cid;
    public $eid;
    public $uid;

    function getAllOnboard($cid, $eid, $usertype) {
        $this->cid = $cid;
        $this->eid = $eid;
        $this->uid = $usertype;

        $site_url = SITE;
        if ($this->uid == "SubAdmin") {
            // $query = "select *, Concat('$site_url', post_img) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 12 and created_by = :cb order by auto_id desc";

            $query = "select TCPD.*,Concat('$site_url', TCPD.post_img) as post_img, DATE_FORMAT(TCPD.created_date,'%d %b %Y') as created_date,
                           (SELECT COUNT(distinct userUniqueId) 
                            FROM Tbl_Analytic_PostView
                            WHERE Tbl_Analytic_PostView.post_id = TCPD.post_id
                            ) as Unique_View, 
                            (SELECT COUNT(*) 
                            FROM Tbl_Analytic_PostView
                            WHERE Tbl_Analytic_PostView.post_id = TCPD.post_id
                            ) as Total_View
                            from Tbl_C_PostDetails as TCPD
                            where TCPD.clientId=:cli and TCPD.flagCheck = 12 and TCPD.created_by =:cb order by TCPD.auto_id desc";

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
            //$query = "select *,Concat('$site_url', post_img) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 12 order by auto_id desc";

            $query = "select TCPD.*,Concat('$site_url', TCPD.post_img) as post_img, DATE_FORMAT(TCPD.created_date,'%d %b %Y') as created_date,
                           (SELECT COUNT(distinct userUniqueId) 
                           FROM Tbl_Analytic_PostView
                           WHERE Tbl_Analytic_PostView.post_id = TCPD.post_id
                           ) as Unique_View, 
                           (SELECT COUNT(*) 
                           FROM Tbl_Analytic_PostView
                           WHERE Tbl_Analytic_PostView.post_id = TCPD.post_id
                           ) as Total_View
                           from Tbl_C_PostDetails as TCPD
                           where TCPD.clientId=:cli and TCPD.flagCheck = 12 order by TCPD.auto_id desc";


            try {
                $stmt = $this->DB->prepare($query);
                $stmt->execute(array('cli' => $this->cid));
            } catch (PDOException $e) {
                echo $e;
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $response = array();
            $response["success"] = 1;
            $response["message"] = "data fetched successfully";
            $response["posts"] = $rows;
        }

        return json_encode($response);
    }

    /*     * ********************************Get Data for android **************************************************** */

    function getAllOnboardFORandroid($clientid, $val) {
        $this->idclient = $clientid;
        $this->value = $val;
        $site_url = dirname(SITE_URL)."/";
//        echo $site_url;die;
        try {
            $query = "select *,if(post_img IS NULL OR post_img = '','', Concat('$site_url', post_img)) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 12 order by auto_id desc ";
//                    . "limit " . $this->value . " , 5";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if (count($rows) > 0) {


                $query1 = "select count(post_id) as totals from Tbl_C_PostDetails where clientId=:cli and flagCheck = 12";
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
            echo $e;
            $response["success"] = 0;
            $response["message"] = "client id or initial value is incorrect";
            return json_encode($response);
        }

        //$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //	 return json_encode($rows);
    }

    function getSingleOnboard($postid, $clientid) {
        $this->id = $postid;
        $this->cli = $clientid;
        $site_url = SITE;
      echo "this iss site url".$site_url;
        $query = "select post.*, DATE_FORMAT(post.created_date,'%d %b %Y') as created_date , if(post.thumb_post_img IS NULL or post.thumb_post_img='' , CONCAT('" . $site_url . "',post.post_img), CONCAT('" . $site_url . "',post.thumb_post_img)) as post_img, if(user.userImage IS NULL or user.userImage='','',CONCAT('" . $site_url . "',user.userImage)) as userImage from Tbl_C_PostDetails as post join Tbl_EmployeePersonalDetails as user on post.userUniqueId = user.employeeId where post.post_id =:pid and post.clientId=:cli";
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