<?php

include("../../Class_Library/Api_Class/class_family.php");

if (!class_exists("Connection_Communication")) {
    require_once('class_connect_db_Communication.php');
}

class Profile {

    public $DB;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->DB = $dbh->getConnection_Communication();
    }

    public function profile_update($userArr) {
        extract($userArr);

        $name = explode(' ', $name);
        $first_name = $name[0];
        $last_name = $name[1];
        if ($linkedin == "0") {
            $family = new Family();
            $dname = $family->randomNumber(6);
            $user_image = $family->userImageUpload($clientid, $user_image, $uuid, $dname);
        }
        try {
            $query = "UPDATE Tbl_EmployeeDetails_Master AS emp_master JOIN Tbl_EmployeePersonalDetails AS emp_personal ON emp_master.employeeId = emp_personal.employeeId SET emp_master.firstName=:first_name , emp_master.lastName=:last_name, emp_personal.linkedIn='".$linkedin."' ";
            if ($linkedin == "1") {
                $query .= ", emp_personal.userImage='".$user_image."' ";
            }
            $query .= ",emp_master.location=:location , emp_master.designation=:designation, emp_personal.userCompanyname=:company_name WHERE emp_master.clientId=:cid AND emp_master.employeeId=:uid";
            
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $uuid, PDO::PARAM_STR);
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':designation', $designation, PDO::PARAM_STR);
            $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return true;
            } else {
                echo "query wrong";
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

}

?>