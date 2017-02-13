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
  
/********************************* fetch max emptrainingid ********************************************/

function maxId()
  {
      try{
			$max = "select max(empTrainingId) from Tbl_EmployeeTraining";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$memptrainingid = $m_id+1;
				 return $memptrainingid;
			}
				
		}
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
		    }
		
      
  }

/************************************* end max emptrainingid ******************************************/  
  
/*********************************** add training details ***********************************************/
 
  function addTrainingDetails($clientid,$useruniqueid,$trainingname,$trainingdescription,$createddate,$status)
  {
     
     try{
     $query = "insert into Tbl_TrainingMaster(clientId,trainingName,trainingDescription,createdBy,createdDate,status)
            values(:clientid,:trainingname,:trainingdes,:createdby,:createddate,:status)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':clientid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':trainingname',$trainingname, PDO::PARAM_STR);
            $stmt->bindParam(':trainingdes',$trainingdescription, PDO::PARAM_STR);
            $stmt->bindParam(':createdby',$useruniqueid, PDO::PARAM_STR);
            $stmt->bindParam(':createddate',$createddate, PDO::PARAM_STR);
			 $stmt->bindParam(':status',$status, PDO::PARAM_INT);
            
           if($stmt->execute())
           {
           $result['success'] = 1;
           $result['msg'] = "learning Details Add Successfully";
		   $res = json_encode($result);
           return $res;
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}


/*********************************** end add training details ***********************************************/

/******************************** viewtraininglist **********************************************************/

 function viewTraininglist($clientid)
  {
	  $status = 1;
 	  try
	  {
         $query = "select trainingId,trainingName from Tbl_TrainingMaster where clientId =:cli AND status =:status order by createdDate desc";
		 $stmt = $this->DB->prepare($query); 
         $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
		 $stmt->bindParam(':status',$status, PDO::PARAM_INT);
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
 	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	 return json_encode($rows);
		
      
  }

/*********************************************** end viewtraining list*****************************************/

/*********************************************** view employee info ********************************************/

function employeeinfo($clientid,$keyword)
  {
	  $status = 1;
 	  try
	  {
         $query = "SELECT * FROM Tbl_EmployeeDetails_Master WHERE clientId=:clientid AND (firstName like CONCAT('%',:keyword,'%') OR employeeCode like CONCAT('%',:keyword,'%') OR emailId like CONCAT('%',:keyword,'%')) ORDER BY firstName,employeeCode,emailId";
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

/*************************************** add employee training Details ********************************************/

 function addEmployeeTrainingDetails($clientid,$useruniqueid,$trainingid,$employee_id,$trainingdate,$remark,$createddate,$status)
  {
     
     try{
     $query = "insert into Tbl_EmployeeTraining(clientId,trainingId,employeeId,trainingDate,createdBy,createdDate,remark,status)
            values(:cid,:trainingid,:empid,:trainingdate,:createdby,:createddate,:remark,:status)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':trainingid',$trainingid, PDO::PARAM_INT);
            $stmt->bindParam(':empid',$employee_id, PDO::PARAM_INT);
            $stmt->bindParam(':trainingdate',$trainingdate, PDO::PARAM_STR);
            $stmt->bindParam(':createdby',$useruniqueid, PDO::PARAM_STR);
			$stmt->bindParam(':createddate',$createddate, PDO::PARAM_STR);
			$stmt->bindParam(':remark',$remark, PDO::PARAM_INT);
			$stmt->bindParam(':status',$status, PDO::PARAM_INT);
            
           if($stmt->execute())
           {
           $result['success'] = 1;
           $result['msg'] = "Employee Learning Details Add Successfully";
		   $res = json_encode($result);
           return $res;
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}


/************************************* end employee training details **********************************************/

/***************************** view employee learining detail list **************************************************/

function viewemployeeleariningdetaillist($clientid )
  {
	  $status = 1;
 	  try
	  {
         $query = "select tm.trainingName,CONCAT(edm.firstName,edm.lastName)as employeename,et.trainingDate,et.remark from Tbl_EmployeeTraining as et JOIN Tbl_TrainingMaster as tm ON et.trainingId = tm.trainingId JOIN Tbl_EmployeeDetails_Master as edm ON et.employeeId = edm.autoId where et.clientId = :cli AND tm.status = :status order by et.createdDate desc";
		 $stmt = $this->DB->prepare($query); 
         $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
		 $stmt->bindParam(':status',$status, PDO::PARAM_INT);
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
 	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	 return json_encode($rows);
		
      
  }
/******************************** end view employee learining detail list *********************************************/

/************************************ insert into welcome table *********************************************/

  function createWelcomeData($clientid,$trainingid,$type,$remark,$createddate,$useruniqueid)
  {
    
     try{
     $query = "insert into Tbl_C_WelcomeDetails(clientId,id,type,title,createdDate,createdBy)
            values(:cid,:trainingid,:type,:title,:createddate,:createdby)";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cid',$clientid, PDO::PARAM_STR);
             $stmt->bindParam(':trainingid',$trainingid, PDO::PARAM_INT);
             $stmt->bindParam(':type',$type, PDO::PARAM_STR);
             $stmt->bindParam(':title',$remark, PDO::PARAM_STR);
             $stmt->bindParam(':createddate',$createddate, PDO::PARAM_STR);
             $stmt->bindParam(':createdby',$useruniqueid, PDO::PARAM_STR);
                  
               if($stmt->execute())
                  {
                  $ft = 'True';
                  return $ft;
                  }
     }
     catch(PDOException $e)
     {
     echo $e;
     } 
  }
/**************************************** end insert into welcome table ******************************************/

/********************************** view training data **********************************************/

function viewemployeelearining($clientid,$trainingid)
  {
	 
 	  try
	  {
         $query = "select * from Tbl_TrainingMaster where clientId = :cli AND trainingId = :empid";
		 $stmt = $this->DB->prepare($query); 
         $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
		 $stmt->bindParam(':empid',$trainingid, PDO::PARAM_INT);
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
 	 $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    	 return json_encode($rows);
		
      
  }

/************************************ end view training data *****************************************/

}
?>