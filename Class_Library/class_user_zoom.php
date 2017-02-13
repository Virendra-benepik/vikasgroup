<?php
session_start();
require_once('class_connect_db_Communication.php');

class User {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $filename;
    public $filetempname;
    public $fullcsvpath;
    public $client_id;
    public $createdby;

    function uploadUserCsv($clientid1, $user, $file_name, $file_temp_name, $fullpath) {

        $this->fullcsvpath = $fullpath;

        date_default_timezone_set('Asia/Calcutta');
        $c_date = date('Y-m-d H:i:s');
        $status = "Active";
        $access = "User";
        $this->client_id = $clientid1;
        $user_session = $_SESSION['user_email'];
        $this->createdby = $user;
        //  echo "user unique id := ".$this->createdby;
        $this->filename = $file_name;
        $this->filetempname = $file_temp_name;
        $target_file = basename($this->filename);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if ($imageFileType != "csv") {
            echo "Sorry, only .csv files are allowed.";
            $uploadOk = 0;
        } else {
            $handle = fopen($this->filetempname, "r");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $userdata[] = $data;
            }

            /*             * ************start insert into database ************************************************* */

            // print_r($userdata);
            $countrows = count($userdata);
            if ($countrows > 200) {
                echo "<script>alert(Sorry! You can't upoad data more than 200 employee at a time) </script>";
            }
            // echo $countrows;
            /*             * ***************************fetch existing admin details (emaild)************************************* */
            try {
                $max = "select * from Tbl_EmployeeDetails_Master where clientId = '" . $this->client_id . "'";
                $query = $this->DB->prepare($max);
                if ($query->execute()) {
                    $tr = $query->fetch();
                    $ADMINEMAIL = $tr['employeeId'];   //fetch admin email id
                }
            } catch (PDOException $e) {
                echo $e;
                trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
            }

            try {
                $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
                $stmt7 = $this->DB->prepare($query_client);
                $stmt7->bindParam(':cid7', $this->client_id, PDO::PARAM_STR);
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

            /*             * *************************************** */

            /*             * ************************ fetching data from B_Client_Data******************************** */


            for ($row = 1; $row < $countrows; $row++) {

                $user_name = $userdata[$row][0] . " " . $userdata[$row][1] . " " . $userdata[$row][2];
                 $first_name = $userdata[$row][0];
                $randomAlpha = self::randomalpha(6);
                $randomDigit = self::randomdigit(2);
                $randompassword = $randomAlpha . $randomDigit;
                $md5password = md5($randompassword);
               // $md5password = "";

                $randomempid = self::randomuuid(30);

                $adminaccess = 'Admin';
                $useremail = $userdata[$row][12];
          
		  
		   
			
                try {
                    $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
                    $query = $this->DB->prepare($max);
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
				
				try {
                    $qu = "insert into Tbl_EmployeeDetails_Master
(userId,clientId,employeeId,firstName,middleName,lastName,gender,emailId,password,employeeCode,contact,department,designation,
location,branch,grade,status,accessibility,createdDate,createdBy) values(:uid,:cid,:eid,:fname,:mname,:lname,:gen,:email,:pass,:ecode,:mob,:dep,:des, :loc,:bra,:gra,:sta,:acc,:cred,:creb) ON DUPLICATE KEY UPDATE firstName =:fname,middleName=:mname, lastName=:lname,gender=:gen,emailId=:email,contact=:mob, department=:dep,designation=:des,location=:loc,branch=:bra,grade=:gra,status=:sta, accessibility=:acc,createdDate=:cred,createdBy=:creb";
                    $stmt = $this->DB->prepare($qu);

                    $stmt->bindParam(':uid', $usid, PDO::PARAM_STR);
                    $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                    $stmt->bindParam(':eid', $randomempid, PDO::PARAM_STR);

                    $stmt->bindParam(':fname', $userdata[$row][0], PDO::PARAM_STR);
                    $stmt->bindParam(':mname', $userdata[$row][1], PDO::PARAM_STR);
                    $stmt->bindParam(':lname', $userdata[$row][2], PDO::PARAM_STR);

                    $stmt->bindParam(':gen', $userdata[$row][3], PDO::PARAM_STR);
                    $stmt->bindParam(':email', $userdata[$row][12], PDO::PARAM_STR);
                    $stmt->bindParam(':mob', $userdata[$row][13], PDO::PARAM_STR);
                    $stmt->bindParam(':pass', $md5password, PDO::PARAM_STR);
                    $stmt->bindParam(':ecode', $userdata[$row][6], PDO::PARAM_STR);
                    $stmt->bindParam(':dep', $userdata[$row][7], PDO::PARAM_STR);
                    $stmt->bindParam(':des', $userdata[$row][8], PDO::PARAM_STR);
                    $stmt->bindParam(':loc', $userdata[$row][10], PDO::PARAM_STR);
                    $stmt->bindParam(':bra', $userdata[$row][11], PDO::PARAM_STR);
                    $stmt->bindParam(':gra', $userdata[$row][9], PDO::PARAM_STR);
                    $stmt->bindParam('sta', $status, PDO::PARAM_STR);
                    $stmt->bindParam(':acc', $access, PDO::PARAM_STR);
                    $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
                    $stmt->bindParam(':creb', $this->createdby, PDO::PARAM_STR);

                    if ($stmt->execute()) {

                        $query4 = "insert into Tbl_EmployeePersonalDetails(userid,clientId,employeeCode,employeeId,emailId,userDOB,userDOJ)
	                                         values(:uid1,:cid1,:ecode1,:eid1,:emailid1,:dob,:doj)
	      ON DUPLICATE KEY UPDATE userDOB=:dob,userDOJ=:doj,emailId=:emailid1";
                        $stmt4 = $this->DB->prepare($query4);
                        $stmt4->bindParam(':uid1', $usid, PDO::PARAM_STR);
                        $stmt4->bindParam(':ecode1', $userdata[$row][6], PDO::PARAM_STR);
                        $stmt4->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                        $stmt4->bindParam(':eid1', $randomempid, PDO::PARAM_STR);
                        $stmt4->bindParam(':emailid1', $userdata[$row][12], PDO::PARAM_STR);
                        $stmt4->bindParam(':dob', $userdata[$row][4], PDO::PARAM_STR);
                        $stmt4->bindParam(':doj', $userdata[$row][5], PDO::PARAM_STR);
                        //echo $userdata[$row][4].' '.$userdata[$row][5];
                        if ($stmt4->execute()) {
                            if ($useremail != $ADMINEMAIL) {
                                $SENDTO = $useremail;
                            }
                        }

    /*************************************************************mail send with password to user****************************************** */

                        /** ***************************/
                          $portalpath = "http://".$subdomain_link;

                          $to = $SENDTO;
                          $subject = 'Login Credentials for '.$program_name;

                          $bound_text = "----*%$!$%*";
                          $bound = "--".$bound_text."\r\n";
                          $bound_last = "--".$bound_text."--\r\n";

                          $headers = "From: ".$program_name." <".$dedicateemail."> \r\n";
                          $headers .= "Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;

                          $message = " Now You Can Login With This Emailid & Password \r\n".
                          $bound;

                          $message .=

                          'Content-Type: text/html; charset=UTF-8'."\r\n".
                          'Content-Transfer-Encoding: 7bit'."\r\n\r\n".
                          '


                          <html>

                          <body>
                          <div style="width: 700;height: 500;background: white;">
                          <div style="width: 700;height: 100;background: white" >
                          </div >

                          <div style="background: window;height: 420;  ">
                          <div style="width: 600; ">
                          <p>Dear '.ucfirst($first_name).',</p>
                          <p ><b>Welcome To '.$program_name.'.</b></p>
						  <p>'.$program_name.' is our internal communication platform enabling you to
access important updates, information and organizational news on the go.
An exciting feature of Zoom Connect is that it will enable you to get
Corporate Perks/  Discounts  at  participating merchants.  Participating
merchants include Hospitals, Play-Schools, Fitness Centres, Salons, Spa,
Dining, Online Stores and many more.</p>

<p>Please download '.$program_name.' Mobile App on your phone from the following
link: <a href="https://iphone.benepik.com/zoom">Download</a></p>

<p>Login only takes a second and you will have instant access to savings
and deals.
</p>

                          <p></p>


                          <table style="width: auto;height: auto;margin-left: 80;" class="table-responsive table-hover">
                          <tr><td style="width: 200px;">
                          Your Login Details:
                          </td>
                          </tr>
                          <tr>
                          <td style="width: 100;">User ID:</td>
                          <td>'.$SENDTO.'</td>
                          </tr>
                          <tr>
                          <td style="width: 100;">Password:  </td>
                          <td> '.$randompassword.'</td>
                          </tr>
                          </table>
                          <p>If you are unable to login or have any queries, please write to <a href="mailto:'.$dedicateemail.'?Subject=Query" target="_top">'.$dedicateemail.'</a> or <br> contact customer service @<font style="color: blue;">+91 124 -421-2827</font>(Mon- Fri).</p>
                          <br>

                          <p>Happy Savings!</p>

                          <p>Team '.$program_name.'</p>

                          </div>
                          </div>


                          </div>
                          </body>
                          </html>

                          '."\n\n".
                          $bound_last;
                          $sm=mail($to,$subject,$message,$headers);

                         /************* */

                        /** **************************************************************************/
                          if($sm)
                          {
                          $result = 1;
                          }
                          else
                          {
                          $msg = "email not sent and there is some error in emailid ".$SENDTO;
                          $resp['msg'] = $msg;
                          $resp['success'] = 0;


                          }   /************* */
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
            }
            $result = 1;
            if ($result == 1) {
                $number = $countrows - 1;

                $path = $this->fullcsvpath;

                $to1 = "virendra@benepik.com";

/*************************************************************************************************************************************************************** */
                $subject = 'Administrator has uploaded a CSV File';

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";

                $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n";
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
   <p ><b>' . $program_name . ' Administrator has uploaded a CSV File</b></p> 
   <p><b>' . $number . '</b> Users are listed in CSV</p>
   <p>Users CSV can be downloaded from here <a href=http://mconnect.benepik.com/' . $path . '>User Csv</a></p>
 
   <p></p>
 
   <br>

   <p>Regards</p>
   <p>Team Mconnect</p>
 
   
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .
                        $bound_last;
/* * ************************************************************************************************************************************************************* */
                if (mail($to1, $subject, $message, $headers)) {
                    $msg = "data successfully uploaded";
                    $resp['msg'] = $msg;
                    $resp['success'] = 1;
                }
            }
            return json_encode($resp);
        }



        /*         * ********************************file csv start  end ********************************** */
    }

    function createAdmin($empCode, $cid, $uniqId, $access, $createBy) {
        //echo'<pre>';print_r($empCode.'---'.$cid.'---'.$uniqId.'---'.$access.'---'.$createBy);die;
        $this->empCode = $empCode;
        $this->cid = $cid;
        $this->uniId = $uniqId;
        $this->access = $access;
        $this->createBy = $createBy;
        $this->status = 'Active';

        date_default_timezone_set('Asia/Calcutta');
        $c_date = date('Y-m-d H:i:s');

        /*         * ******************************* fetch maxid********************************************* */
        try {

            $max = "select max(autoId) from Tbl_ClientAdminDetails";
            $query = $this->DB->prepare($max);
            if ($query->execute()) {
                $tr = $query->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $adminid = "AD-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        try {

            $query = "insert into Tbl_ClientAdminDetails (adminId,clientId,userUniqueId,accessibility,createdDate,createdBy,status) values(:adid,:cid,:uniId,:access,:cDate,:cBy,:status) ON DUPLICATE KEY UPDATE  clientId=:cid, userUniqueId=:uniId, accessibility=:access, createdDate=:cDate , createdBy=:cBy , status:=status";
            $stmt = $this->DB->prepare($query);

            $stmt->bindParam(':cid', $this->cid, PDO::PARAM_STR);
            $stmt->bindParam(':adid', $adminid, PDO::PARAM_STR);
            $stmt->bindParam(':uniId', $this->uniId, PDO::PARAM_STR);
            $stmt->bindParam(':access', $this->access, PDO::PARAM_STR);
            $stmt->bindParam(':cDate', $c_date, PDO::PARAM_STR);
            $stmt->bindParam(':cBy', $this->createBy, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $query1 = "update Tbl_EmployeeDetails_Master set accessibility=:access where employeeId=:uniId and employeeCode=:empCode";
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':uniId', $this->uniId, PDO::PARAM_STR);
                $stmt1->bindParam(':empCode', $this->empCode, PDO::PARAM_STR);
                $stmt1->bindParam(':access', $this->access, PDO::PARAM_STR);

                if ($stmt1->execute()) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Admin created successfully";
                }
            }
        } catch (PDOException $ex) {
            echo $ex;
        }

        return $response;
    }
/************************************  add data using form **********************************/

    function userForm($clientid1, $user, $fname, $mname, $lname, $emp_code, $dob, $doj, $email_id, $designation, $department, $contact, $location, $branch, $grade, $gender) {
        $this->first_name = $fname;
        $this->middle_name = $mname;
        $this->last_name = $lname;
        $this->empCode = $emp_code;
        $this->dobirth = $dob;
        $this->dojoining = $doj;
        $this->mail1 = $email_id;
        $this->desig = $designation;
        $this->depart = $department;
        $this->mobile = $contact;
        $this->locs = $location;
        $this->brnch = $branch;
        $this->grad = $grade;
        $this->gend = $gender;
		

        date_default_timezone_set('Asia/Calcutta');
        $c_date = date('Y-m-d H:i:s');

        $randomAlpha = self::randomalpha(6);
        $randomDigit = self::randomdigit(2);
        $randompassword = $randomAlpha . $randomDigit;

        $md5password = md5($randompassword);
		//echo $md5password;
       // $md5password = "";

        $randomempid = self::randomuuid(30);

        $status = "Active";
        $access = "User";
        $this->createdby = $user;
        $this->client_id = $clientid1;

        try {
            $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
            $stmt7 = $this->DB->prepare($query_client);
            $stmt7->bindParam(':cid7', $this->client_id, PDO::PARAM_STR);
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

        /*         * ******************************* fetch maxid********************************************* */
        try {

            $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
            $query = $this->DB->prepare($max);
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

        try {
            $qu = "insert into Tbl_EmployeeDetails_Master
	(userId,clientId,employeeId,firstName,middleName,lastName,gender,emailId,password,employeeCode,contact,department,designation,location,branch,grade,status,accessibility,createdDate,createdBy) values(:uid,:cid,:eid,:fname,:mname,:lname,:gen,:email,:pass,:ecode,:con,:dep,:des, :loc,:bra,:gra,:sta,:acc,:cred,:creb) ON DUPLICATE KEY UPDATE firstName =:fname,middleName=:mname, lastName=:lname,gender=:gen, emailId=:email, contact=:con,department=:dep,designation=:des,location=:loc,branch=:bra,grade=:gra, accessibility=:acc,createdDate=:cred,createdBy=:creb";

            $stmt = $this->DB->prepare($qu);

            $stmt->bindParam(':uid', $usid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $randomempid, PDO::PARAM_STR);

            $stmt->bindParam(':fname', $this->first_name, PDO::PARAM_STR);
            $stmt->bindParam(':mname', $this->middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $this->last_name, PDO::PARAM_STR);

            $stmt->bindParam(':gen', $this->gend, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->mail1, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $md5password, PDO::PARAM_STR);
            $stmt->bindParam(':ecode', $this->empCode, PDO::PARAM_STR);
            $stmt->bindParam(':con', $this->mobile, PDO::PARAM_STR);
            $stmt->bindParam(':dep', $this->depart, PDO::PARAM_STR);
            $stmt->bindParam(':des', $this->desig, PDO::PARAM_STR);
            $stmt->bindParam(':loc', $this->locs, PDO::PARAM_STR);
            $stmt->bindParam(':bra', $this->brnch, PDO::PARAM_STR);
            $stmt->bindParam(':gra', $this->grad, PDO::PARAM_STR);
            $stmt->bindParam('sta', $status, PDO::PARAM_STR);
            $stmt->bindParam(':acc', $access, PDO::PARAM_STR);
            $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
            $stmt->bindParam(':creb', $this->createdby, PDO::PARAM_STR);
            if ($stmt->execute()) {

                $query4 = "insert into Tbl_EmployeePersonalDetails(userid,clientId,employeeCode,employeeId,emailId,userDOB,userDOJ)values(:uid1,:cid1,:ecode1,:eid1,:emailid1,:dob,:doj) ON DUPLICATE KEY UPDATE userDOB=:dob,userDOJ=:doj,emailId=:emailid1";
                $stmt4 = $this->DB->prepare($query4);
                $stmt4->bindParam(':uid1', $usid, PDO::PARAM_STR);
                $stmt4->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                $stmt4->bindParam(':ecode1', $this->empCode, PDO::PARAM_STR);
                $stmt4->bindParam(':eid1', $randomempid, PDO::PARAM_STR);
                $stmt4->bindParam(':emailid1', $this->mail1, PDO::PARAM_STR);
                $stmt4->bindParam(':dob', $this->dobirth, PDO::PARAM_STR);
                $stmt4->bindParam(':doj', $this->dojoining, PDO::PARAM_STR);

                if ($stmt4->execute()) {
                    $user_name = $this->first_name . " " . $this->middle_name . " " . $this->last_name;
					$first_name = $this->first_name;
                    $SENDTO = $this->mail;

                    /** **********************************************  mail  send ****************************************** */
                    /** **************/
                      $portalpath = "http://".$subdomain_link;

                      $to = $SENDTO;
                      $subject = 'Login Credentials for '.$program_name;

                      $bound_text = "----*%$!$%*";
                      $bound = "--".$bound_text."\r\n";
                      $bound_last = "--".$bound_text."--\r\n";

                      $headers = "From: ".$program_name." <".$dedicateemail."> \r\n";
                      $headers .= "Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;

                      $message = " Now You Can Login With This Emailid & Password \r\n".
                      $bound;

                      $message .=

                      'Content-Type: text/html; charset=UTF-8'."\r\n".
                      'Content-Transfer-Encoding: 7bit'."\r\n\r\n".
                      '
                         <html>

                          <body>
                          <div style="width: 700;height: 500;background: white;">
                          <div style="width: 700;height: 100;background: white" >
                          </div >

                          <div style="background: window;height: 420;  ">
                          <div style="width: 600; ">
                          <p>Dear '.ucfirst($first_name).',</p>
                          <p ><b>Welcome To '.$program_name.'.</b></p>
						  <p>'.$program_name.' is our internal communication platform enabling you to
access important updates, information and organizational news on the go.
An exciting feature of Zoom Connect is that it will enable you to get
Corporate Perks/  Discounts  at  participating merchants.  Participating
merchants include Hospitals, Play-Schools, Fitness Centres, Salons, Spa,
Dining, Online Stores and many more.</p>

<p>Please download '.$program_name.'Mobile App on your phone from the following
link: <a href="https://iphone.benepik.com/zoom">Download</a></p>

<p>Login only takes a second and you will have instant access to savings
and deals.
</p>

                          <p></p>


                          <table style="width: auto;height: auto;margin-left: 80;" class="table-responsive table-hover">
                          <tr><td style="width: 200px;">
                          Your Login Details:
                          </td>
                          </tr>
                          <tr>
                          <td style="width: 100;">User ID:</td>
                          <td>'.$SENDTO.'</td>
                          </tr>
                          <tr>
                          <td style="width: 100;">Password:  </td>
                          <td> '.$randompassword.'</td>
                          </tr>
                          </table>
                          <p>If you are unable to login or have any queries, please write to <a href="mailto:'.$dedicateemail.'?Subject=Query" target="_top">'.$dedicateemail.'</a> or <br> contact customer service @<font style="color: blue;">+91 124 -421-2827</font>(Mon- Fri).</p>
                          <br>

                          <p>Happy Savings!</p>

                          <p>Team '.$program_name.'</p>

                          </div>
                          </div>


                          </div>
                          </body>
                          </html>

                      '."\n\n".
                      $bound_last;
					  
                   if(mail($to,$subject,$message,$headers))
				   {
					 //  echo "<script> alert('mail delivered')</script>";
				   }	
else
{
	echo "mail not send".error_reporting(E_ALL);
	
}

/********************** */

                    $to = "virendra@benepik.com";

                    /** ******************************************************************************************************************************************************************** */

                    /*************************************************************************************************************************************************************** */
                    $subject = 'Administrator added new User';

                    $bound_text = "----*%$!$%*";
                    $bound = "--" . $bound_text . "\r\n";
                    $bound_last = "--" . $bound_text . "--\r\n";

                    $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n";
                    $headers .= "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

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
   <p>Employee Code : ' . $this->empCode . '</p>
   <p>Employee Name : ' . $this->first_name . ' ' . $this->last_name . '</p>
    <p>Email Id : ' . $this->mail1 . '</p>
  
   <p></p>
 
   <br>

   <p>Regards</p>
    <p>Team '.$program_name.'</p>
 
   
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .
                            $bound_last;



                    /** *********************************************************************************************************************************************************************** */

                    mail($to, $subject, $message, $headers);

                    echo "<script>alert('Data inserted successfully')</script>";
                    echo "<script>window.location='../add_user.php'</script>";
                }
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

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
        $alphabet = "0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function randomuuid($length) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /** ********************************random Password function ********************************** */

    function getUserDetail($clientid, $uuid) {
        try {
            $query = "select tem.*, cm.* from Tbl_EmployeeDetails_Master as tem join Tbl_ClientDetails_Master as cm on cm.client_id = tem.clientId where tem.clientId=:cli and tem.employeeId=:empid";
            $stmt = $this->DB->prepare($query);
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

}

?>