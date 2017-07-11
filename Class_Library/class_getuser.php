<?php
include_once('class_connect_db_Communication.php');

class GetUser
{
    
    public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
      	$this->DB = $db->getConnection_Communication();

  }

  public $postid;
 public $cid;
  function getAllUser($cid,$company,$access)
  {
      $this->cid = $cid;
      echo $access;
      if($access == 'Admin')
      { 
      $query = "select ud.*,up.* from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId  where  ud.clientId =:cid order by ud.createdDate desc";
      }
 else {
           $query = "select ud.*,up.* from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId  where ud.companyUniqueId = :comp and ud.clientId =:cid order by ud.createdDate desc";
 }
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
		 $stmt->execute(array(':cid'=>$this->cid,':comp'=>$company));
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	 return json_encode($rows);
		
      
  }

function updateUserStatus($sid, $sta,$access) 
                {
        $this->sid = $sid;
        $this->status = $sta;
     if($access == 'User' || $access == 'guestuser')
     {
         try {        
             $query1 = "update Tbl_EmployeeDetails_Master set status=:sta where employeeId =:sid1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':sid1', $this->sid, PDO::PARAM_STR);
            $stmt1->bindParam(':sta', $this->status, PDO::PARAM_STR);
            $stmt1->execute();
	
            if ($stmt1->execute()) 
                {
                $response["success"] = 1;
                $response["message"] = "User status change now";              
            }
        } catch (PDOException $e) {
          //  echo $e;
             $response["success"] = 0;
                $response["message"] = "there is some problem please contact info@benepik.com".$e;
        }
         
     }
 else {
         
      try {        
             $query1 = "update Tbl_EmployeeDetails_Master set status=:sta where employeeId =:sid1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':sid1', $this->sid, PDO::PARAM_STR);
            $stmt1->bindParam(':sta', $this->status, PDO::PARAM_STR);
            $stmt1->execute();
	
            $query = "update Tbl_ClientAdminDetails set status= '0' where userUniqueId =:sid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $this->sid, PDO::PARAM_STR);
         //   $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
            if ($stmt->execute()) 
                {
                $response["success"] = 1;
                $response["message"] = "User status change now";              
            }
        } catch (PDOException $e) {
          //  echo $e;
             $response["success"] = 0;
                $response["message"] = "there is some problem please contact info@benepik.com".$e;
        }
 }
        
       
         return json_encode($response);
    }
    /** ******************FOR GETTING ANSWERS FROM DATABASE BASED ON POLLID STARTS*****************************/
}
?>