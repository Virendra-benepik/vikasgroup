<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (!class_exists("Connection_Communication")) {
    include_once('../../Class_Library/Api_Class/class_connect_db_Communication.php');
}

class Family {

    public $db_connect;

    // public $db_analysis;

    public function __construct() {
        $dbh = new Connection_Communication(/* ... */);
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function getUserDetail($clientid, $uuid) {
        try {
            $query = "select firstName from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $response["success"] = 1;
                $response["userName"] = $row;
            } else {
                $response["success"] = 0;
                $response["userName"] = "User doesn't exist";
            }
            return $response;
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    function getUserDetails($clientid, $uuid) {
        try {
            $query = "select Tbl_EmployeeDetails_Master.firstName,Tbl_EmployeeDetails_Master.middleName,Tbl_EmployeeDetails_Master.lastName, concat('http://admin.benepik.com/employee/virendra/benepik_admin/',Tbl_EmployeePersonalDetails.userImage) as userImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeeDetails_Master.employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $response["success"] = 1;
                $response["Tbl_EmployeeDetails_Master"] = $row;
            } else {
                $response["userName"] = "User doesn't exist";
            }
            return $response;
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    function getUsers($clientid, $uuid, $sperson) {
        $this->idclient = $clientid;
        $this->sperson = $sperson;
        $this->iduuid = "%" . $uuid . "%";
        try {
            $query = "select Tbl_EmployeeDetails_Master.employeeId, Tbl_EmployeeDetails_Master.firstName, Tbl_EmployeeDetails_Master.middleName, Tbl_EmployeeDetails_Master.lastName,Tbl_EmployeeDetails_Master.location,Tbl_EmployeeDetails_Master.designation, concat('http://admin.benepik.com/employee/virendra/benepik_admin/',Tbl_EmployeePersonalDetails.userImage) as userImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId!=:sprson and Tbl_EmployeeDetails_Master.clientId=:cli and (Tbl_EmployeeDetails_Master.employeeCode like '" . $this->iduuid . "' or Tbl_EmployeeDetails_Master.firstName like '" . $this->iduuid . "') ";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':sprson', $this->sperson, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($row) {
                $response["success"] = 1;
                $response["message"] = "Users are displayin here";
                $response["users"] = $row;
            } else {
                $response["success"] = 0;
                $response["message"] = "Users don't exist here";
                $response["users"] = $row;
            }
            return $response;
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************************************************************************************* */

    function insertUserRecognition($clientid, $recognitionto, $recognitionby, $topic, $title, $mesg, $points) {
        date_default_timezone_set('Asia/Calcutta');
        $da = date('Y-m-d, h:i:s');
        $status = "Pending";

        try {
            $max = "select max(autoId) from Tbl_RecognizedEmployeeDetails";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $recogid = "Recognition-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        $recognizeto = self::getUserDetails($clientid, $recognitionto);
        /* echo "<pre>";
          print_r($recognizeto);
          echo "</pre>"; */
        $rto = $recognizeto['Tbl_EmployeeDetails_Master']['firstName'] . " " . $recognizeto['Tbl_EmployeeDetails_Master']['lastName'];
        $recognizeby = self::getUserDetails($clientid, $recognitionby);
        /* echo "<pre>";
          print_r($recognizeby);
          echo "</pre>"; */
        $rby = $recognizeby['Tbl_EmployeeDetails_Master']['firstName'] . " " . $recognizeby['Tbl_EmployeeDetails_Master']['lastName'];
        try {
            $query = "insert into Tbl_RecognizedEmployeeDetails(recognitionId,clientId,recognitionBy,recognitionTo,topic,text,title,dateOfEntry,status,points) values(:reg,:cli,:rby,:rto,:top,:txt,:tit,:dat,:sta,:pts)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':reg', $recogid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':rby', $recognitionby, PDO::PARAM_STR);
            $stmt->bindParam(':rto', $recognitionto, PDO::PARAM_STR);
            $stmt->bindParam(':top', $topic, PDO::PARAM_STR);
            $stmt->bindParam(':txt', $mesg, PDO::PARAM_STR);
            $stmt->bindParam(':tit', $title, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $da, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
            $stmt->bindParam(':pts', $points, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $to = 'virendra@benepik.com';
                $subject = 'Request for Recognisation Approval';
                $from = 'info@benepik.com';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email messag
                $message = '<html><body>';
                $message .= '<h3>Dear Sir</h3>';
                $message .= '<p><b>' . $rby . '</b> recognize to <b> ' . $rto . '</b></p>';
                $message .= '<p><b>Topic</b> : ' . $topic . '</p>';
                $message .= '<p><b>Title </b> : ' . $title . '</p>';
                $message .= '<p><b>Comment </b> : ' . $mesg . '</p><br><br>';

                $message .= '<p>Thanks</p>';
                $message .= '<p>Benepik Team</p>';

                $message .= '</body></html>';

                if (mail($to, $subject, $message, $headers)) {

                    // echo 'Your mail has been sent successfully.';
                } else {

                    // echo 'Unable to send email. Please try again.';
                }


                $response = array();
                $response["success"] = 1;
                $response["message"] = "Data inserted successfully";
                return $response;
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
            echo 'Unable to send email. Please try again.';
        }
    }

    function entryFamily($empid, $fnam, $mnam, $snam, $cname) {

        $this->employeeid = $empid;
        $this->fname = $fnam;
        $this->mname = $mnam;
        $this->sname = $snam;
        $this->childrenName = $cname;
        
         date_default_timezone_set('Asia/Kolkata');
        $_date = date('Y-m-d H:i:s');

        try {
            $query = "update Tbl_EmployeePersonalDetails set userFatherName=:fnam, userMotherName=:mnam, userSpouseName=:snam,childrenName=:children,updatedDate = :udte,updatedBy=:uby where employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $this->employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':fnam', $this->fname, PDO::PARAM_STR);
            $stmt->bindParam(':mnam', $this->mname, PDO::PARAM_STR);
            $stmt->bindParam(':snam', $this->sname, PDO::PARAM_STR);
            $stmt->bindParam(':children', $this->childrenName, PDO::PARAM_STR);
             $stmt->bindParam(':udte', $_date, PDO::PARAM_STR);
              $stmt->bindParam(':uby', $this->employeeid, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $response = array();
                $response["success"] = 1;
                $response["message"] = "Data inserted successfully";
                return $response;
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    function RemoveFamilyDetails($employeeid, $dealid, $branchid) {

        try {
            $query = "delete from BranchWish where branchid=:bri and dealid=:dli and emailid=:emi";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':bri', $branchid, PDO::PARAM_STR);
            $stmt->bindParam(':dli', $dealid, PDO::PARAM_STR);
            $stmt->bindParam(':emi', $employeeid, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Remove Deal from Favourite successfully";
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No action perform";
            }

            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getPersonalDetails($eId) {
        $site_url = site_url;
        $this->eId = $eId;
        try {
            $query = "select edm.department,edm.contact,edm.designation,edm.location,edm.branch,edm.grade,edm.firstName,edm.middleName,edm.lastName,edm.companyName from Tbl_EmployeeDetails_Master as edm join Tbl_EmployeePersonalDetails as epd on edm.employeeId = epd.employeeId where edm.employeeId =:eid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':eid', $this->eId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            $filterdArray = array_filter($rows);

            if (array_filter($rows)) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Peesonal Details Found Displaying";
                $response["posts"] = $rows;
                return $response;
            } else if (!array_filter($rows)) {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No Details Found For Personal Details";
                return $response;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Email id dosn't found";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
	function getFamilyDetails($mailId) {
        $site_url = site_url;
        $this->emailId = $mailId;
        try {
            $query = "select if(userImage = '' or userImage is NULL, '',CONCAT('$site_url',userImage)) as userImage,userFatherName,userMotherName,userSpouseName,childrenName,userDOB,emailId from Tbl_EmployeePersonalDetails where employeeId =:mail";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':mail', $this->emailId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            $filterdArray = array_filter($rows);

            if (array_filter($rows)) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Family Details Found Displaying";
                $response["posts"] = $rows;
                return $response;
            } else if (!array_filter($rows)) {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No Details Found For Family Details";
                return $response;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Email id dosn't found";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function randomNumber($length) {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    function getRecognisedUser($clientid, $uuid, $value) {
        $this->value = $value;
        $sts = "Approve";
        try {
            $query1 = "select * from Tbl_RecognizedEmployeeDetails where status =:sts and clientId=:cli order by autoId desc limit " . $this->value . ",5";
            $stmt1 = $this->db_connect->prepare($query1);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sts', $sts, PDO::PARAM_STR);
            $stmt1->execute();
            $rows1 = $stmt1->fetchAll();

            $query2 = "select count(recognitionTo) as total_recognitions from Tbl_RecognizedEmployeeDetails where clientId=:cli and status=:sts";
            $stmt2 = $this->db_connect->prepare($query2);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt2->bindParam(':sts', $sts, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (count($rows1) > 0) {
                $response["success"] = 1;
                $response["message"] = "Recognised data available here";
                $response["total_recognitions"] = $rows2["total_recognitions"];
                $response["posts"] = array();

                foreach ($rows1 as $row) {
                    $post["recognitionId"] = $row["recognitionId"];
                    $post["recognitionBy"] = $row["recognitionBy"];

                    $recognitionBy = $row["recognitionBy"];
                    $user = self::getUserDetails($clientid, $recognitionBy);
                    $post["recognitionByName"] = $user[Tbl_EmployeeDetails_Master][firstName] . " " . $user[Tbl_EmployeeDetails_Master][lastName];
                    $post["recognitionByImage"] = $user[Tbl_EmployeeDetails_Master][userImage];

                    $post["recognitionTo"] = $row["recognitionTo"];
                    $recognitionTo = $row["recognitionTo"];
                    $user = self::getUserDetails($clientid, $recognitionTo);
                    $post["recognitionToName"] = $user[Tbl_EmployeeDetails_Master][firstName] . " " . $user[Tbl_EmployeeDetails_Master][lastName];

                    $namefirst = $user[Tbl_EmployeeDetails_Master][firstName];
                    $namesecond = $user[Tbl_EmployeeDetails_Master][lastName];

                    $post["recognitionShortName"] = $namefirst[0] . " " . $namesecond[0];
                    $post["recognitionToImage"] = $user[Tbl_EmployeeDetails_Master][userImage];

                    $query2 = "select count(recognitionTo) as total_approve from Tbl_RecognizedEmployeeDetails where clientId=:cli and recognitionTo=:rec and status = :sta";
                    $stmt2 = $this->db_connect->prepare($query2);
                    $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
                    $stmt2->bindParam(':rec', $recognitionTo, PDO::PARAM_STR);
                    $stmt2->bindParam(':sta', $sts, PDO::PARAM_STR);
                    $stmt2->execute();
                    $rows21 = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $post["TotalApprove"] = $rows21["total_approve"];
                    $post["topic"] = $row["topic"];
                    $post["title"] = $row["title"];
                    $post["text"] = $row["text"];
                    $d1 = $row["dateOfEntry"];
                    $date = date_create($d1);
                    $post["dateOfEntry"] = date_format($date, "d M Y H:i A");

                    array_push($response["posts"], $post);
                }
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "No More Posts Available";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ****************************************************************************************************************************************************************** */

    function userImageUpload($clientid, $baseimage, $uuid, $dname) {
        $this->idclient = $clientid;
        $this->imgpath = $baseimage;
        $this->employeeid = $uuid;
        $this->number = $dname;

        if ($this->imgpath != "") {
            $data = base64_decode($this->imgpath);

            $img = imagecreatefromstring($data);

            if ($img != false) {
                $imgpath = base_path . '/Client_img/user_img/' . $this->number . '.jpg';
                imagejpeg($img, $imgpath); //for converting jpeg of image

                $imgpath1 = 'Client_img/user_img/' . $this->number . '.jpg';
            }
        } else {
            $this->imgpath = "";
            $imgpath1 = "";
        }

        try {
            $query = "update Tbl_EmployeePersonalDetails set userImage =:img where employeeId=:uid and clientId=:cli";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':img', $imgpath1, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response = array();

                if ($imgpath1 != "") {
                    $response["success"] = 1;
                    $response["userImage"] = site_url . $imgpath1;
                    $response["message"] = "image updated successfully";
                } else {
                    $response["success"] = 0;
                    $response["userImage"] = "";
                    $response["message"] = "image update failed";
                }
                return json_encode($response);
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

}

?>