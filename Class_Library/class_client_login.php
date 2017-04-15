<?php
/*******************************  database change *******************/
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once('class_connect_db_Communication.php');
class ClientLogin
{
    
    public $DB;
  public function __construct()
  {
  
       $db = new Connection_Communication();
      $this->DB = $db->getConnection_Communication();
  }

  public $emailid;
  public $password;
//  public $loggedin;

  function clientLoginCheck($email,$pass)
  {
     $this->emailid = $email;
     $this->password = $pass;
   //  $this->loggedin = $remember;
 // echo $this->loggedin;
     $user_password = md5($this->password);
   // echo "<br/>".$this->emailid;
//    echo "<br/>".$this->password;
  //  echo "<br/>".$user_password;
     try{
     $query = "select C.*,CA.*,U.*,UP.* from Tbl_ClientAdminDetails as CA 
     join Tbl_ClientDetails_Master as C on C.client_id = CA.clientId 
     join Tbl_EmployeeDetails_Master as U on CA.userUniqueId = U.employeeId 
     join Tbl_EmployeePersonalDetails as UP on UP.employeeId = U.employeeId where U.emailId = :mail or U.employeeCode = :mail";
             $stmt = $this->DB->prepare($query);
           
             $stmt->execute(array(':mail'=>$this->emailid));
             
             $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
           
              if($stmt->rowCount() > 0)
               {
            //  echo "mail match"."<br/>";
               $useremail = $userRow['emailId'];
               $clientname = $userRow['client_name'];
               $clientid = $userRow['clientId'];
               $googleapi = $userRow['googleApiKey'];
             //  echo $clientid."<br/>";
              
              // echo $userRow['password']."<br/>";
                $access = $userRow['accessibility'];
              //  echo $access."<br/>";
                $iduser = $userRow['userId'];
            $mail = $userRow['emailId'];

                if($user_password == $userRow['password'])
                 {
              //   echo $access;
                @session_start();
                $_SESSION['user_session'] = $userRow['userId'];
                $_SESSION['user_unique_id'] = $userRow['employeeId'];
                $_SESSION['user_name'] = $userRow['firstName'] . " " .$userRow['lastName'];
                $_SESSION['user_email'] = $useremail;
                $_SESSION['user_type'] = $access;
                $_SESSION['client_name'] = $clientname;
                $_SESSION['client_id'] = $clientid;
                $_SESSION['password'] = $this->password;
                $_SESSION['image_name'] = $userRow['userImage'];
                 //  $_SESSION['user_contact'] = $userRow['cp_contact'];
                $_SESSION['program_name'] = $userRow['program_name'];
                $_SESSION['dedicated_mail'] = $userRow['dedicated_mail'];
                $_SESSION['gpk'] = $googleapi;
		$_SESSION['iosPemfile'] = $userRow['iosPemfile'];
                $_SESSION['usercompany'] = $userRow['companyName'];
                $_SESSION['companyUniqueId'] = $userRow['companyUniqueId'];
               
               $res = 'True';
              $result['success'] = $res;
         return json_encode($result);
             }
             else
             {
               $result['success'] = 1;
			   $result['email'] = $this->emailid;
			  $result['msg'] = "Sorry ! Please check ur password";
         return json_encode($result);
             }
          }
          else
          {
			  $result['success'] = 0;
			  $result['msg'] = "Sorry ! you are not authorized user please check ur email id";
         return json_encode($result);
          }
     }
     catch(PDOException $e)
     {
     echo $e;
     }
     
  // return $res;
  }
  
  
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
   
   
   public function redirect($url)
   {
   
   echo "<script>window.location='$url'<script>";
   //    header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        //setcookie ("user_email", '', time() - (2*60));
        //setcookie ("password", '', time() - (2*60));
        return true;
   }
 /******************************************* forfet password ****************************/  
   function forgetPassword($email)
   {
    $this->emailid = $email;
   
   try
   {
   $rt = "select * from Tbl_EmployeeDetails_Master where emailId =:mail";
    $stmt =  $this->DB->prepare($rt);
     $stmt->bindParam(':mail',$this->emailid,PDO::PARAM_STR);
   $stmt->execute();
   $val = $stmt->fetch();
    if($stmt->rowCount() > 0)
   {
          $email = $val['emailId'];
          $randomAlpha = self::randomalpha(6);
	  $randomDigit = self::randomdigit(2);
	  $randompassword = $randomAlpha.$randomDigit;
		 $md5password = md5($randompassword);
  
  $query3 = "update Tbl_EmployeeDetails_Master set password =:pass where emailId =:email";
    $st = $this->DB->prepare($query3);
    $st->bindParam(':pass', $md5password , PDO::PARAM_STR);
    $st->bindParam(':email',$email,PDO::PARAM_STR); 
   if( $st->execute())  {
   
   $to1 = $email;
$subject1 = "Vikas Live Password Assistance";

$message = '<html><body>';
//$message .= "<h6>Dear ".$val['firstName'].", </h6>";
$message .= "Dear ".$val['firstName'].",";
$message .= "<p>We received a request to send the password associated with this e-mail address.</p>";
$message .='<p>Your Password : '. $randompassword.'</p>';
$message .='<p>If you did not request to have your password you can safely ignore this email. Rest assured your customer account is safe.</p>';
$message .= "<p>Regards,</p>";
$message .= "<p>Team Vikas Live</p>";
$message .= '</body></html>';

$headers1 = "From: Vikas Live <vikaslive@benepik.com> \r\n";
$headers1 .= "MIME-Version: 1.0\r\n";
$headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
       if(mail($to1,$subject1,$message,$headers1))
       {
       $msg = "Password send sucessfully";
       $resp['msg'] = $msg;
       $resp['success'] = 1;
       return json_encode($resp);
       }          
   
   }
    
   }
   else
   {
   $msg = "wrong password";
       $resp['msg'] = $msg;
       $resp['success'] = 0;
       return json_encode($resp);
   }
   }
   catch(PDOException $ex)
   {
   echo $ex;
   }
   }
   
   /************************************************** Random Password generator ************************************/
   
    function randomalpha($length) 
	 {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
    }	
    function randomdigit($length) 
	 {
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