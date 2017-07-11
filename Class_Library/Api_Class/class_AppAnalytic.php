<?php

if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class AppAnalytic {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function listAppview($clientid, $uid, $device, $deviceId, $flagtype) {
        date_default_timezone_set('Asia/Kolkata');
        $login_date = date('Y-m-d H:i:s');
        $devicename = ($device == 2) ? 'Android' : 'Ios';

        try {
            $query = "insert into Tbl_Analytic_ListView(userUniqueId,deviceId,date_of_entry,clientId,flagType,device)values(:empid, :devId, :dat, :cid, :flag, :dev)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
            $stmt->bindParam(':devId', $deviceId, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $login_date, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flagtype, PDO::PARAM_STR);
            $stmt->bindParam(':dev', $devicename, PDO::PARAM_STR);
            $stmt->execute();

            /*             * ************************* Add into track table ************************* */
            $desc = "Open List View";
            self::trackUser($clientid, $uid, $devicename, $deviceId, $flagtype, $desc);
            
        } catch (PDOException $e) {
            echo $e;
        }
    }

    
     /*********************************** check spalsh open *********************************/
    
     function checkspalshopen($cid,$uid,$device,$deviceId,$appversion) {
        date_default_timezone_set('Asia/Kolkata');
        $login_date = date('Y-m-d H:i:s');
        $devicename = ($device == 2)?'Android':'Ios';


        try {
            $query = "insert into Tbl_Analytic_AppView(userUniqueId,deviceId,date_of_entry,clientId,device,appVersion) values(:empid, :devId, :dat, :cid, :dev, :appv)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
             $stmt->bindParam(':devId', $deviceId, PDO::PARAM_STR);
                $stmt->bindParam(':dat', $login_date, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->bindParam(':dev',$devicename, PDO::PARAM_STR);
             $stmt->bindParam(':appv',$appversion, PDO::PARAM_STR);
           $stmt->execute();
              /** ************************* Add into track table ************************* */
            $desc = "Open Spalsh";
            $flagtype = 0;
            self::trackUser($cid, $uid, $devicename, $deviceId, $flagtype, $desc);
           
        } catch (PDOException $e) {
            echo $e;
        }
    }
    
      /*********************************** check home open *********************************/
    
     function checkHomeOpen($cid,$uid,$device,$deviceId) {
        date_default_timezone_set('Asia/Kolkata');
        $login_date = date('Y-m-d H:i:s');
        $devicename = ($device == 2)?'Android':'Ios';

        try {
            $query = "insert into Tbl_Analytic_HomeView(userUniqueId,deviceId,date_of_entry,clientId,device) values(:empid, :devId, :dat, :cid, :dev)";
            $stmt =  $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
             $stmt->bindParam(':devId', $deviceId, PDO::PARAM_STR);
                $stmt->bindParam(':dat', $login_date, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->bindParam(':dev',$devicename, PDO::PARAM_STR);
          
            $stmt->execute();
                /** ************************* Add into track table ************************* */
            $desc = "Open Home";
            $flagtype = 0;
            self::trackUser($cid, $uid, $devicename, $deviceId, $flagtype, $desc);
            
        } catch (PDOException $e) {
            echo $e;
        }
    }
    
       /*     * *************************************************************************************************** */

    function viewednews($clientid, $pid, $eid, $flagtype, $device,$deviceId) {
        $this->postids = $pid;
        $this->commentedbys = $eid;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_PostView(userUniqueId,post_id,clientId,date_of_entry,flagType,device,deviceId)
            values(:eid,:pid,:clid,:dc,:flag,:device,:deviceid)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':eid', $this->commentedbys, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->postids, PDO::PARAM_STR);
            $stmt->bindParam(':clid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':dc', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flagtype, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
             $stmt->bindParam(':deviceid', $deviceId, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                 /** ************************* Add into track table ************************* */
            $desc = "Open full View";
           $devicename = ($device == 2)?'Android':'Ios';
            self::trackUser($clientid,  $eid, $devicename, $deviceId, $flagtype, $desc);
            
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    
    
    
    
    
    function trackUser($clientid1, $uid1, $devicename1, $deviceId1, $flagtype1, $desc1) {
      
        date_default_timezone_set('Asia/Kolkata');
        $login_date1 = date('Y-m-d H:i:s');

        try {
            $query2 = "insert into Tbl_Analytic_TrackUser(userUniqueId,deviceId,date_of_entry,clientId,device,description,flagType)values(:empid, :devId, :dat, :cid, :dev, :desc, :flag)";
            $stmt2 = $this->db_connect->prepare($query2);
            $stmt2->bindParam(':empid', $uid1, PDO::PARAM_STR);
            $stmt2->bindParam(':devId', $deviceId1, PDO::PARAM_STR);
            $stmt2->bindParam(':dat', $login_date1, PDO::PARAM_STR);
            $stmt2->bindParam(':cid', $clientid1, PDO::PARAM_STR);
            $stmt2->bindParam(':flag', $flagtype1, PDO::PARAM_STR);
            $stmt2->bindParam(':dev', $devicename1, PDO::PARAM_STR);
            $stmt2->bindParam(':desc', $desc1, PDO::PARAM_STR);
            $stmt2->execute();
        } catch (Exception $ex) {
            echo $ex;
        }
    }
    
    
    
    
    public $postid;
    public $commentedby;

    function clickednotification($clientid, $post_id, $employeeid, $flag, $device,$deviceId) {
        $this->postid = $post_id;
        $this->clickedby = $employeeid;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_ClickedPushNotification(clientId,userUniqueId,postId,dateOFentry,flagType,device,deviceId)values(:cid,:uid,:pid,:dc,:flag,:device,:deviceid)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->clickedby, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':dc', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
             $stmt->bindParam(':deviceid',$deviceId, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }


}

?>