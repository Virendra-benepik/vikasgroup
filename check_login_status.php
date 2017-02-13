<?php
session_start();
include_once("Class_Library/class_connect_db_deal.php");
class Auth
{
 public $DB;
  public function __construct()
  {
    $db = new Connection_Deal();
      $this->DB = $db->getConnection_Deal();
      
  }
  function check_session()
  {
// Initialize some vars
$user_ok = false;
$log_pass = "";
$log_username = "";


if(isset($_SESSION["Email"]) && isset($_SESSION["password"]))
 {
	
	//header('Location:welcome.php');
	echo "<script>window.location='welcome.php'</script>";
       $user_ok = true;
       exit();
} 
else if(isset($_COOKIE[$cookie_name]) && isset($_COOKIE[$cookie_name1]))
{
    $user_ok = true;
    $log_pass = $_COOKIE[$cookie_name];
    $log_username =  $_COOKIE[$cookie_name1];

echo "<script>alert('hello there !')</script>";
echo "<script>alert('$log_pass')</script>";
echo "<script>alert('$log_username')</script>";
    
      $query = "select C.*,CA.*,U.*,UF.* from ClientAdminDetails as CA 
     join B_Client_Data as C on C.client_id = CA.clientId 
     join UserDetails as U on CA.adminEmail = U.emailId 
     join UserPersonalDetails as UF on UF.emailId = U.emailId where CA.adminEmail = :mail";
             $stmt = $this->DB->prepare($query);
           
             $stmt->execute(array(':mail'=>$log_username));
             
             $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
             
              if($stmt->rowCount() > 0)
               {
              echo "mail match"."<br/>";
               $useremail = $userRow['adminEmail'];
               $clientname = $userRow['client_name'];
               $clientid = $userRow['clientId'];
             //  echo $clientid."<br/>";
              
               //echo $userRow['password']."<br/>";
                $access = $userRow['accessibility'];
              //  echo $access."<br/>";
                $iduser = $userRow['userId'];
            $mail = $userRow['emailId'];

                if($log_pass == $userRow['password'])
                 {
                // echo $access;
                //@session_start();
                $_SESSION['user_session'] = $userRow['userId'];
                $_SESSION['user_name'] = $userRow['firstName'];
                $_SESSION['user_email'] = $useremail;
                $_SESSION['user_access'] = $subadmin;
                $_SESSION['user_type'] = $access;
                $_SESSION['client_name'] = $clientname;
                $_SESSION['client_id'] = $clientid;
                $_SESSION['password'] = $this->password;
                $_SESSION['image_name'] = $userRow['userImage'];
                 //  $_SESSION['user_contact'] = $userRow['cp_contact'];
                $_SESSION['program_name'] = $userRow['program_name'];
                $_SESSION['dedicated_mail'] = $userRow['dedicated_mail'];
                
               echo "<script>window.location='welcome.php'</script>"; 
              exit();
             }
   
 }
}
else
{
echo "<script>window.location='index.php'</script>"; 
}
}
}
?>