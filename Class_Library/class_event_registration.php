<?php
include_once('class_connect_db_Communication.php');

class EventRegistration {

    public $DB;
    public $DB_Admin;

    public function __construct() {
       
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $eventid;
    public $clientid;
    public $uid;

    function createEventRegistration($clientid,  $createdBy, $eventid, $device) {

        date_default_timezone_set('Asia/Calcutta');
        $dte = date('Y-m-d H:i:s');

        $this->clientid = $clientid;
        $this->eventid = $eventid;
        $this->uid = $createdBy;

        try {
            $query = "insert into Tbl_Analytic_EventRegister(clientId,userUniqueId,eventId,registeredDate, device)values(:cid,:uid,:eid,:cd,:dev)";

            $stmt = $this->DB->prepare($query);
            $stmt->bindparam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindparam(':uid', $this->uid, PDO::PARAM_STR);
            $stmt->bindparam(':eid', $this->eventid, PDO::PARAM_STR);
            $stmt->bindparam(':cd', $dte, PDO::PARAM_STR);
			 $stmt->bindparam(':dev', $device, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $res["success"] = 1;
                $res['msg'] = "You succeffully registered";
                return json_encode($res);
            }
			
        } catch (PDOException $ex) {
            // echo $ex;
            $res["success"] = 0;
            $res['msg'] = "You already registered for this event";
            return json_encode($res);
        }
    }

    function getAllEventRegistration($clientid, $eventid) {
        $this->clientid = $clientid;
        $this->eventid = $eventid;
		$imagepath = SITE;
        try {
            $query = "select * from Tbl_Analytic_EventRegister where clientId =:cli and eventId =:eid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $this->eventid, PDO::PARAM_STR);
            $stmt->execute();

            $ROW = $stmt->fetchAll(PDO::PARAM_STR);

            $count = count($ROW);
            echo "dd-:" . $count;
            $res['user'] = array();
            for ($k = 0; $k < $count; $k++) {
                $uuid = $ROW[$k]['userUniqueId'];
                echo "uuid :-" . $uuid . "<br/>";
                $cid = $ROW[$k]['clientId'];
                $query1 = "select ud.*, IF(up.linkedIn='1', up.userImage, IF(up.userImage IS NULL or up.userImage='','',CONCAT('" . $imagepath . "',up.userImage)))as userImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on 
		 ud.employeeId = up.employeeId where ud.employeeId =:uid and ud.clientId =:cid";
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':uid', $uuid, PDO::PARAM_STR);
                $stmt1->bindParam(':cid', $cid, PDO::PARAM_STR);
                $stmt1->execute();

                $rows = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                array_push($res['user'], $rows[0]);
            }
            $res["success"] = 1;
            return json_encode($res);
        } catch (PDOException $e) {
            echo $e;
            $res["success"] = 0;
            $res['user'] = "error";
            return json_encode($res);
        }

        // $rows = $stmt->fetchAll();
        //return json_encode($rows);
    }

    function eventRegistration($clientid, $uid, $eid, $dev) {

        $this->cid = $clientid;
        $this->uid = $uid;
        $this->eid = $eid;
        $this->device = $dev;

        try {

            $query = "select * from Tbl_Analytic_EventRegister where clientId=:cid and userUniqueId=:uid and eventId=:eid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->cid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $this->eid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $status = $row["status"];
                if ($status == 'register') {
                    $status = "unregister";
                    $query = "update Tbl_Analytic_EventRegister set status=:sta where clientId=:cid and userUniqueId=:uid and eventId=:eid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cid', $this->cid, PDO::PARAM_STR);
                    $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
                    $stmt->bindParam(':eid', $this->eid, PDO::PARAM_STR);
                    $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        $resp["success"] = 1;
                        $resp["msg"] = "You are unregister successfully";
                    }
                    return json_encode($resp);
                } else {
                    $status = "register";
                    $query = "update Tbl_Analytic_EventRegister set status=:sta where clientId=:cid and userUniqueId=:uid and eventId=:eid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cid', $this->cid, PDO::PARAM_STR);
                    $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
                    $stmt->bindParam(':eid', $this->eid, PDO::PARAM_STR);
                    $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        $resp["success"] = 1;
                        $resp["msg"] = "You are register successfully";
                    }
                    return json_encode($resp);
                }
            } else {
                $resp["success"] = 1;
                $resp["msg"] = "You are new for registration";

                date_default_timezone_set('Asia/Calcutta');
                $c_date = date('Y-m-d H:i:s');
                $status = "register";
                try {
                    $query = "insert into Tbl_Analytic_EventRegister(clientId,userUniqueId,eventId,registeredDate,device,status)values(:cid,:uid,:eid,:cdate,:dev,:sta)";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cid', $this->cid, PDO::PARAM_STR);
                    $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
                    $stmt->bindParam(':eid', $this->eid, PDO::PARAM_STR);
                    $stmt->bindParam(':cdate', $c_date, PDO::PARAM_STR);
                    $stmt->bindParam(':dev', $this->device, PDO::PARAM_STR);
                    $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        $resp["success"] = 1;
                        $resp["msg"] = "You Register for this event successfully";
                    }
                    return json_encode($resp);
                } catch (PDOException $e) {
                    $resp["success"] = 0;
                    $resp["msg"] = "You can't Register for this event";
                    return json_encode($resp);
                }
            }
            return json_encode($resp);
        } catch (PDOException $e) {
            $resp["success"] = 0;
            $resp["msg"] = $e->getMessage();
            return json_encode($resp);
        }
    }
	
/****************************** get event query registration **************************************/

 function getqueriesreport($clientid, $eventid) {
        $this->clientid = $clientid;
        $this->eventid = $eventid;
		$imagepath = SITE;
        try {
            $query = "select * from Tbl_Analytic_EventRegister where clientId =:cli and eventId =:eid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $this->eventid, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::PARAM_STR);

           if($row)
		   {
            $res["success"] = 1;
			$res["message"] = "show query report";
			$res["Data"] = $row;
		   }
            return json_encode($res);
        }
		catch (PDOException $e) {
            echo $e;
            $res["success"] = 0;
            $res["message"] = "error";
            return json_encode($res);
        }

        
    }

/***************************** end get event query registration ***********************************/

/************************ export ***************************/

function eventRegistrationExportData($clientid,$eventid) {
        
        try {
             $query = "select Tbl_EmployeeDetails_Master.companyName as company , CONCAT(Tbl_EmployeeDetails_Master.firstName,' ',Tbl_EmployeeDetails_Master.lastName) as name , Tbl_EmployeeDetails_Master.employeeCode , Tbl_C_EventDetails.title,Tbl_EmployeeDetails_Master.department , Tbl_EmployeeDetails_Master.location ,Tbl_EmployeeDetails_Master.designation from Tbl_Analytic_EventRegister JOIN Tbl_EmployeeDetails_Master ON Tbl_Analytic_EventRegister.userUniqueId = Tbl_EmployeeDetails_Master.employeeId JOIN Tbl_C_EventDetails ON Tbl_Analytic_EventRegister.eventId = Tbl_C_EventDetails.eventId where Tbl_Analytic_EventRegister.clientId =:cli and Tbl_Analytic_EventRegister.eventId =:eid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $eventid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
           
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

/*************************** end export ********************/ 

}

?>