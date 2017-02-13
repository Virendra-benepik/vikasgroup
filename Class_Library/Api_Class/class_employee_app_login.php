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

    function detectValidUser($packageName = '', $username, $password) {
//        echo "pack-".$packageName."\n";
//        echo "use=".$username."\n";
//       echo "passs-".$password."\n";
        try {
            $query = "select udp.userDOB,udp.userFatherName,udp.userMothername,udp.userSpouseName,udp.childrenName,ud.accessibility, bcd.defaultLocation, bcd.client_id,bcd.androidAppVersion,bcd.iosAppVersion, ASCII(SUBSTRING(bcd.defaultLocation, 1, 1)) as cityCode,bcd.clientType,if(bcd.logoImageName IS NULL or bcd.logoImageName='', '', concat('" . site_url . "',bcd.logoImageName)) as  logoImageName,if(bcd.welcomeImageName IS NULL or bcd.welcomeImageName='', '', concat('" . site_url . "',bcd.welcomeImageName)) as welcomeImageName,bcd.googleApiKey,ud.employeeId,ud.firstName,ud.middleName,ud.lastName,ud.emailId,ud.validity,ud.department,ud.designation, if(udp.userImage IS NULL or udp.userImage='','', concat('" . site_url . "',udp.userImage)) as  userImage from Tbl_EmployeeDetails_Master as ud join  Tbl_ClientDetails_Master as bcd on bcd.client_id = ud.clientId join Tbl_EmployeePersonalDetails as udp on udp.employeeId = ud.employeeId where (UPPER(ud.employeeCode)=:ecode or ud.contact=:ecode) and ud.password = :password and ud.status = 'Active' and bcd.status = 'Active'";

            $password1 = md5($password);
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':ecode', trim(strtoupper($username)), PDO::PARAM_STR);
            $stmt->bindParam(':password', trim($password1), PDO::PARAM_STR);
          //  $stmt->bindParam(':pack',trim(strtoupper($packageName)), PDO::PARAM_STR);
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
            return $response;
        }
    }

    /*     * ****************************** this is for force update ******************************** */
    
    function forceValidUserUpdation($clientid, $uid) {
        //  echo "client id = ".$clientid;
        // echo "user id -".$uid;
        try {
            $query = "select ud.firstName,bcd.client_id, ASCII(SUBSTRING(bcd.defaultLocation, 1, 1)) as cityCode,epd.userFatherName,epd.userMotherName,epd.userSpouseName,epd.childrenName,epd.userCompanyname, concat('" . site_url . "',epd.userImage) as  userImage,bcd.iosAppVersion,bcd.androidAppVersion,epd.userDOB,epd.emailId, ud.accessibility, ud.employeeCode, ud.validity from Tbl_EmployeeDetails_Master as ud join  Tbl_ClientDetails_Master as bcd on bcd.client_id = ud.clientId join Tbl_EmployeePersonalDetails as epd where ud.employeeId =:uid and ud.status = 'Active' and bcd.status = 'Active' and bcd.client_id = :cid and epd.clientId = :cid and epd.employeeId = :uid";

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // print_r($result);
                $ert = count($result);
                //  echo "ert = ".$ert;
                if ($ert > 0) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Yes $userEmail is a valid User";
                    $response["version"] = $result[0]["androidAppVersion"];
                    $response["iosversion"] = $result[0]["iosAppVersion"];

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

    /*     * ************************************************************************************************ */
    /*
      function detectValidUser1($packageName,$userEmail)
      {

      try
      {
      $query = "select udp.userDOB,udp.userFatherName,udp.userMothername,udp.userSpouseName,udp.childrenName,ud.accessibility, bcd.defaultLocation, bcd.client_id, ASCII(SUBSTRING(bcd.defaultLocation, 1, 1)) as cityCode,bcd.clientType,concat('http://admin.benepik.com/employee/virendra/benepik_admin/',bcd.logoImageName) as  logoImageName,concat('http://admin.benepik.com/employee/virendra/benepik_admin/',bcd.welcomeImageName) as welcomeImageName,ud.employeeId,ud.firstName,ud.middleName,ud.lastName,ud.emailId,ud.employeeCode,ud.validity,ud.department,ud.designation, concat('http://admin.benepik.com/employee/virendra/benepik_admin/',udp.userImage) as  userImage from UserDetails as ud join  B_Client_Data as bcd on bcd.client_id = ud.clientId join UserPersonalDetails as udp on udp.employeeId = ud.employeeId where ud.employeeId= :email and ud.status = 'Active' and bcd.status = 'Active' and bcd.packageName = :package";

      $stmt = $this->db_connect->prepare($query);
      $stmt->bindParam(':email',$userEmail, PDO::PARAM_STR);
      $stmt->bindParam(':package',$packageName, PDO::PARAM_STR);
      if($stmt->execute())
      {
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result)
      {
      $response = array();
      $response["success"] = 1;
      $response["message"] = "Yes $userEmail is a valid User";
      $response["posts"] = $result;
      $response["packageName"] = $packageName;
      $response["uuid"] = $userEmail;
      }
      else{
      $response = array();
      $response["success"] = 0;
      $response["message"] = "No password found with this email";
      $response["packageName"] = $packageName;
      $response["uuid"] = $userEmail;

      }

      return $response;
      }

      }      //--------------------------------------------- end of try block
      catch(PDOException $e)
      {
      $response["success"] = 0;
      $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
      $response["posts"] = $e;
      return $response;

      }

      } */

    /*     * **********************insert login details for analytics ********************************** */

    function entryUserLogin($packageName, $employeeID, $device) {
        date_default_timezone_set('Asia/Calcutta');
        $login_date = date('Y-m-d H:i:s');

        try {
            $query = "insert into Tbl_Analytic_LoginDetails(employeeId,packageName,device,dateEntry) values(:empid,:packnam,:dev,:dat)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $employeeID, PDO::PARAM_STR);
            $stmt->bindParam(':packnam', $packageName, PDO::PARAM_STR);
            $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $login_date, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>