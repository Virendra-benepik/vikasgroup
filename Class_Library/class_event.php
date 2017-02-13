<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists("Connection_Communication")) {
    require_once('class_connect_db_Communication.php');
}
include_once('Api_Class/class_find_groupid.php');

class Event {

    public $DB;

    public function __construct() {

        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function getMaxEventId() {
        try {
            $max = "select max(autoId) from  Tbl_C_EventDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $eid = "Event" . $m_id1;

                return $eid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    public $eventid;
    public $clientid;
    public $title;
    public $imgname;
    public $venue;
    public $eventdate;
    public $desc;
    public $regis;
    public $uid;
    public $dte;

    /*     * ***************************************************************************** */

    function createNewEvent($clientid, $eventid, $title, $imgname, $venue, $eventdate, $desc, $regis, $createdDate, $createdBy, $flag,$cost) {
        $this->clientid = $clientid;
        $this->eventid = $eventid;
        $this->title = $title;
        $this->imgname = $imgname;
        $this->venue = $venue;
        $this->eventdate = $eventdate;
        $this->desc = $desc;
        $this->regis = $regis;
        $this->dte = $createdDate;
        $this->uid = $createdBy;
        $status = 'Active';
        $this->flag = $flag;
        try {
            $query = "insert into Tbl_C_EventDetails
  (clientId,eventId,title,imageName,venue,eventTime,registration,description,createdDate,createdBy,status,flagCheck,eventCost)
  values(:cid,:eid,:title,:imgname,:venue,:etime,:reg,:des,:cdate,:cb,:status,:flag,:cost)";

            $stmt = $this->DB->prepare($query);
            $stmt->bindparam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindparam(':eid', $this->eventid, PDO::PARAM_STR);
            $stmt->bindparam(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindparam(':imgname', $this->imgname, PDO::PARAM_STR);
            $stmt->bindparam(':venue', $this->venue, PDO::PARAM_STR);
            $stmt->bindparam(':etime', $this->eventdate, PDO::PARAM_STR);
            $stmt->bindparam(':reg', $this->regis, PDO::PARAM_STR);
            $stmt->bindparam(':des', $this->desc, PDO::PARAM_STR);
            $stmt->bindparam(':cdate', $this->dte, PDO::PARAM_STR);
            $stmt->bindparam(':cb', $this->uid, PDO::PARAM_STR);
            $stmt->bindparam(':status', $status, PDO::PARAM_STR);
            $stmt->bindparam(':flag', $flag, PDO::PARAM_STR);
			$stmt->bindparam(':cost', $cost, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public $useruniquid;
    public $user_type;

    /*     * ******************************************************************************************** */

    function getAllevents($clientid, $user_uniqueid, $user_type) {
        $this->clientid = $clientid;
        $this->useruniquid = $user_uniqueid;
        $this->user_type = $user_type;
        if ($this->user_type == "SubAdmin") {
            try {
                $query = "select * , DATE_FORMAT(eventTime,'%d %b %Y %h:%i %p') as eventTime from Tbl_C_EventDetails where clientId =:cli and createdBy =:cb order by autoId desc";

                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                $stmt->bindParam(':cb', $this->useruniquid, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            try {
                $query = "select * , DATE_FORMAT(eventTime,'%d %b %Y %h:%i %p') as eventTime from Tbl_C_EventDetails where clientId =:cli order by autoId desc";
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

    /*     * **************************************************************************** */

    public function EventDisplays($clientid, $uid, $val, $module = '') {
        $path = site_url;
//        $path = "http://admin.benepik.com/employee/virendra/benepik_client/";
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
            // echo "employee id -".$uuids;
            $group_object = new FindGroup();    // this is object to find group id of given unique id 
            $getgroup = $group_object->groupBaseofUid($clientid, $uid);
            $value = json_decode($getgroup, true);
//            echo'<pre>';
//                        print_r($value);die;
            if (count($value['groups']) > 0) {
                $in = implode("', '", array_unique($value['groups']));
                try {
                    if ($module == 1) {
                        $query1 = "select distinct(eventId) from Tbl_Analytic_EventSentToGroup where clientId=:cli and groupId IN('" . $in . "') order by autoId desc limit 1";
                    } else {
                        $query1 = "select distinct(eventId) from Tbl_Analytic_EventSentToGroup where clientId=:cli and groupId IN('" . $in . "') order by autoId desc limit " . $this->value . ",5";
                    }

                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    //  $stmt1->bindParam(':uid',$uuids, PDO::PARAM_STR);
                    $stmt1->execute();
                    $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                    $response["success"] = 1;
                    $response["message"] = "Event data available for you";

                    $query2 = "select count(distinct(eventId)) as total_events from Tbl_Analytic_EventSentToGroup where clientId=:cli and groupId IN('" . $in . "')";

                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    // $stmt2->bindParam(':uid',$uuids, PDO::PARAM_STR);
                    $stmt2->execute();
                    $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $response["total_events"] = $rows2["total_events"];

                    $response["posts"] = array();
                    if ($rows1) {
                        foreach ($rows1 as $row) {
                            $post["eventId"] = $row["eventId"];
                            $postid = $row["eventId"];

                            $query2 = "select *, eventTime as eventTime1, DATE_FORMAT(eventTime,'%d %b %Y %h:%i %p') as eventTime,
             DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate  from Tbl_C_EventDetails where eventId=:pstid and clientId=:cli";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                            $stmt2->bindParam(':pstid', $postid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


                            $query3 = "select count(userUniqueId) as registerValue from Tbl_Analytic_EventRegister where eventId=:pstid and clientId=:cli and userUniqueId=:uid and status='register' ";
                            $stmt3 = $this->DB->prepare($query3);
                            $stmt3->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                            $stmt3->bindParam(':pstid', $postid, PDO::PARAM_STR);
                            $stmt3->bindParam(':uid', $uuids, PDO::PARAM_STR);
                            $stmt3->execute();
                            $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                            /*    echo "<pre>";
                              echo "register value -".print_r($rows3);
                              echo "</pre>"; */
                            $eventtimeexpire = "0";
                            date_default_timezone_set("Asia/Kolkata");
                            $da = strtotime($rows2[0]["eventTime1"]);
                            $da1 = strtotime(date("Y-m-d H:i:s"));

                            if ($da < $da1) {
                                $eventtimeexpire = "1";
                            }

                            $post["eventTitle"] = $rows2[0]["title"];
                            $post["imageName"] = !empty($rows2[0]["imageName"]) ? str_replace(' ', '', $path . $rows2[0]["imageName"]) : '';
                            $post["venue"] = $rows2[0]["venue"];
                            $post["eventTime"] = $rows2[0]["eventTime"];
                            $post["description"] = $rows2[0]["description"];
                            $post["createdDate"] = $rows2[0]["createdDate"];
                            $uuid = $rows2[0]["createdBy"];
                            $post["status"] = $rows2[0]["status"];
                            $post["registration"] = $rows2[0]["registration"];
                            $post["registerValue"] = $rows3[0]["registerValue"];
                            $post["eventtimeexpire"] = $eventtimeexpire;
                            $fam = new Family();
                            $firstNam = $fam->getUserDetail($clientid, $uuid);

                            $post["userDetail"] = $firstNam["userName"]["firstName"];

                            array_push($response["posts"], $post);
                        }
                        return $response;
                    } else {

                        $response["success"] = 0;
                        $response["message"] = "No Event available for you";
                        return $response;
                    }
                } catch (PDOException $e) {
                    echo $e;
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "You are not selected in any group";
                return $response;
            }
        } else {
            $response["success"] = 0;
            $response["message"] = "Sorry! You are Not Authorized User";
            return $response;
        }
    }

    /*     * **************************** get event query registration ************************************* */

    function getqueriesreport($clientid, $eventid) {
        $this->clientid = $clientid;
        $this->eventid = $eventid;
        $imagepath = SITE;
        try {
            $query = "select teq.autoId,ted.title,teq.query,DATE_FORMAT(teq.createdDate,'%d %b %Y %h:%i %p') as createdDate, CONCAT(edm.firstName,' ',edm.lastName) as name from Tbl_C_EventQueries as teq JOIN Tbl_C_EventDetails as ted ON teq.Id = ted.eventId  and teq.clientId = ted.clientId JOIN Tbl_EmployeeDetails_Master as edm ON teq.createdBy = edm.employeeId where teq.clientId =:cli and teq.Id =:eid and teq.flagType = 6 order by teq.createdDate desc ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $this->eventid, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::PARAM_STR);

            if ($row) {
                $res["success"] = 1;
                $res["message"] = "show query report";
                $res["Data"] = $row;
            }
            return json_encode($res);
        } catch (PDOException $e) {
            echo $e;
            $res["success"] = 0;
            $res["message"] = "error";
            return json_encode($res);
        }
    }

    /*     * *************************** end get event query registration ********************************** */

    /*     * ***************************** get event all event list ******************************************** */

    function getAlleventslist($clientid) {
        $path = SITE;
        $this->clientid = $clientid;
        try {
            $query = "SELECT Tbl_C_EventDetails . * ,CONCAT('" . $path . "',Tbl_C_EventDetails.imageName) as 	imageName , DATE_FORMAT(Tbl_C_EventDetails.	createdDate,'%d %b %Y %h:%i %p') as createdDate , (

            SELECT COUNT(distinct userUniqueId) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_EventDetails.eventId AND Tbl_Analytic_PostView.flagType = 6
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_EventDetails.eventId AND Tbl_Analytic_PostView.flagType = 6
            ) as TotalCount

            FROM Tbl_C_EventDetails where Tbl_C_EventDetails.flagCheck = 6 and Tbl_C_EventDetails.clientId =:cli order by Tbl_C_EventDetails.autoId desc";


            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::PARAM_STR);
            if ($row) {
                $res["success"] = 1;
                $res["message"] = "show query report";
                $res["Data"] = $row;
            }
            return json_encode($res);
        } catch (PDOException $e) {
            echo $e;
            $res["success"] = 0;
            $res["message"] = "error";
            return json_encode($res);
        }
    }

    /*     * ********************* get all event list ************************************************************ */

    /*     * ***************************** get single query details ***************************************************** */

    function getSingleQueryDetails($clientid, $eventid, $queryid) {

        $imagepath = SITE;
        try {
            $query = "select teq.autoId,ted.title,teq.query,DATE_FORMAT(teq.createdDate,'%d %b %Y %h:%i %p') as createdDate, CONCAT(edm.firstName,' ',edm.lastName) as name ,CONCAT('" . $imagepath . "',ted.imageName) as imageName from Tbl_C_EventQueries as teq JOIN Tbl_C_EventDetails as ted ON teq.Id = ted.eventId  and teq.clientId = ted.clientId JOIN Tbl_EmployeeDetails_Master as edm ON teq.createdBy = edm.employeeId   where teq.clientId =:cli and teq.Id =:eid and teq.autoId = :qid and teq.flagType = 6";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $eventid, PDO::PARAM_STR);
            $stmt->bindParam(':qid', $queryid, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::PARAM_STR);

            if ($row) {
                $res["success"] = 1;
                $res["message"] = "show query report";
                $res["Data"] = $row;
            }
            return json_encode($res);
        } catch (PDOException $e) {
            echo $e;
            $res["success"] = 0;
            $res["message"] = "error";
            return json_encode($res);
        }
    }

    /*     * ******************************** end get single query details *********************************************** */

    /*     * **************************************** view single event *************************************************** */

    function getsingleeventdetails($eventid, $clientid, $flag) {

        try {
            $query = "select * , DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate , DATE_FORMAT(eventTime,'%d %b %Y %h:%i %p') as eventTime from Tbl_C_EventDetails where eventId =:eventid AND clientId=:clientid AND flagCheck = :flag";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':eventid', $eventid, PDO::PARAM_STR);
            $stmt->bindParam(':clientid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = array();

        if ($rows) {
            for ($i = 0; $i < count($rows); $i++) {
                $post["post_title"] = $rows[$i]["title"];
                $post["post_img"] = $rows[$i]["imageName"];
                $post["post_content"] = $rows[$i]["description"];
                $post["created_date"] = $rows[$i]["createdDate"];
				$post["eventTime"] = $rows[$i]["eventTime"];
				$post["venue"] = $rows[$i]["venue"];
				$post["registration"] = $rows[$i]["registration"];
				$post["eventCost"] = $rows[$i]["eventCost"];
                array_push($response["posts"], $post);
            }
            return json_encode($response);
        }
    }

    /*     * ************************************ end view single event *************************************************** */

    public function event_details($clientid, $eventId, $flag) {
        try {
            $site_url = dirname(SITE_URL) . '/';

            $query = "select event.*,DATE_FORMAT(event.eventTime,'%d %b %Y %h:%i %p') as eventTime,DATE_FORMAT(event.createdDate,'%d %b %Y %h:%i %p') as createdDate, if(event.imageName IS NULL or event.imageName='', '', CONCAT('" . $site_url . "', event.imageName)) as imageName,if(user.userImage IS NULL or user.userImage='','',CONCAT('" . $site_url . "',user.userImage)) as userImage, Concat(user_master.firstName, ' ', user_master.lastName) as createdBy from Tbl_C_EventDetails as event join Tbl_EmployeePersonalDetails as user on event.createdBy = user.employeeId join Tbl_EmployeeDetails_Master as user_master on user_master.employeeId=event.createdBy where event.eventId=:eventId and event.clientId=:cli and event.status='Active' and event.flagCheck=:flag";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($rows);
            $response['success'] = 1;
            $response['message'] = "data found";
            $response['data'] = $rows;
        } catch (Exception $ex) {
            echo $ex;
            $response['success'] = 0;
            $response['message'] = "data not found " . $ex;
        }
        return $response;
    }

}

?>