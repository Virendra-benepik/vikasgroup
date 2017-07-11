<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('class_connect_db_Communication.php');

class ForgotPassword {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function forgotPasswordSentTo($packName, $empcode) 
                {
        //$username = strtoupper($username);
        try {
            $query = "select ud.firstName, ud.middleName, ud.lastName, ud.emailId, ud.contact,ud.employeeId,ud.employeeCode,cd.dedicated_mail,cd.client_id,cd.responseDecider,cd.program_name from Tbl_ClientDetails_Master as cd join Tbl_EmployeeDetails_Master as ud where cd.packageName=:package and cd.client_id= ud.clientId and (UPPER(ud.employeeCode)=:empcode)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empcode', $empcode, PDO::PARAM_STR);
            $stmt->bindParam(':package', $packName, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
              // print_r($result);die;
                if ($result) 
                    {
                    if ($result["responseDecider"] == 3 && !empty($result["emailId"])) {

                       // $randomAlpha = self::randomalpha(6);
                        $randomDigit = self::randomdigit(6);
                        $randompassword = $randomDigit;
                       

                        $md5password = md5($randompassword);

                        $clientId = $result["client_id"];
                        $uui = $result["employeeId"];

                        $query = "update Tbl_EmployeeDetails_Master set password=:pass where clientId=:cli and employeeId=:emi and (UPPER(employeeCode)=:empcode)";
                        $stmt = $this->db_connect->prepare($query);
                        $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                        $stmt->bindParam(':emi', $uui, PDO::PARAM_STR);
                        $stmt->bindParam(':empcode', $empcode, PDO::PARAM_STR);
                        $stmt->bindParam(':pass', $md5password, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            $response = array();
                            $response["success"] = 1;
                            $response["message"] = "Your Latest Password sent to Your Email Id and Mobile no.";
                            $response["progName"] = $result["program_name"];
                           // $response["name"] = $result["firstName"] . " " . $result["middleName"] . " " . $result["lastName"];
						   $response["name"] = $result["firstName"];
                            $response["password"] = $randompassword;
                            $response["decider"] = $result["responseDecider"];
                            $response["emailId"] = $result["emailId"];
                            $response["contact"] = $result["contact"];
                            $response["dedicated_mail"] = $result["dedicated_mail"];
                        } else {
                            $response = array();
                            $response["success"] = 0;
                            $response["message"] = "Not updated";
                        }
                    } else {
                        $response = array();
                        $response["success"] = 0;
                        $response["message"] = "Please register with vikas live first. ";
                    }
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "Employee Code is incorrect ";
                }
            }

            return $response;
        }
        //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
            $response["posts"] = $e;
            return $response;
        }
    }

    /*     * ************************************************************************************************* */

    function randomalpha($length) {
        $alphabet = "abcdefghijklmnopqrstuwxyz";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function randomdigit($length) {
        $alphabet = "123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /*     * ************************************************************************************************** */

    function resetPassword($clientid, $uui, $oldp, $newp, $confirmp) {

        $md5password = md5($confirmp);
        $oldpass = md5($oldp);

        try {
            $query = "select Tbl_EmployeeDetails_Master.password from Tbl_EmployeeDetails_Master join Tbl_ClientDetails_Master on Tbl_ClientDetails_Master.client_id = Tbl_EmployeeDetails_Master.clientId where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeeDetails_Master.employeeId=:empi";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empi', $uui, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $pa = $result['password'];
                if ($newp == $confirmp) {

                    if ($oldpass == $pa) {

                        $query = "update Tbl_EmployeeDetails_Master set password=:pass where clientId=:cli and employeeId=:emi and password=:carrypass";
                        $stmt = $this->db_connect->prepare($query);
                        $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                        $stmt->bindParam(':emi', $uui, PDO::PARAM_STR);
                        $stmt->bindParam(':pass', $md5password, PDO::PARAM_STR);
                        $stmt->bindParam(':carrypass', $pa, PDO::PARAM_STR);

                        if ($stmt->execute()) {
                            $response = array();
                            $response["success"] = 1;
                            $response["message"] = "Your password reset successfully";
                            return $response;
                        }
                    } else {
                        $response = array();
                        $response["success"] = 0;
                        $response["message"] = "Old Password not matched";
                        return $response;
                    }
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "New and Confirm Password do not match";
                    return $response;
                }
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Client id or Employee id is incorrect";
                return $response;
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
            $response["posts"] = $e;
            return $response;
        }
    }

}

?>