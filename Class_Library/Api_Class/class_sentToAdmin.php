<?php

/* Database connection changed
  require_once('connect_db_PDO.php');
 */
require_once('class_connect_db_Communication.php');

class MessagesToAdmin {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function contactUs($clientid, $employeeid) {

        try {

            $query = "select Tbl_ClientDetails_Master.*,Tbl_EmployeeDetails_Master.* from Tbl_EmployeeDetails_Master join Tbl_ClientDetails_Master on Tbl_ClientDetails_Master.client_id = Tbl_EmployeeDetails_Master.clientId where Tbl_EmployeeDetails_Master.clientId =:cli and Tbl_EmployeeDetails_Master.employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

            if (count($result1) > 0) {
                $response["success"] = 1;
                $response["message"] = "Thanks for Contacting Us";

                $response["name"] = $result1["firstName"] . " " . $result1["middleName"];
                $response["mailid"] = $result1["emailId"];
                $response["contactno"] = $result1["contact"];
                $response["progName"] = $result1["program_name"];
                $response["dedicatedEmail"] = $result1["dedicated_mail"];
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Client id or Employee id is incorrect";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function referMerchant($clientid, $employeeid) {
        try {

            $query = "select Tbl_ClientDetails_Master.*,Tbl_EmployeeDetails_Master.* from Tbl_EmployeeDetails_Master join Tbl_ClientDetails_Master on Tbl_ClientDetails_Master.client_id = Tbl_EmployeeDetails_Master.clientId where Tbl_EmployeeDetails_Master.clientId =:cli and Tbl_EmployeeDetails_Master.employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result1) {
                $response["success"] = 1;
                $response["message"] = "Merchant Referred Successfully";
                $response["contact"] = $result1["contact"];
                $response["name"] = $result1["firstName"] . " " . $result1["middleName"];
                $response["mailid"] = $result1["emailId"];
                $response["progName"] = $result1["program_name"];
                $response["dedicatedEmail"] = $result1["dedicated_mail"];
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Client id or Employee id is incorrect";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function merchantFeedback($clientid, $employeeid) {

        try {

            $query = "select Tbl_ClientDetails_Master.*,Tbl_EmployeeDetails_Master.* from Tbl_EmployeeDetails_Master join Tbl_ClientDetails_Master on Tbl_ClientDetails_Master.client_id = Tbl_EmployeeDetails_Master.clientId where Tbl_EmployeeDetails_Master.clientId =:cli and Tbl_EmployeeDetails_Master.employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result1) {
                $response["success"] = 1;
                $response["message"] = "Your merchant feedback sent successfully";
                //$response["mailid"]=$result1["emailId"];
                $response["name"] = $result1["firstName"] . " " . $result1["middleName"];
                $response["mailid"] = $result1["emailId"];
                $response["progName"] = $result1["program_name"];
                $response["dedicatedEmail"] = $result1["dedicated_mail"];
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Client id or Employee id is incorrect";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

}

?>