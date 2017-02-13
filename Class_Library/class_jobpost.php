<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("class_connect_db_Communication.php");
require_once('class_get_useruniqueid.php'); //getting userinformation

class JobPost {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public function getJobs($clientid, $jobId = '') {
        try {
            $query = "SELECT jobs.*,user.firstName, user.lastName, user.emailId, user.contact FROM Tbl_C_JobPost as jobs join Tbl_EmployeeDetails_Master as user ON user.employeeId=jobs.createdBy WHERE jobs.clientId=:client";
            if (!empty($jobId)) {
                $query .= " AND jobs.jobId=:jobId";
            } else {
                $query .= " order by status, createdDate desc";
            }
            $stmt1 = $this->db_connect->prepare($query);
            $stmt1->bindParam(':client', $clientid, PDO::PARAM_STR);
            if (!empty($jobId)) {
                $stmt1->bindParam(':jobId', $jobId, PDO::PARAM_STR);
            }
            $result = $stmt1->execute();
            $response = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo $ex;
            $response["success"] = 0;
            $response["msg"] = "Error" . $ex;
        }

        return json_encode($response);
    }

    public function status_Job($jobId, $status, $reason = '') {
        $this->jobId = $jobId;
        $this->status = $status;

        if ($this->status == 1) {
            $welstatus = 1;
        } else {
            $welstatus = 0;
        }
        try {
            $query = "update Tbl_C_JobPost set status = :status ";
            if (!empty($reason)) {
                $query .= ", disapproval_reason = :reason ";
            }
            $query .= "where jobId = :jobId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':jobId', $this->jobId, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            if (!empty($reason)) {
                $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
            }
            $stmt->execute();


            $wquery = "update Tbl_C_WelcomeDetails set status = :status1 where id = :jobId ";
            $stmtw = $this->db_connect->prepare($wquery);
            $stmtw->bindParam(':jobId', $this->jobId, PDO::PARAM_STR);
            $stmtw->bindParam(':status1', $welstatus, PDO::PARAM_STR);
            $response = array();

            if ($stmtw->execute()) {
                $response["success"] = 1;
                $response["message"] = "Job status has changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function delete_job($jobId) {
        $this->jobId = $jobId;

        try {
            $query = "delete from Tbl_C_JobPost where jobId = :jobId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':jobId', $this->jobId, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Job has been deleted successfully";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function createJob($clientid, $employeeid, $jobTitle, $joblocation, $companyName, $contactdetails, $jobDescription, $device) {
        $createdeate = date('Y-m-d h:i:s');
        $status = 0;
        $jtype = 'JobPost';
        $flagtype = 15;
        try {

            $query = "insert into Tbl_C_JobPost(clientId,jobTitle,jobLocation,jobDescription,companyName,contactDetails,device,createdBy,createdDate)
			                             values(:client,:jt,:jl,:jd,:cn,:contact,:device,:createdby,:createddate) 
			ON DUPLICATE KEY UPDATE jobTitle=:jt,jobLocation = :jl,jobDescription =:jd,companyName =:cn,
			contactDetails = :contact, updatedBy = :createdby,updatedDate = :createddate";

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':jt', $jobTitle, PDO::PARAM_STR);
            $stmt->bindParam(':jl', $joblocation, PDO::PARAM_STR);
            $stmt->bindParam(':jd', $jobDescription, PDO::PARAM_STR);
            $stmt->bindParam(':cn', $companyName, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contactdetails, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
            $stmt->bindParam(':createdby', $employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':createddate', $createdeate, PDO::PARAM_STR);
            $result = $stmt->execute();
            $jobid = $this->db_connect->lastInsertId();
            // 	echo "this is jobid --".$jobid;
            //$jobid1 = $jobid + 1;
            /*             * =========================================================================================== */

            $query1 = "insert into Tbl_C_WelcomeDetails(clientId,Id,type,title,createdDate,createdBy,status,flagType)
			                                     values(:cli,:jid,:type,:title,:cd1,:cb,:st,:flag)";
            $stmt1 = $this->db_connect->prepare($query1);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':jid', $jobid, PDO::PARAM_STR);
            $stmt1->bindParam(':type', $jtype, PDO::PARAM_STR);
            $stmt1->bindParam(':title', $jobTitle, PDO::PARAM_STR);
            $stmt1->bindParam(':cd1', $createdeate, PDO::PARAM_STR);
            $stmt1->bindParam(':cb', $employeeid, PDO::PARAM_STR);
            $stmt1->bindParam(':st', $status, PDO::PARAM_STR);
            $stmt1->bindParam(':flag', $flagtype, PDO::PARAM_STR);
            $result1 = $stmt1->execute();

            if ($result1) {

                $userobj = new UserUniqueId(); // object created
                $userdetails = $userobj->getUserData($clientid, $employeeid);
                $userdata = json_decode($userdetails, true);
                //print_r($userdata);
                $sendername = $userdata[0]["firstName"] . " " . $userdata[0]["lastName"];

                $sendermobileno = $userdata[0]['contact'];

                $sendermail = $userdata[0]['emailId'];

                //echo "this is user details ".$userdetails;

                /*                 * ***********************************************************mail send to admin************************************ */

                /**                 * ************************* */
                $to = "webveeru@gmail.com";
                $subject = $jobTitle . " " . $joblocation . " " . $companyName;

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";

                $headers = "From: manav rachna <" . $sendermail . "> \r\n";
                $headers .= "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                $message = " Now You Can Login With This Emailid & Password \r\n" .
                        $bound;

                $message .=

                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        '
                          <html>

                          <body>
                          <div style="width: 700;height: 500;background: white;">
                          <div style="width: 700;height: 100;background: white" >
                          </div >

                          <div style="background: window;height: 420;  ">
                          <div style="width: 600; ">
                          <p>Dear Admin,</p>
                         
						  <p>A new job has been posted, kindly provide your approval.</p>

                          <p>Job Description : ' . $jobDescription . '</p>



                          <p>Kindly Approve to post</p>

                          <br>

                          <p>Regards,</p>

						   <p>' . $sendername . '</p>
						    <p>' . $sendermobileno . '</p>

                          </div>
                          </div>


                          </div>
                          </body>
                          </html>

                          ' . "\n\n" .
                        $bound_last;
                $sm = mail($to, $subject, $message, $headers);



                $response["success"] = 1;
                $response["msg"] = "Job detail will post after  successfully approval.";
            }
        } catch (PDOException $ex) {
            echo $ex;
            $response["success"] = 0;
            $response["msg"] = "Error" . $ex;
        }
        return json_encode($response);
    }

    public function getJobPost($clientid, $employeeid, $val) {
        $imagepath = dirname(SITE_URL) . "/";
        try {
            $query = "SELECT jobs.jobId,jobs.clientId,jobs.jobTitle,jobs.jobLocation,jobs.jobDescription,	jobs.companyName,jobs.contactDetails,jobs.disapproval_reason,jobs.status,jobs.device,jobs.createdBy,	DATE_FORMAT(jobs.createdDate,'%d %b %Y') as createdDate,jobs.updatedBy,jobs.updatedDate,
			CONCAT(emp_master.firstName,' ',emp_master.lastName) AS name, IF(emp_personal.linkedIn='1', emp_personal.userImage, IF(emp_personal.userImage IS NULL or emp_personal.userImage='','',CONCAT('" . $imagepath . "',emp_personal.userImage))) AS user_image FROM Tbl_C_JobPost AS jobs JOIN Tbl_EmployeeDetails_Master AS emp_master ON emp_master.employeeId=jobs.createdBy JOIN Tbl_EmployeePersonalDetails AS emp_personal ON emp_personal.employeeId=jobs.createdBy WHERE emp_master.clientId = :cli AND jobs.status = 1 order by jobs.createdDate desc limit $val, 5";
            $stmt1 = $this->db_connect->prepare($query);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);

            $result = $stmt1->execute();
            $val = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            if ($val) {
                $response["success"] = 1;
                $response["msg"] = "Data found";
                $response["total_jobPosts"] = count($val);
                $response["data"] = $val;
            } else {
                $response["success"] = 0;
                $response["msg"] = "No Post Available";
            }
        } catch (PDOException $ed) {
            $response["success"] = 0;
            $response["msg"] = "Error" . $ed;
        }
        return json_encode($response);
    }

    public function job_details($clientid, $jobId, $flag) {
        try {
            $site_url = dirname(SITE_URL) . '/';

            $query = "select job.*,if(user.userImage IS NULL or user.userImage='','',CONCAT('" . $site_url . "',user.userImage)) as userImage, Concat(user_master.firstName, ' ', user_master.lastName) as createdBy from Tbl_C_JobPost as job join Tbl_EmployeePersonalDetails as user on job.createdBy = user.employeeId join Tbl_EmployeeDetails_Master as user_master on user_master.employeeId=job.createdBy where job.jobId=:jobId and job.clientId=:cli and job.status=1";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);
//            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($rows);
            $response['success'] = 1;
            $response['message'] = "data found";
            $response['data'] = $rows;
        } catch (Exception $ex) {
            echo $e;
            $response['success'] = 0;
            $response['message'] = "data not found " . $e;
        }
        return $response;
    }

}

?>