<?php

include_once('class_connect_db_Communication.php');
include_once('class_user_profile.php');

class Complaint {

    public function __construct() {
        $db = new Connection_Communication();
        $this->db_connect = $db->getConnection_Communication();
    }

    /*     * ************************* Complaint details data into database  ************************************* */

    function entryComplaint($cid, $employeeid, $con, $status, $isAnonymous, $device) {
        $this->client_id = $cid;
        $this->content = $con;
        $this->status = $status;
        $this->isAnonymous = $isAnonymous;
        $this->device = $device;

        $user_obj = new Profile();
        $resJson = $user_obj->getuserprofile($cid, $employeeid);
        $res = json_decode($resJson, true);

        $this->empid = $res['data']['employeeId'];
        $this->empName = $res['data']['firstName'] . ' ' . $res['data']['lastName'];
        $dedicated_mail = $res['data']['dedicated_mail'];
        $program_name = $res['data']['program_name'];
        $this->email = $res['data']['emailId'];
        $this->company = $res['data']['companyName'];
        $this->empCode = $res['data']['employeeCode'];

        $cd = date('Y-m-d H:i:s');
        
        try {
            $max = "select max(autoId) from Tbl_EmployeeComplaints";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $c_id = $tr[0];
                $c_id1 = $c_id + 1;
                $comid = "COM-" . $c_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
        
        /*         * *************** Insert Client Data into benepik admin Database start ************************************** */
        try {
            $query = "insert into Tbl_EmployeeComplaints(complaintId, clientId, emailId, userUniqueId, content, status, anonymous, date_of_complaint, complaintBy, device)
    values(:crid, :cid, :email1, :uuid, :msg, :visible, :anonymous, :date1, :empName, :device)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':crid', $comid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->client_id, PDO::PARAM_STR);
            $stmt->bindParam(':email1', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':uuid', $this->empid, PDO::PARAM_STR);
            $stmt->bindParam(':msg', $this->content, PDO::PARAM_STR);
            $stmt->bindParam(':visible', $this->status, PDO::PARAM_STR);
            $stmt->bindParam(':anonymous', $this->isAnonymous, PDO::PARAM_STR);
            $stmt->bindParam(':empName', $this->empName, PDO::PARAM_STR);
            $stmt->bindParam(':date1', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':device', $this->device, PDO::PARAM_STR);

            if ($stmt->execute()) {

                /*                 * ****************************mail to Hr****************************************** */
                if ($this->isAnonymous == '0') {
                    $empName = $this->empName;
                    $email = $this->email;
                    $empCode = $this->empCode;
                } else {
                    $empName = "Anonymous";
                    $email = "Anonymous";
                    $empCode = "Anonymous";
                }
                $to = "gsingh21509@gmail.com";
//                $to = "manasi@vikasgroup.in";
                
                $subject = 'Feedback Received at Vikas Live';

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";

                $headers = "From: " . $program_name . " <" . $dedicated_mail . "> \r\n";
                $headers .= "MIME-Version: 1.0\r\n" .
                        "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                $message = "Feedback Email Text\r\n" . $bound;

                $message .=
                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        '<html>

                        <body>
                        <div style="width: 700;height: 500;">
                        <div style="width: 700;height: 100;" >
                        </div >

                        <div style="height: 420;  ">
                        <div style="width: 600; ">
                        <p>Dear Ms. Das</p>
                        <p>A Feedback has been received via Vikas Live as follows:</p> 
                        <p>Name of the Employee : ' . $empName . '</p>
                            <p>Employee ID : ' . $empCode . '</p>
                                <p>Company : ' . $this->company . '</p>
                                    <p>Feedback : ' . $this->content . '</p>
                        <p></p>
                        <br>
                        <p>Regards</p>
                        <p>Team Vikas Live</p>

                        </div>
                        </div>

                        </div>
                        </body>
                        </html>
                        ' . "\n\n" .
                        $bound_last;

                mail($to, $subject, $message, $headers);
                /*                 * ****************************************************************************************** */
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Feedback has been sent";
                return $response;
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************************* Sugestion details data into database  ************************************* */

    function entrySugestion($clientid, $employeeid, $suggestionarea, $suggestion, $device) {
        $this->client_id = $clientid;
        $this->empid = $employeeid;
        $this->content = $suggestion;
        $this->device = $device;
        $status = 1;
        $cd = date('Y-m-d H:i:s');

        try {
            $max = "select max(autoId) from Tbl_EmployeeSuggestions";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $c_id = $tr[0];
                $c_id1 = $c_id + 1;
                $sid = "SUG-" . $c_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        try {
            $query = "insert into Tbl_EmployeeSuggestions(sugestionId,clientId,userUniqueId,suggestionArea,content,device,status,date_of_sugestion)
    values(:sid,:cid,:eid,:sarea,:sugg,:device,:status,:dte)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->client_id, PDO::PARAM_STR);

            $stmt->bindParam(':eid', $this->empid, PDO::PARAM_STR);
            $stmt->bindParam(':sarea', $suggestionarea, PDO::PARAM_STR);
            $stmt->bindParam(':sugg', $this->content, PDO::PARAM_STR);
            $stmt->bindParam(':device', $this->device, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':dte', $cd, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $user_obj = new Profile();
                $res = $user_obj->getuserprofile($clientid, $employeeid);
                $res1 = json_decode($res, true);

                $program_name = $res1['data']['program_name'];
                $dedicated_mail = $res1['data']['dedicated_mail'];
                $empname = $res1['data']['firstName'] . " " . $res1['data']['lastName'];

                /*                 * *****************************mail to Hr****************************************** */
                $to = "webveeru@gmail.com";
//                $to = "manasi@vikasgroup.in";

                $subject = 'Suggestion Received at Vikas Live';

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";

                $headers = "From: " . $program_name . " <" . $dedicated_mail . "> \r\n";
                $headers .= "MIME-Version: 1.0\r\n" .
                        "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                $message = "Suggestion Email Text\r\n" .
                        $bound;

                $message .=

                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        '

                        <html>

                        <body>
                        <div style="width: 700;height: 500;">
                        <div style="width: 700;height: 100;" >
                        </div >

                        <div style="height: 420;  ">
                        <div style="width: 600; ">
                        <p>Dear Ms. Das</p>
                        <p>A suggestion has been received via Vikas Live as follows:</p> 
                        <p>Name of the Employee : ' . $empname . '</p>
                            <p>Employee ID : ' . $res1['data']['employeeCode'] . '</p>
                                <p>Company : ' . $res1['data']['companyName'] . '</p>
                                    <p>Suggestion Category : ' . $suggestionarea . '</p>
                                        <p>Suggestion : ' . $suggestion . '</p>


                        <p></p>

                        <br>

                        <p>Regards</p>
                        <p>Team Vikas Live</p>


                        </div>
                        </div>


                        </div>
                        </body>
                        </html>
                        ' . "\n\n" .
                        $bound_last;
                /*                 * ************************************************************************************************************************************************************* */
                if (mail($to, $subject, $message, $headers)) {
                    $msg = "data successfully uploaded";
                    $resp['msg'] = $msg;
                    $resp['success'] = 1;
                }
                /*                 * ****************************************************************************************** */

                $response = array();
                $response["success"] = 1;
                $response["message"] = "Suggestion is Successfully Sent";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Some error please write us to info@benepik.com" . $e;
        }
        return $response;
    }

    /*     * ****************************************************** Get Complain ********************************** */

    public $client_id;

    function getComplain($cid) {
        $this->client_id = $cid;
        try {
            $query = "select UserComplaints.*, UserPersonalDetails.* from UserComplaints join UserPersonalDetails on UserComplaints.emailId = UserPersonalDetails.emailId where UserComplaints.clientId = :cid order by date_of_complaint desc";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $this->client_id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($row);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ****************************************************** Get suggestion ********************************** */

    function getSuggestion($cid1) {
        $this->client_id = $cid1;
        try {
            $query = "select UserSugestions.*, UserPersonalDetails.* from UserSugestions join UserPersonalDetails on UserSugestions.emailId = UserPersonalDetails.emailId where UserSugestions.clientId = :cid order by date_of_sugestion desc";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $this->client_id, PDO::PARAM_STR);
            $stmt->execute();
            $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($row1);
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>
