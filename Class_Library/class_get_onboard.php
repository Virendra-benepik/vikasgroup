<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}
require_once('class_get_useruniqueid.php');
include_once('Api_Class/class_find_groupid.php');

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

            $query = "select TCPD.*,if(TCPD.post_img IS NULL or TCPD.post_img = '','',Concat('$site_url', TCPD.post_img)) as post_img, DATE_FORMAT(TCPD.created_date,'%d %b %Y') as created_date,
                           (SELECT COUNT(distinct userUniqueId) 
                            FROM Tbl_Analytic_PostView
                            WHERE Tbl_Analytic_PostView.post_id = TCPD.post_id
                            ) as Unique_View, 
                            (SELECT COUNT(*) 
                            FROM Tbl_Analytic_PostView
                            WHERE Tbl_Analytic_PostView.post_id = TCPD.post_id
                            ) as Total_View
                            from Tbl_C_PostDetails as TCPD
                            where TCPD.clientId=:cli and TCPD.flagCheck = 12 and TCPD.userUniqueId =:cb order by TCPD.auto_id desc";

            try {
                $stmt = $this->DB->prepare($query);
                $stmt->execute(array('cli' => $this->cid, 'cb' => $this->eid));
            } catch (PDOException $e) {
                echo $e;
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();
            $response["success"] = 1;
            $response["message"] = "data fetched successfully";
            $response["posts"] = $rows;
        } else {
            //$query = "select *,Concat('$site_url', post_img) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 12 order by auto_id desc";

            $query = "select TCPD.*,if(TCPD.post_img IS NULL or TCPD.post_img = '','',Concat('$site_url', TCPD.post_img))  as post_img, DATE_FORMAT(TCPD.created_date,'%d %b %Y') as created_date,
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

    function getAllOnboardFORandroid($clientid, $val, $uid) {

        //echo $clientid . $val . $uid ; 
        $this->idclient = $clientid;
        $this->value = $val;
        $site_url = dirname(SITE_URL) . "/";
        //echo $site_url;die;

        /*         * **************************** check user detail ****************************************** */
        $query2 = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
        $stmt2 = $this->DB->prepare($query2);
        $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
        $stmt2->bindParam(':empid', $uid, PDO::PARAM_STR);
        $stmt2->execute();
        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        //	print_r($rows2);
        /*         * **************************** end check user detail ****************************************** */

        if (count($rows2) > 0) {
            /*             * ********************** find user group ******************************* */

            $uuids = $rows2[0]['employeeId'];
            //echo "employee id -".$uuids;
            $group_object = new FindGroup();    // this is object to find group id of given unique id 
            $getgroup = $group_object->groupBaseofUid($clientid, $uid);
            $value = json_decode($getgroup, true);
            //  echo'<pre>';
            //  print_r($value);

            /*             * ********************* end find user group****************************** */

            if (count($value['groups']) > 0) {
                $in = implode("', '", array_unique($value['groups']));
                try {

                    /*                     * ****************************** counnt aboard ********************** */
                    $countquery = "select count(distinct(postId)) as totals from Tbl_Analytic_PostSentToGroup where clientId=:cli1 and status = 1 and flagType = 12 and groupId IN('" . $in . "')";
                    $stmt11 = $this->DB->prepare($countquery);
                    $stmt11->bindParam(':cli1', $this->idclient, PDO::PARAM_STR);
                    $stmt11->execute();
                    $rows11 = $stmt11->fetchAll(PDO::FETCH_ASSOC);
                    // print_r($rows11);
                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["totals"] = $rows11[0]["totals"];
                    $response["posts"] = array();
                    /*                     * ************************************************************************** */

                    $query3 = "select distinct(postId) from Tbl_Analytic_PostSentToGroup where clientId=:cli and status = 1 and flagType = 12 and groupId IN('" . $in . "') order by autoId desc";

                    $stmt3 = $this->DB->prepare($query3);
                    $stmt3->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    $stmt3->execute();
                    $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                    $post = array();
                    if (count($rows3) > 0) {
                        foreach ($rows3 as $row) {

                            $postid = $row["postId"];

                            $query = "select *,if(post_img IS NULL OR post_img = '','', Concat('$site_url', post_img)) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 12 and status = 'Publish' and 	post_id = :postid";
//                    . "limit " . $this->value . " , 5";
                            $stmt = $this->DB->prepare($query);
                            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                            $stmt->bindParam(':postid', $postid, PDO::PARAM_STR);
                            $stmt->execute();
                            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                            array_push($response["posts"], $rows);
                        }

                        return json_encode($response);
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "No more posts available";
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
            } else {
                $response["success"] = 0;
                $response["message"] = "You are not selected in any group";
                return json_encode($response);
            }
        } else {
            $response["success"] = 0;
            $response["message"] = "Sorry! You are Not Authorized User";
            return json_encode($response);
        }
    }

    /*     * *************************************************************************************************** */

    function getSingleOnboard($postid, $clientid, $imagepath = '') {
        $this->id = $postid;
        $this->cli = $clientid;

        $site_url = ($imagepath == '') ? SITE : site_url;
        //  echo "this iss site url".$site_url;
        $query = "select post.*, DATE_FORMAT(post.created_date,'%d %b %Y') as created_date , if(post.post_img IS NULL or post.post_img='' , '', CONCAT('" . $site_url . "',post.post_img)) as post_img, if(user.userImage IS NULL or user.userImage='','',CONCAT('" . $site_url . "',user.userImage)) as userImage from Tbl_C_PostDetails as post join Tbl_EmployeePersonalDetails as user on post.userUniqueId = user.employeeId where post.post_id =:pid and post.clientId=:cli";
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
