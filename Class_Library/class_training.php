<?php
include_once('class_connect_db_Communication.php');

class Training
{
  public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
	$this->DB = $db->getConnection_Communication();	
  
  }
  


/*********************************************** view employee info ********************************************/

function employeeinfo($clientid,$keyword)
  {
	  $status = 1;
 	  try
	  {
         $query = "SELECT * FROM Tbl_EmployeeDetails_Master WHERE clientId=:clientid AND (firstName like CONCAT('%',:keyword,'%') OR employeeCode like CONCAT('%',:keyword,'%') OR emailId like CONCAT('%',:keyword,'%'))  AND accessibility NOT IN ('Admin','guestuser') ORDER BY firstName,employeeCode,emailId";
		 $stmt = $this->DB->prepare($query); 
         $stmt->bindParam(':clientid',$clientid, PDO::PARAM_STR);
		 $stmt->bindParam(':keyword',$keyword, PDO::PARAM_STR);
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
 	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	 return json_encode($rows);
		
      
  }

/*********************************************** end view employee info ******************************************/

}
?>