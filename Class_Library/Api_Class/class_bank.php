<?php

error_reporting(E_ALL ^ E_NOTICE);

if (!class_exists("Connection_Communication")){
    include_once('../../Class_Library/Api_Class/class_connect_db_Communication.php');
}

class Bank {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function AddToBank($clientid, $employeeid, $bname, $ifsc, $aNumber, $name) {
        try {
            $max = "select max(autoId) from Tbl_EmployeeBankDetails";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $c_id = $tr[0];
                $c_id1 = $c_id + 1;
                $bankid = "BD-" . $c_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }


        try {
            $query = "select Tbl_EmployeeDetails_Master.*,Tbl_ClientDetails_Master.* from Tbl_EmployeeDetails_Master join Tbl_ClientDetails_Master on Tbl_EmployeeDetails_Master.clientId = Tbl_ClientDetails_Master.client_id where Tbl_ClientDetails_Master.client_id=:cli and Tbl_EmployeeDetails_Master.employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);
           // print_r($result1);
            $response = array();

            if ($result1) {
                $status = 1;
                date_default_timezone_set("Asia/Kolkata");
                $insertdate = date("Y-m-d H:i:s");
                $query = "insert into Tbl_EmployeeBankDetails (bdId,clientId,employeeId,emailId,bankName,ifscCode,accountNo, cardHolderName, status,insertedDate,insertedby) values(:bd,:cli,:empid,:eml,:bnam,:ifs,:ano,:cnam,:sts,:insd,:insb) ON DUPLICATE KEY UPDATE bankName=:bnam,ifscCode=:ifs,accountNo=:ano, cardHolderName=:cnam,updatedDate =:insd,updatedBy =:insb,emailId=:eml,status = :sts";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':bd', $bankid, PDO::PARAM_STR);
                $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                 $stmt->bindParam(':eml', $result1['emailId'], PDO::PARAM_STR);
                $stmt->bindParam(':bnam', $bname, PDO::PARAM_STR);
                $stmt->bindParam(':ifs', $ifsc, PDO::PARAM_STR);
                $stmt->bindParam(':ano', $aNumber, PDO::PARAM_STR);
                $stmt->bindParam(':cnam', $name, PDO::PARAM_STR);
                $stmt->bindParam(':sts', $status, PDO::PARAM_STR);
                $stmt->bindParam(':insd', $insertdate, PDO::PARAM_STR);
                $stmt->bindParam(':insb', $employeeid, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $response["success"] = 1;
                    $response["message"] = "Bank details added successfully";
                    $response["mailid"] = $result1["emailId"];
                    $response["progName"] = $result1["program_name"];
                    $response["dedicatedEmail"] = $result1["dedicated_mail"];
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Bank details no added";
                }
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "You are not authorised person";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function GetFromBank($clientid, $employeeid) {
        try {
            $query = "select Tbl_EmployeeBankDetails.*, DATE_FORMAT(Tbl_EmployeeBankDetails.insertedDate,'%d %b %Y %h:%i %p') as insertedDate from Tbl_EmployeeBankDetails join Tbl_EmployeeDetails_Master on Tbl_EmployeeBankDetails.employeeId = Tbl_EmployeeDetails_Master.employeeId where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeeDetails_Master.employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {

                $response = array();
                $response["success"] = 1;
                $response["message"] = "Bank details display successfully";
                $response["posts"] = $result;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No Bank details displayed";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

}

?>