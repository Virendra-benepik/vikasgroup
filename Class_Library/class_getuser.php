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
  function getAllUser($cid)
  {
  $this->cid = $cid;
      $query = "select ud.*,up.* from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId  where ud.clientId =:cid order by ud.createdDate desc";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
		 $stmt->execute(array(':cid'=>$this->cid));
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll();
    	 return json_encode($rows);
		
      
  }

/* this is unuse

  function getSinglePost($pid)
  {
     $this->postid = $pid;
    
     try{
     $query = "Select * from PostDetails where post_id =:pid";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':pid',$this->postid, PDO::PARAM_STR);
             
             if($stmt->execute())
                  {
                  $rows = $stmt->fetchAll();
    	           return json_encode($rows);
                  }
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }
  
  function getIndexPost()
  {
	  $query = "select * from PostDetails order by created_date desc limit 0,3";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll();
    	 return json_encode($rows);
        //  }
		  
  }*/
}
?>