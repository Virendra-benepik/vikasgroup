<?php

if (!class_exists("Connection_Communication")) {
    include_once('class_connect_db_Communication.php');
}

class Department {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

 
    /*     * ********************************** FUNCTION FOR API *********************************** */

    function getDepartment($client_id) {

        try {
                $query = "select distinct(department) from Tbl_EmployeeDetails_Master where clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$client_id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            return json_encode($row);
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
	/**************************** get location ***************************/
	
	function getLocation($client_id) {

        try {
                $query = "select distinct(location) from Tbl_EmployeeDetails_Master where clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$client_id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            return json_encode($row);
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
	/**************************** / get company *************************/
   
    
	function getCompanyName($client_id) {

        try {
                $query = "select companyUniqueId,companyName from Tbl_Client_CompanyDetails where clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$client_id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            return json_encode($row);
        } catch (PDOException $e) {
            echo $e;
        }
    }
}