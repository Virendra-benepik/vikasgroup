<?php
//session_start();
require_once('class_connect_db.php');
include_once('class_connect_db_admin.php');

class SubAdmin
{

  public $DB;
   public $DB_Admin;
  public function __construct()
  {
    $db = new Connection_Client();
      $this->DB = $db->getConnection_Client();
      
      $db1 = new Connection();
      $this->DB_Admin = $db1->getConnection();
  }
  
 


public $emailid;
public $group;
public $created_by;

function createSubAdmin($email1,$group,$createdby)
{
 $this->emailid = $email1;
 $this->group = $group;
 $count = count($this->group);
 //print_r($this->group);
 $this->created_by = $createdby;
 //echo $this->emailid;
 //echo $this->created_by;
  date_default_timezone_set('Asia/Calcutta');
 $cd = date('d M Y, h:i A');
  $status = "Active";
 
  
  for($i=0;$i<$count;$i++)
  {
                   try{
			$max = "select max(autoId) from SubAdminAccess";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$subid = "SA-".$m_id1;
				
				 }
				
				}
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
				}
		

		//echo $postid;
		try
		{
		 $qu = "insert into SubAdminAccess(subAdminId,emailId,access,createdBy,createdDate,status)
                values(:sid1,:em,:acs,:cb,:cd,:st)";
                $stmt = $this->DB->prepare($qu);
                $stmt->bindParam(':sid1',$subid, PDO::PARAM_STR);
                $stmt->bindParam(':em',$this->emailid, PDO::PARAM_STR);
                $stmt->bindParam(':acs',$this->group[$i], PDO::PARAM_STR);
                $stmt->bindParam(':cb',$this->created_by, PDO::PARAM_STR);
                $stmt->bindParam(':cd',$cd, PDO::PARAM_STR);
                $stmt->bindParam(':st',$status, PDO::PARAM_STR);
              
                if($stmt->execute())
                {
                 
                $response['success'] = 1;
                $response['msg'] = 'SubAdmin Successfully Createdd';
                // return($response);
                           }
                
		}
		catch(PDOException $ex)
		{
		 echo $ex;
		}
      }
      self::addInAdmin();
      return($response);
  }
  
  function addInAdmin()
  {
  
   $sub_admin = "SubAdmin";
  $cid = $_SESSION['client_id'];
  date_default_timezone_set('Asia/Calcutta');
 $cd1 = date('d M Y, h:i A');
  $status = "Active";
                try{
			$max = "select max(autoId) from ClientAdminDetails";
			$stmt = $this->DB_Admin->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$adminid = "Ad-".$m_id1;
				echo $adminid;
				 }
				
				}
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
				}
			
              try
              {
              $query = "insert into ClientAdminDetails(adminId,clientId,adminEmail,createdDate,createdby,status)
              values(:aid,:cid,:aemail,:cd1,:cb,:st)";
              
               $stmt2 = $this->DB_Admin->prepare($query);
                $stmt2->bindParam(':aid',$adminid, PDO::PARAM_STR);
                $stmt2->bindParam(':cid',$cid, PDO::PARAM_STR);
                $stmt2->bindParam(':aemail',$this->emailid, PDO::PARAM_STR);
                $stmt2->bindParam(':cd1',$cd1, PDO::PARAM_STR);
                $stmt2->bindParam(':cb',$this->created_by, PDO::PARAM_STR);
               $stmt2->bindParam(':st',$status, PDO::PARAM_STR);
             if($stmt2->execute())
              {
              
              $qu1 = "update UserDetails set accessibility =:acs where emailId = :em1";
                 $stmt1 = $this->DB->prepare($qu1);
                $stmt1->bindParam(':acs',$sub_admin, PDO::PARAM_STR);
                $stmt1->bindParam(':em1',$this->emailid, PDO::PARAM_STR);
                $stmt1->execute();
              
              
              
               $to = $this->emailid;
$subject = "Dear Sir";
$txt = "Your are selected as Admin ";
$headers = "From: info@benepik.com" . "\r\n";

if(mail($to,$subject,$txt,$headers))
{
//echo "<script>alert('mail sent succefully')</script>";
}
else
{
//echo "<script>alert('mail sent error')</script>";
}
              }
              }
              catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
				}
              
  }
	  
	  
  }
	  
 	   
    
      /**********************************file csv start ***********************************/  
 
?>