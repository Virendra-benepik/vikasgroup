<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (!class_exists("Connection_Communication")){
    include_once('../../Class_Library/class_connect_db_Communication.php');
}

    class GCM {

        public $db_connect;

        public function __construct() {
            $dbh = new Connection_Communication();
            $this->db_connect = $dbh->getConnection_Communication();
        }

        public function addGCMDetails($data) {
            $dt = date("Y-m-d H:i:s");
            $sts = "Active";
            $query1 = "INSERT INTO Tbl_EmployeeGCMDetails
(userUniqueId,clientId,deviceName,registrationToken,date_entry_time,status,insertedBy,appVersion) VALUES (:email,:client,:device,:id,:dte,:sts,:inby,:appver)
ON DUPLICATE KEY UPDATE userUniqueId = :email,clientId=:client,deviceName=:device, updatedDate =:udate,updatedBy = :uby ,appVersion=:appver";

            $query_params1 = array(
                ':email' => $data['userUniqueId'],
                ':device' => $data['device'],
                ':id' => $data['regToken'],
                ':client' => $data['clientId'],
                ':dte' => $dt,
                ':sts' => $sts,
                ':inby' => $data['userUniqueId'],
                ':udate' => $dt,
                ':uby' => $data['userUniqueId'],
				':appver' => $data['appVersion']
				
            );

            try {
                $stmt1 = $this->db_connect->prepare($query1);
                $result1 = $stmt1->execute($query_params1);
				if($result1)
				{
			    $response["success"] = 1;
                $response["message"] = "data added";
				}
            } catch (PDOException $ex) 
			{
                $response["success"] = 0;
                $response["message"] = $ex;
            }
			return $response;
        }

    }

