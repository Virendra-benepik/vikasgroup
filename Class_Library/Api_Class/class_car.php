<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (!class_exists("Connection_Communication")) {
    include_once('../../Class_Library/Api_Class/class_connect_db_Communication.php');
}
require_once('class_bank.php');
require_once('class_family.php');

class Car {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function addCar($clientid, $employeeid, $carModel, $modelNo, $RegisNo, $name) {
        
        date_default_timezone_set('Asia/Kolkata');
        $_date = date('Y-m-d H:i:s');
        try {
            $max = "select max(autoId) from Tbl_EmployeeCarDetails";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $c_id = $tr[0];
                $c_id1 = $c_id + 1;
                $carid = "CAR-" . $c_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        try {

            $query = "select * from Tbl_EmployeeDetails_Master where clientId =:cli and employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);
          
            if ($result1) {
                $query = "insert into Tbl_EmployeeCarDetails (carId,clientId,emailId,employeeId,carModel,modelNo,registrationNo,ownerName,insertedDate,insertedBy) values(:bd,:cli,:eml,:empid,:bnam,:ifs,:ano,:cnam,:insdte,:insby)";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':bd', $carid, PDO::PARAM_STR);
                $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                 $stmt->bindParam(':eml', $result1['emailId'], PDO::PARAM_STR);
                $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                $stmt->bindParam(':bnam', $carModel, PDO::PARAM_STR);
                $stmt->bindParam(':ifs', $modelNo, PDO::PARAM_STR);
                $stmt->bindParam(':ano', $RegisNo, PDO::PARAM_STR);
                $stmt->bindParam(':cnam', $name, PDO::PARAM_STR);
                 $stmt->bindParam(':insdte', $_date, PDO::PARAM_STR);
                  $stmt->bindParam(':insby', $employeeid, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $info = self::GetCars($clientid, $employeeid);

                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Car details added successfully";
                    $response["car"] = $info;
                    $response["bank"] = (new Bank())->GetFromBank($clientid, $employeeid);
                    $response["family"] = (new Family())->getFamilyDetails($employeeid);
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "No Car details added";
                }
                return $response;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Client id or employeeId is incorrect";
                return $response;
            }
        } catch (PDOException $e) {
            /* echo $e;
              trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
             */

            $response = array();
            $response["success"] = 0;
            $response["message"] = "Registration No. already exists here";
            return $response;
        }
    }

    /*     * **************************************************************************************************** */

    function GetCars($clientid, $employeeid) {

        try {
            $query = "select Tbl_EmployeeCarDetails.*,DATE_FORMAT(Tbl_EmployeeCarDetails.insertedDate,'%d %b %Y %h:%i %p') as insertedDate from Tbl_EmployeeCarDetails join Tbl_EmployeeDetails_Master on Tbl_EmployeeCarDetails.employeeId = Tbl_EmployeeDetails_Master.employeeId where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeeDetails_Master.employeeId=:empid and Tbl_EmployeeCarDetails.clientId=:cli order by Tbl_EmployeeCarDetails.autoId desc";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {

                $response = array();
                $response["success"] = 1;
                $response["message"] = "Car details display successfully";
                $response["posts"] = $result;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No Car details displayed";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function updateCar($clientid, $employeeid, $carid, $carModel, $modelNo, $RegisNo, $name) {
         date_default_timezone_set('Asia/Kolkata');
        $_date1 = date('Y-m-d H:i:s');

        try {

            $query = "select Tbl_EmployeeCarDetails.* from Tbl_EmployeeCarDetails join Tbl_EmployeeDetails_Master on  Tbl_EmployeeCarDetails.employeeId =  Tbl_EmployeeDetails_Master.employeeId
where Tbl_EmployeeDetails_Master.clientId =:cli and Tbl_EmployeeDetails_Master.employeeId=:empid and Tbl_EmployeeCarDetails.carId=:idcar";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':idcar', $carid, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if ($result1) {
                $query = "update Tbl_EmployeeCarDetails set carModel=:bnam,modelNo=:ifs,registrationNo=:ano,ownerName=:cnam,updatedDate=:udte,updatedBy=:uby where clientId=:cli and employeeId=:empid and carId=:bd ";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':bd', $carid, PDO::PARAM_STR);
                $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                $stmt->bindParam(':bnam', $carModel, PDO::PARAM_STR);
                $stmt->bindParam(':ifs', $modelNo, PDO::PARAM_STR);
                $stmt->bindParam(':ano', $RegisNo, PDO::PARAM_STR);
                $stmt->bindParam(':cnam', $name, PDO::PARAM_STR);
                $stmt->bindParam(':udte', $_date1, PDO::PARAM_STR);
                $stmt->bindParam(':uby', $employeeid, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Car details updated successfully";
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "No Car details updated";
                }
                return $response;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Client id or employeeId or Car id is incorrect";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function deleteCar($clientid, $employeeid, $carid) {

        try {

            $query = "select Tbl_EmployeeCarDetails.* from Tbl_EmployeeCarDetails join Tbl_EmployeeDetails_Master where Tbl_EmployeeDetails_Master.clientId =:cli and Tbl_EmployeeDetails_Master.employeeId=:empid and Tbl_EmployeeCarDetails.carId=:idcar";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':idcar', $carid, PDO::PARAM_STR);

            $stmt->execute();
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result1) {
                $query = "delete from Tbl_EmployeeCarDetails where clientId=:cli and employeeId=:empid and carId=:bd";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':bd', $carid, PDO::PARAM_STR);
                $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $info = self::GetCars($clientid, $employeeid);
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Car details deleted successfully";
                    $response["car"] = $info;
                    $response["bank"] = (new Bank())->GetFromBank($clientid, $employeeid);
                    $response["family"] = (new Family())->getFamilyDetails($employeeid);
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "No Car details deleted";
                }
                return $response;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Client id or employeeId or Car id is incorrect";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

}

?>