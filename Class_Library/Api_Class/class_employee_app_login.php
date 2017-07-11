<?php

require_once('class_connect_db_Communication.php');

class LoginUser {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    /*     * ************************* This Method Detects Whether The User Is Valid Or Not If he is valid  ************************************* */

    /*     * ************************* dIf Valid the Api Returns the data of user needed by client  ************************************* */

    function detectValidUser($packageName, $username, $password, $usertype) {
//        echo "pack-".$packageName."\n";
//        echo "use=".$username."\n";
//       echo "passs-".$password."\n";
        if (!empty($usertype)) {
            try {
                $query = "select ud.log_status,udp.userDOB,udp.userFatherName,udp.userMothername,udp.userSpouseName,udp.childrenName,ud.accessibility, bcd.client_id,bcd.androidAppVersion,bcd.iosAppVersion, ASCII(SUBSTRING(bcd.defaultLocation, 1, 1)) as cityCode,bcd.clientType,if(bcd.logoImageName IS NULL or bcd.logoImageName='', '', concat('" . site_url . "',bcd.logoImageName)) as  logoImageName,if(bcd.welcomeImageName IS NULL or bcd.welcomeImageName='', '', concat('" . site_url . "',bcd.welcomeImageName)) as welcomeImageName,bcd.googleApiKey,ud.employeeId,ud.firstName,ud.middleName,ud.lastName,ud.emailId,ud.validity,ud.department,ud.designation,ud.contact,ud.companyName, ud.location as defaultLocation, if(udp.userImage IS NULL or udp.userImage='','', concat('" . site_url . "',udp.userImage)) as  userImage from Tbl_EmployeeDetails_Master as ud join  Tbl_ClientDetails_Master as bcd on bcd.client_id = ud.clientId join Tbl_EmployeePersonalDetails as udp on udp.employeeId = ud.employeeId where ((UPPER(ud.employeeCode)=:ecode) or (UPPER(ud.emailId)=:ecode)) and ud.password = :password and ud.status = 'Active' and bcd.status = 'Active' and bcd.packageName= :pack";

                if ($usertype == "Guest") {
                    $query .= " and ud.accessibility='guestuser'";
                } else {
                    $query .= " and (ud.accessibility='User' or ud.accessibility='SubAdmin' or ud.accessibility='Admin')";
                }

                $username1 = strtoupper(trim($username));
                $password1 = md5(trim($password));
                $packageName = strtoupper(trim($packageName));
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':ecode', $username1, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password1, PDO::PARAM_STR);
                $stmt->bindParam(':pack', $packageName, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                   // print_r($result);die;
                    if ($result) {
                        $response = array();
                        $response["success"] = 1;
                        $response["message"] = "Yes $username is a valid User";
                        $response["posts"] = $result;
                    } else {
                        $response = array();
                        $response["success"] = 0;
                        $response["message"] = "Incorrect username or password";
                    }

                    return $response;
                } else {
                    echo "query wrong";
                }
            }      //--------------------------------------------- end of try block
            catch (PDOException $e) {
                $response["success"] = 0;
                $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
                $response["posts"] = $e;
            }
        } else {
            $response["success"] = 0;
            $response["message"] = "Usertype not defined";
        }
        return $response;
    }

    /*     * ****************************** this is for force update ******************************** */

    function forceValidUserUpdation($clientid, $uid) {
        //  echo "client id = ".$clientid;
        // echo "user id -".$uid;
        try {
            $query = "select ud.firstName,ud.log_status,bcd.client_id, ASCII(SUBSTRING(bcd.defaultLocation, 1, 1)) as cityCode,epd.userFatherName,epd.userMotherName,epd.userSpouseName,epd.childrenName,ud.companyName, if(epd.userImage IS NULL or epd.userImage='','',concat('" . site_url . "',epd.userImage)) as  userImage,bcd.iosAppVersion,bcd.androidAppVersion,epd.userDOB,epd.emailId, ud.accessibility, ud.employeeCode, ud.validity from Tbl_EmployeeDetails_Master as ud join  Tbl_ClientDetails_Master as bcd on bcd.client_id = ud.clientId join Tbl_EmployeePersonalDetails as epd where ud.employeeId =:uid and ud.status = 'Active' and bcd.status = 'Active' and bcd.client_id = :cid and epd.clientId = :cid and epd.employeeId = :uid";

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //  print_r($result);
                $ert = count($result);
                //  echo "ert = ".$ert;
                if ($ert > 0) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Yes $userEmail is a valid User";
                    $response["version"] = $result[0]["androidAppVersion"];
                    $response["iosversion"] = $result[0]["iosAppVersion"];
                    $response["log_status"] = $result[0]["log_status"];

                    $response["posts"] = $result;
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "No password found with this email";
                }
                // print_r($response);
                return $response;
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
            $response["posts"] = $e;
            return $response;
        }
    }


    /*     * **********************insert login details for analytics ********************************** */

    function entryUserLogin($packageName, $employeeID, $device, $deviceId) {
        date_default_timezone_set('Asia/Kolkata');
        $login_date = date('Y-m-d H:i:s');
        $status = '1';

        try {
            $query = "update Tbl_EmployeeDetails_Master set log_status = :status where employeeId = :empId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empId', $employeeID, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        try {
            $query = "insert into Tbl_Analytic_LoginDetails(employeeId, packageName, device, dateEntry, deviceId, log_status) values(:empid, :packnam, :dev, :dat, :devId, :status)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $employeeID, PDO::PARAM_STR);
            $stmt->bindParam(':packnam', $packageName, PDO::PARAM_STR);
            $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            $stmt->bindParam(':devId', $deviceId, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $login_date, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function updateUserLogin($packageName, $employeeID, $device, $deviceId) {
        date_default_timezone_set('Asia/Kolkata');
        $logout_date = date('Y-m-d H:i:s');
        $status = '0';
        try {
            $query = "update Tbl_EmployeeDetails_Master set log_status = :status where employeeId = :empId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empId', $employeeID, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        try {
            $query = "update Tbl_Analytic_LoginDetails set log_status=:status, dateExit=:dat where deviceId=:devId and device=:dev and employeeID=:empid and packageName=:packnam";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $employeeID, PDO::PARAM_STR);
            $stmt->bindParam(':packnam', $packageName, PDO::PARAM_STR);
            $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            $stmt->bindParam(':devId', $deviceId, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $logout_date, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            
            if($stmt->execute()){
               $response['success'] = 1;
	       $response['message'] = "You have successfully logged out";
	    }else{
	    	$response['success'] = 0;
  	        $response['message'] = "Log out failed";
	    }
        } catch (PDOException $e) {
            echo $e;
        }

        return $response;
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
        } catch (PDOException $e) {
            echo $e;
        }
    }
}

?>
