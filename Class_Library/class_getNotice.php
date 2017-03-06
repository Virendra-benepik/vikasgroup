<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}
if (!class_exists('FindGroup')) {
    require_once('Api_Class/class_find_groupid.php');
}
if (!class_exists('getUserData')) {
    require_once('class_get_useruniqueid.php');
}

class GetNotice {

    public $DB;

    public function __construct() {

        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $cid;
    public $eid;
    public $uid;

    function getAllnotices($cid, $eid, $usertype) {
        $this->cid = $cid;
        $this->eid = $eid;
        $this->uid = $usertype;

//date_default_timezone_set('Asia/Calcutta');
//$cur_time = time();

        if ($this->uid == "SubAdmin") {
            $query = "select * from Tbl_C_NoticeDetails where clientId = :cid1 and createdBy = :cb  order by autoId desc ";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->execute(array('cid1' => $this->cid, 'cb' => $this->eid));
            } catch (PDOException $e) {
                echo $e;
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();
            $response["success"] = 1;
            $response["message"] = "data fetched successfully";
            $response["posts"] = array();

            foreach ($rows as $row) {

                $post["noticeId"] = $row["noticeId"];
                $post["noticeTitle"] = $row["noticeTitle"];

                $uid = $row["createdBy"];
                /* $result = $gt->getUserData($cid,$uid);
                  $value = $result.success;
                  $post["result"] = $value;
                 */

                $gt = new UserUniqueId();
                $result1 = $gt->getUserData($cid, $uid);
                $result = json_decode($result1, true);
//print_r($result);
                $post["name"] = $result[0]['firstName'] . " " . $result[0]['lastName'];


                $post["publishingTime"] = $row["publishingTime"];
                $post["unpublishingTime"] = $row["unpublishingTime"];
                $post["status"] = $row["status"];
                $post["fileName"] = $row["fileName"];
                array_push($response["posts"], $post);
            }
        } else {

            $query = "select * from Tbl_C_NoticeDetails where clientId = :cid1 order by autoId desc ";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->execute(array('cid1' => $this->cid));
            } catch (PDOException $e) {
                echo $e;
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();
            $response["success"] = 1;
            $response["message"] = "data fetched successfully";
            $response["posts"] = array();

            foreach ($rows as $row) {

                $post["noticeId"] = $row["noticeId"];
                $post["noticeTitle"] = $row["noticeTitle"];

                $uid = $row["createdBy"];
                /* $result = $gt->getUserData($cid,$uid);
                  $value = $result.success;
                  $post["result"] = $value;
                 */

                $gt = new UserUniqueId();
                $result1 = $gt->getUserData($cid, $uid);
                $result = json_decode($result1, true);
//print_r($result);
                $post["name"] = $result[0]['firstName'] . " " . $result[0]['lastName'];


                $post["publishingTime"] = $row["publishingTime"];
                $post["unpublishingTime"] = $row["unpublishingTime"];
                $post["status"] = $row["status"];
                $post["fileName"] = $row["fileName"];
                array_push($response["posts"], $post);
            }
        }
        return json_encode($response);
    }

    /*     * ********************** get all notice ************************************** */

    function getStatusOfNotice($pub, $unpub) {

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

    /*     * ****************************************************************************************************** */

    function getAllNoticesDetails($clientid, $empid, $val, $module = '') {

        /****************************************
          $module  = 1
          we consider flag value 1  for display data in web view of application

         * *** */
        $this->idclient = $clientid;
        $this->employeeId = $empid;
        $this->value = $val;
        $path = dirname(SITE_URL)."/";

        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $this->employeeId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            if (count($rows) > 0) {
                $group_object = new FindGroup();    // this is object to find group id of given unique id 
                $getgroup = $group_object->groupBaseofUid($clientid, $empid);
                $value = json_decode($getgroup, true);
                //print_r($value);
                /************************************************************************************************* */

                $count_group = count($value['groups']);
                //echo "total group of empid =: ".$count_group."<br/>";
                if ($count_group <= 0) {
                    $response["success"] = 0;
                    $response["message"] = "Sorry You are Not in Any Group";
                } else {
                    $in = implode("', '", array_unique($value['groups']));
                    //echo "group array : ".$in."<br/>";

                    /************************************************************************************************** */
                    $query21 = "select count(distinct(noticeId)) as total_notices from Tbl_Analytic_NoticeSentToGroup where clientId=:cli and status = 1 and groupId IN ('" . $in . "')";
                    $stmt21 = $this->DB->prepare($query21);
                    $stmt21->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    // $stmt2->bindParam(':uid',$uuids, PDO::PARAM_STR);
                    $stmt21->execute();
                    $rows2 = $stmt21->fetch(PDO::FETCH_ASSOC);

                    if ($module == 1) {
                        $noticequery = "select distinct(noticeId) as noticeid from Tbl_Analytic_NoticeSentToGroup where groupId IN('" . $in . "') and clientId =:cid and status = 1 order by autoId desc limit 5";
                    } else {
                        $noticequery = "select distinct(noticeId) as noticeid from Tbl_Analytic_NoticeSentToGroup where groupId IN('" . $in . "') and clientId =:cid and status = 1 order by autoId desc limit " . $this->value . ",20";
                    }

                    $nstmt = $this->DB->prepare($noticequery);
                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                    $nstmt->execute();
                    $noticerows1 = $nstmt->fetchAll(PDO::FETCH_ASSOC);

                    $response["total_notices"] = $rows2["total_notices"];

                    $response['notice'] = array();
                    $status = "Publish";

                    if (count($noticerows1) > 0) 
                        {
                        $response["success"] = 1;
                        $response["message"] = "Notice data available for you";
                        foreach ($noticerows1 as $noticerows) 
                            {
                            $noticeid = $noticerows['noticeid'];
                            $query2 = "select *, DATE_FORMAT(createdDate,'%d %b %Y') as createdDate,DATE_FORMAT(publishingTime,'%d %b %Y %h:%i %p') as publishingTime, 
                            DATE_FORMAT(unpublishingTime,'%d %b %Y %h:%i %p') as unpublishingTime  
                            from Tbl_C_NoticeDetails where noticeId=:nid and clientId=:cli and status = 'Live'";
                            
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                            $stmt2->bindParam(':nid', $noticeid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $rows = $stmt2->fetch(PDO::FETCH_ASSOC);

                            $post["autoId"] = $rows["autoId"];
                            $post["clientId"] = $rows["clientId"];
                            $post["noticeId"] = $rows["noticeId"];
                            $post["noticeTitle"] = $rows["noticeTitle"];
                            $post["fileName"] = !empty($rows["fileName"]) ? $path . $rows["fileName"] : "";
                            $post["location"] = $rows["location"];
                            $post["createdBy"] = $rows["createdBy"];
                            $post["createdDate"] = $rows["createdDate"];
                            $post["status"] = $rows["status"];
                            $post["publishingTime"] = $rows["publishingTime"];
                            $post["unpublishingTime"] = $rows["unpublishingTime"];
                            array_push($response["notice"], $post);
                        }
                    } else {
                        $response['success'] = 0;
                        $response['msg'] = "No more post available";
                    }
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "You are not authorized user please check your employee code";
            }
        } catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = "there is some error" . $e;
        }
        return json_encode($response);
    }

    /*     * *********************************************************************************************************** */

    function getSingleNotice($noticeid, $clientid) {
        $this->id = $noticeid;
        $this->cli = $clientid;

        $query = "select * from Tbl_C_NoticeDetails where noticeId =:pid and clientId=:cli";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->cli, PDO::PARAM_STR);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Successfully fetch data";
                $response["posts"] = array();

                foreach ($rows as $row) {
                    $post["clientId"] = $row["clientId"];
                    $post["noticeId"] = $row["noticeId"];
                    $post["noticeTitle"] = $row["noticeTitle"];
                    $post["fileName"] = $row["fileName"];
                    $post["createdBy"] = $row["createdBy"];
                    $post["createdDate"] = $row["createdDate"];
                    $post["status"] = $row["status"];
                    $post["publishingTime"] = $row["publishingTime"];
                    $post["unpublishingTime"] = $row["unpublishingTime"];

                    $nid = $row["noticeId"];

                    /* 		 $query = "select location from NoticeLocationDetails where noticeId =:pid and clientId=:cli";
                      $stmt = $this->DB->prepare($query);
                      $stmt->bindParam(':pid',$this->id, PDO::PARAM_STR);
                      $stmt->bindParam(':cli',$this->cli, PDO::PARAM_STR);
                      $stmt->execute();
                      $ro = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      $post[locations]=$ro;
                     */
                    array_push($response["posts"], $post);
                }
                return json_encode($response);
            } else {

                echo "<script>alert('not executed here')</script>";
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * *********************************************************************************************************************** */

    function updateNoticeStatus($pid, $sta) {
        $this->noticeid = $pid;
        $this->status = $sta;
        if ($this->status == "Expire") {
            $welstatus = 0;
        } else {
            $welstatus = 1;
        }
        $query = "update Tbl_C_NoticeDetails set status=:sta where noticeId =:pid";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->noticeid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);

			$gquery = "update Tbl_Analytic_NoticeSentToGroup set status = :sta2 where noticeId = :comm2 ";
            $stmtg = $this->DB->prepare($gquery);
            $stmtg->bindParam(':comm2', $this->noticeid, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $welstatus, PDO::PARAM_STR);
            $stmtg->execute();
			
            $wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :comm1 ";
            $stmtw = $this->DB->prepare($wquery);
            $stmtw->bindParam(':comm1', $this->noticeid, PDO::PARAM_STR);
            $stmtw->bindParam(':sta1', $welstatus, PDO::PARAM_STR);
            $stmtw->execute();
            if ($stmt->execute()) {
                $response[success] = 1;
                $response[message] = "Successfully notice status changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ***************************************************************************************************** */

    function deleteNotice($nid) {
        $this->noticeid = $nid;

        $query = "delete from Tbl_C_NoticeDetails where noticeId =:nid";
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
