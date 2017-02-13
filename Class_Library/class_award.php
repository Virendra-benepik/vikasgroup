<?php 
/*
Created By :- Monika Gupta
Created Date :- 26/10/2016
Description :- Create Function for Award Master . 
*/


include_once('class_connect_db_Communication.php');

/**----- -----------------------   $db_connect     is object of connection page ---------------------------------**/
class award
{
	 public $db_connect;
	 public function __construct()
    {
        $dbh = new Connection_Communication();
		$this->db_connect =  $dbh->getConnection_Communication();
    }
/*************************** insert award into database  **************************************/	
	function createAward($award_name,$award_description,$client_id,$awardimgname,$useruniqueid)
	{
		
        $status = 1;
		
		/***************** Insert Award into Database start ***************************************/
		try
		{	
		$query = "call SP_AddAwardMaster(:award_name,:awarddescription,:createdby,:status,:clientid,:awardimg,@newawardid)";
		$stmt = $this->db_connect->prepare($query);
		   $stmt->bindParam(':award_name',$award_name, PDO::PARAM_STR); 
		   $stmt->bindParam(':awarddescription',$award_description, PDO::PARAM_STR); 
		   $stmt->bindParam(':createdby',$useruniqueid, PDO::PARAM_STR); 
		   $stmt->bindParam(':status',$status , PDO::PARAM_INT); 
		   $stmt->bindParam(':clientid',$client_id , PDO::PARAM_STR);
		   $stmt->bindParam(':awardimg',$awardimgname , PDO::PARAM_STR);		   
		   $result = $stmt->execute();
		  	    
		   $stmt->closeCursor();
		   $quer = "SELECT @newawardid";
		   $newawardidreturn = $this->db_connect->query($quer)->fetch(PDO::FETCH_ASSOC);
		   $newawardid = $newawardidreturn['@newawardid'];
		   
			if($result)
			 {
			 $response["success"] = 1;
			 $response["newawardid"] = $newawardid;
			 $response["msg"] = "Award Added Successfully";
			 }
		 }
		 catch(PDOException $e) 
		 {
		 echo $e;
         $response["success"] = 0;
	     $response["msg"] = $e;
		 } 
		return($response);
	}


/***************************  Fetch data from Award Master **************************************/	
	function viewawards($clientid)
	{ 
	$a="nothing";
                try
               {
			   $query = "call SP_getAwardsDetails(:clientid)";
               $stmt = $this->db_connect->prepare($query);
			   $stmt->bindParam(':clientid',$clientid, PDO::PARAM_STR); 
				   if($stmt->execute())
				   {
					   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
					   if($rows)
					   {
						$response["success"] = 1;
						$response["Data"]   = $rows;
						$a= json_encode($response);                   
					   }
					}
                }
                catch(PDOException $e)
                {
                 $response["success"] = 0;
				 $response["message"] = "Database Error!". $e->getMessage();
				 $a= json_encode($response);
                }
                return($a);
                
    }    //------------------------end of viewawards function	
	
/***************************  Fetch data from user details **************************************/	
	function viewemployeedetails($clientid)
	{ 
	
	$a="nothing";
                try
               {
			   $query = "call SP_getEmployeeDetails(:clientid)";
               $stmt = $this->db_connect->prepare($query);
			    $stmt->bindParam(':clientid',$clientid, PDO::PARAM_STR); 
				   if($stmt->execute())
				   {
					   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
					   if($rows)
					   {
						$response["success"] = 1;
						$response["Data"]   = $rows;
						$a= json_encode($response);                   
					   }
					}
                }
                catch(PDOException $e)
                {
                 $response["success"] = 0;
				 $response["message"] = "Database Error!". $e->getMessage();
				 $a= json_encode($response);
                }
                return($a);
                 
    }    // end of viewemployeedetails function
/*************************** insert Employee award detail into database  **************************************/	
	function employeeAward($employeeid,$awardid,$commentdescription,$awarddate,$clientid)
	{
		try
		{	
		$query = "call SP_AddEmployeeAward(:employeeid,:awardid,:commentdescription,:awarddate,:clientid)";
		$stmt = $this->db_connect->prepare($query);
		   $stmt->bindParam(':employeeid',$employeeid, PDO::PARAM_STR);
		   $stmt->bindParam(':awardid',$awardid, PDO::PARAM_STR);
		   $stmt->bindParam(':commentdescription',$commentdescription, PDO::PARAM_STR); 
		   $stmt->bindParam(':awarddate',$awarddate, PDO::PARAM_STR);
		   $stmt->bindParam(':clientid',$clientid, PDO::PARAM_STR);
				
		   $result = $stmt->execute();
		   
			if($result)
			 {
			 $response["success"] = 1;
			 $response["msg"] = "Add Employee Award Record Successfully";
			 }
		 }
		 catch(PDOException $e) 
		 {
		 echo $e;
         $response["success"] = 0;
	     $response["msg"] = $e;
		 } 
		return($response);
	}
	



/**************************************** fetch employee info ***********************************/

function employeeinfo($clientid,$keyword)
	{ 
	$a="nothing";
                try
               {
			   //$query = "SELECT * FROM userdetails WHERE firstName like '" . $_POST["keyword"] . "%' ORDER BY firstName";
               //$query = "SELECT * FROM userdetails WHERE firstName like '" . $_POST["keyword"] . "%' OR employeeCode like '" . $_POST["keyword"] . "%' OR emailId like '" . $_POST["keyword"] . "%' ORDER BY firstName ,employeeCode ,emailId";
               $query = "call SP_getEmployeeinfo(:clientid,:keyword)";
			   $stmt = $this->db_connect->prepare($query);
			   $stmt->bindParam(':clientid', $clientid, PDO::PARAM_STR);
			   $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
			   	   if($stmt->execute())
				   {
					   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
						//echo "<pre>";
						//print_r($rows);
						//die;
					   if($rows)
					   {
						$response["success"] = 1;
						//$response["message"] = "fetch successfully";
						$response["Data"]= $rows;
						$a= json_encode($response);                   
					   }
					}
                }
                catch(PDOException $e)
                {
                 $response["success"] = 0;
				 $response["message"] = "Database Error!". $e->getMessage();
				 $a= json_encode($response);
                }
                return($a);
				//return ($response);
                
    }    


/********************************** end fetch employee info *************************************/

}
?>