<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('class_connect_db_Communication.php');
require ('../../twilio-php-master/Services/Twilio.php');

class ClientEmployeeLogin {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public $empid;
    public $dob;
    public $doj;

    function checkEmployeeLogin($empid, $dob, $usertype) {
        $this->empid = $empid;
        //  $this->doj = $doj;
        $this->usertype = $usertype;
        $this->dob = $dob;
        $eid = strtoupper($this->empid);
        try {
            $rt = "select ud.*,up.userFatherName,up.userDOB from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on ud.employeeId = up.employeeId where
UPPER(ud.employeeCode) =:eid and up.userDOB=:dob and (ud.accessibility=:usertype or ud.accessibility='SubAdmin' or ud.accessibility='Admin')";

            $stmt = $this->db_connect->prepare($rt);
            $stmt->bindParam(':eid', $eid, PDO::PARAM_STR);
            // $stmt->bindParam(':doj', $this->doj, PDO::PARAM_STR);
            $stmt->bindParam(':usertype', $this->usertype, PDO::PARAM_STR);
            $stmt->bindParam(':dob', $this->dob, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::PARAM_STR);
            // print_r($row);
            if ($row) {
                $response['success'] = 1;
                $response['msg'] = "valid user";
                $response['username'] = $row[0]['firstName'] . " " . $row[0]['middleName'] . " " . $row[0]['lastName'];
                $response['useruniqueid'] = $row[0]['employeeId'];
                $response['mobileno'] = $row[0]['contact'];
                $response['emailid'] = $row[0]['emailId'];
                $response['FatherName'] = $row[0]['userFatherName'];
                $response['DOB'] = $row[0]['userDOB'];
                $response['employeeCode'] = $row[0]['employeeCode'];
            } else {
                $response['success'] = 0;
                $response['msg'] = "Your registration details are not correct, please contact administrator with below details";
                $response['username'] = "";
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
        return json_encode($response);
    }

    /*     * ***********************************generate login otp********************************************* */

    public $mobile;
    public $emailid;

    function generateLoginOTP($mob, $email, $empid) {
        $this->mobile = $mob;
        $this->emailid = $email;
        $this->empid = $empid;

        $password = self::randomPassword(6);
        $md5pass = md5($password);

        try {

            $query = "update Tbl_EmployeeDetails_Master set contact=:mob,emailId =:eml, password=:pass where employeeId = :empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':mob', $this->mobile, PDO::PARAM_STR);
            $stmt->bindParam(':eml', $this->emailid, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $md5pass, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $this->empid, PDO::PARAM_STR);
            $stmt->execute();
            $rows_found = $stmt->rowCount();

            $query = "update Tbl_EmployeePersonalDetails set emailId =:eml1 where employeeId = :empid";
            $stmt1 = $this->db_connect->prepare($query);
            $stmt1->bindParam(':eml1', $this->emailid, PDO::PARAM_STR);
            $stmt1->bindParam(':empid', $this->empid, PDO::PARAM_STR);
            $stmt1->execute();

            $query1 = "select firstName,emailId,employeeCode from Tbl_EmployeeDetails_Master where employeeId = :empid";
            $stmt11 = $this->db_connect->prepare($query1);
            $stmt11->bindParam(':empid', $this->empid, PDO::PARAM_STR);
            $stmt11->execute();
            $name = $stmt11->fetch(PDO::FETCH_ASSOC);
            $username = $name['firstName'];
            $emailid = $name['emailId'];
            $empcode = $name['employeeCode'];


            if ($rows_found > 0) {
//echo $rows_found;
                $loginsms = "Vikas Live verification code is " . $password;

                $account_sid = 'AC6cada6ee591e119871888eecc7c759c5';
                $auth_token = 'ed74429787ae54cb2af89120ccc4833f';
                $client = new Services_Twilio($account_sid, $auth_token);

                $client->account->messages->create(array(
                    'To' => "+91" . $this->mobile,
                    'From' => "+13144007176",
                    'Body' => $loginsms,));

                $response['success'] = 1;

                $response['msg'] = "Your Latest Password sent to Your mobile and Email id";
                $response['emaild'] = $emailid;
                $response['contactno'] = "+91" . $this->mobile;
                $response['empcode'] = $empcode;
                $response['empid'] = $this->empid;
                $response['otp'] = $password;


                /*                 * *******************************send mail***************************************** */
                $to = $emailid;
                $subject = 'Vikas Live Login OTP';
                $from = 'vikaslive@benepik.com';

                // To send HTML mail, the Content-type header must be set

                $headers = 'MIME-Version: 1.0' . "\r\n";

                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";


                // Create email headers

                $headers .= 'From: Vikas Live <' . $from . ">\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();



                // Compose a simple HTML email message

                $message = '<html><body>';

                $message .= '<p>Dear ' . $username . ',<p>';

                $message .= '<p>Vikas Live verification code is  ' . $password . '</p><br>';


                $message .= '<p>Regards,</p>';
                $message .= '<p>Team Benepik</p>';

                $message .= '</body></html>';


                if (mail($to, $subject, $message, $headers)) {

                    // echo 'Your mail has been sent successfully.';
                } else {

                    // echo 'Unable to send email. Please try again.';
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "your unique user id not match";
            }
        } catch (PDOException $ex) {
            echo $ex;
            $response['success'] = 0;
            $response['msg'] = $ex;
            $response['username'] = "";
        }
        return json_encode($response);
    }

    function randomPassword($length) {
        $alphabet = "0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /*     * ************************* generate Temperory registration  ********************************** */

    function tempregistration($empid, $dob, $clientid = '') {
        date_default_timezone_set('Asia/Calcutta');
        $c_date = date('Y-m-d H:i:s');

        $clientid = "CO-25";
        $randomDigit = self::randomdigit(5);
        $status = "Active";
        $access = "User";
        /*         * ******************************************************************** */
        try {
            $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
            $stmt7 = $this->db_connect->prepare($query_client);
            $stmt7->bindParam(':cid7', $clientid, PDO::PARAM_STR);
            if ($stmt7->execute()) {
                $row = $stmt7->fetch();
                $program_name = $row['program_name'];
                $dedicateemail = $row['dedicated_mail'];
                $clientid = $row['client_id'];
                $subdomain_link = $row['subDomainLink'];
                $package_name = $row['packageName'];
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        /*         * ******************************************************************** */


        try {

            $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
            $query = $this->db_connect->prepare($max);
            if ($query->execute()) {
                $tr = $query->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $usid = "User-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
        /*         * ******************************************************************** */

        try {
            $qu = "insert into Tbl_EmployeeDetails_Master
	(userId,clientId,employeeId,employeeCode,status,accessibility,createdDate,createdBy) 
        values(:uid,:cid,:eid,:ecode,:sta,:acc,:cred,:creb)";

            $stmt = $this->db_connect->prepare($qu);

            $stmt->bindParam(':uid', $usid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $randomDigit, PDO::PARAM_STR);
            $stmt->bindParam(':ecode', $empid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
            $stmt->bindParam(':acc', $access, PDO::PARAM_STR);
            $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
            $stmt->bindParam(':creb', $empid, PDO::PARAM_STR);
            if ($stmt->execute()) {

                $query4 = "insert into Tbl_EmployeePersonalDetails(userid,clientId,employeeCode,employeeId,userDOB)values(:uid1,:cid1,:ecode1,:eid1,:dob)";
                $stmt4 = $this->db_connect->prepare($query4);
                $stmt4->bindParam(':uid1', $usid, PDO::PARAM_STR);
                $stmt4->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                $stmt4->bindParam(':ecode1', $empid, PDO::PARAM_STR);
                $stmt4->bindParam(':eid1', $randomDigit, PDO::PARAM_STR);
                $stmt4->bindParam(':dob', $dob, PDO::PARAM_STR);
                if ($stmt4->execute()) {
                    // $user_name = $this->first_name . " " . $this->middle_name . " " . $this->last_name;
                    //  $SENDTO = $this->mail1;
                    /** -----------------------------------------------* */
                    $to = "virendra@benepik.com";

                    /**                     * ******************************************************************************************************************************************************************* */
                    /*                     * ************************************************************************************************************************************************************* */
                    $subject = 'Administrator added new User';

                    $bound_text = "----*%$!$%*";
                    $bound = "--" . $bound_text . "\r\n";
                    $bound_last = "--" . $bound_text . "--\r\n";

                    $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n";
                    $headers .= "MIME-Version: 1.0\r\n" .
                            "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                    $message = " Now You Can Login With This Emailid & Password \r\n" .
                            $bound;

                    $message .=

                            'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                            'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                            '

   <html>

   <body>
   <div style="width: 700;height: 200;background: white;">
   <div style="width: 700;height: 100;background: white" >
   </div >
   
   <div style="background: window;height: 120;  ">
   <div style="width: 600; ">
   <p>Dear Admin,</p>
   <p ><b>' . $program_name . ' Administrator added new User</b></p> 
   <p>Details are as follows</p>
   <p>Employee Code : ' . $empid . '</p>
   <p>Employee Name : ' . "" . ' ' . "" . '</p>
    <p>Email Id : ' . "" . '</p>
  
 
   <p></p>
 
   <br>

   <p>Regards</p>
    <p>Team Haier Connect</p>
 
   
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .
                            $bound_last;



                    /*                     * *********************************************************************************************************************************************************************** */

                    mail($to, $subject, $message, $headers);

                    // echo "<script>alert('Data inserted successfully')</script>";
                    // echo "<script>window.location='../add_user.php'</script>";
                }
            }
            $response['success'] = 1;
            $response['msg'] = "valid user";
            // $response['username'] = $row[0]['firstName'] . " " . $row[0]['middleName'] . " " . $row[0]['lastName'];
            $response['useruniqueid'] = $randomDigit;
            $response['mobileno'] = "";
            $response['emailid'] = "";
            $response['FatherName'] = "";
            $response['DOB'] = $dob;
            $response['employeeCode'] = $empid;
        } catch (PDOException $ex) {
            $response['success'] = 0;
            $response['msg'] = "Facing Trouble Please Write to us info@benepik.com";
        }
        return json_encode($response);
    }

    function randomdigit($length) {
        $alphabet = "0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}

?>