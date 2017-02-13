<?php
error_reporting(E_ALL);
include_once('class_connect_db_Communication.php');

class Getaward {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    /*     * *************************  Fetch data from Award Master ************************************* */

    function getAllAward($clientid) {
        $a = "nothing";
        try {
            $query = "call SP_getAwardList(:clientid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':clientid', $clientid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                echo "<pre>";
//                print_r($rows);

                if ($rows) {
                    $response["success"] = 1;
                    $response["Data"] = $rows;
                    $a = json_encode($response);
                }
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $e->getMessage();
            $a = json_encode($response);
        }
        return($a);
    }

//------------------------end of getallawards function

    function getAllAwardListDetails($awardid) {

        //echo $awardid;
        $a = "nothing";
        try {
            $query = "call SP_getAwardListDetails(:awardid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':awardid', $awardid, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                //echo "<pre>";
                //print_r($row);

                if ($row) {
                    $response["success"] = 1;
                    $response["Data"] = $row;
                    $a = json_encode($response);
                }
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $e->getMessage();
            $a = json_encode($response);
        }
        return($a);
    }

    /*     * ******************************************* view employee award list ************************************** */

    function viewemployeeawardlist($clientid) {
        $a = "nothing";
        try {
            $query = "call SP_getEmployeeAwardList(:clientid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':clientid', $clientid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($rows) {
                    $response["success"] = 1;
                    $response["Data"] = $rows;
                    $a = json_encode($response);
                }
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $e->getMessage();
            $a = json_encode($response);
        }
        return($a);
    }

    /*     * ***************************************** end of view employee award list *********************************** */

    /*     * *************************Fetch one employee award details from database********************************** */

    function selectemployeeawarddetails($employeeawardid) {
        $m_msg = "";
        try {
            $query = "call SP_getEmployeeawardDetails(:employeeawardid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':employeeawardid', $employeeawardid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $rows = $stmt->fetch();
                if ($rows) {
                    $response["success"] = 1;
                    $response["Data"] = $rows;
                    $m_msg = json_encode($response);
                }
            }
        } catch (PDOException $e) {
            $m_msg = "Database Error!" . $e->getMessage();
        }
        return $m_msg;
    }

    /*     * ************************* Fetch one employee award details from database end********************************** */
}

// end of class


//$object = new Getaward();
//$res = $object->getAllAwardListDetails();