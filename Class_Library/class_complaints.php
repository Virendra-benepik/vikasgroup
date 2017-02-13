<?php 
require_once('class_connect_db_Communication.php');

class Complaint
{
	 public $db_connect;
	 public function __construct()
    {
	$dbh = new Connection_Mahle();
	$this->db_connect =  $dbh->getConnection_Communication();
    }
/*************************** Complaint details data into database  **************************************/	

	function entryComplaint($cid,$mail,$con,$sta)
	{        
	        $this->client_id  = $cid;
		$this->email = $mail;
		$this->content = $con;
		$this->status = $sta;

     date_default_timezone_set('Asia/Calcutta');
     $cd = date('d M Y, h:i A');

		try{
			$max = "select max(autoId) from Tbl_EmployeeComplaints";
			$stmt = $this->db_connect->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$c_id = $tr[0];
				$c_id1 = $c_id+1;
				$comid = "COM-".$c_id1;
			}
		  }
			catch(PDOException $e)
			{ 
                                echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);	
		        }
		
		/***************** Insert Client Data into benepik admin Database start ***************************************/
		try
		{
		$query = "insert into Tbl_EmployeeComplaints(complaintId,clientId,emailId,content,visiblity,date_of_complaint)
    values(:crid,:cid,:email1,:msg,:visibl,:date1)";
		$stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':crid',$comid, PDO::PARAM_STR);                               
                $stmt->bindParam(':cid',$this->client_id, PDO::PARAM_STR); 
                 $stmt->bindParam(':email1',$this->email, PDO::PARAM_STR); 
		$stmt->bindParam(':msg',$this->content, PDO::PARAM_STR); 
		$stmt->bindParam(':visibl',$this->status, PDO::PARAM_STR); 
		$stmt->bindParam(':date1',$cd, PDO::PARAM_STR);       
        
                if($stmt->execute())
	     {
	     
	     /*******************************mail to Hr*******************************************/

                 $to1 = "virendra@benepik.com";
                 $subject1 = "Complaint From Employee";
                 $text1 =$this->content;
                  if($this->status == 'no')
                  {
                  $email = $this->email;
                  }
                  else
                  {
                  $email = "Anonymous";
                  }

                 $headers1= "From:".$email."\r\n";

                 mail($to1,$subject1,$text1,$headers1);
                
	 /*********************************************************************************************/    
                  $response =array();
                  $response["success"]=1;
                  $response["message"]="Complaint is registered";
                  return json_encode($response);
             }
               
		}      //--------------------------------------------- end of try block
		catch(PDOException $e) 
		{
		echo $e;                 
        }              
        
}   
         
/*************************** Sugestion details data into database  **************************************/	

	function entrySugestion($cid2,$mail,$con,$sta)
	{
	         $this->client_id = $cid2;
		$this->email = $mail;
		$this->content = $con;
		$this->status = $sta;

     date_default_timezone_set('Asia/Calcutta');
     $cd = date('d M Y, h:i A');

		try{
			$max = "select max(autoId) from Tbl_EmployeeSugestions";
			$stmt = $this->db_connect->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$c_id = $tr[0];
				$c_id1 = $c_id+1;
				$comid = "SUG-".$c_id1;
			}
		  }
			catch(PDOException $e)
			{ 
                                echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);	
		        }
		
		try
		{
		$query = "insert into Tbl_EmployeeSugestions(sugestionId,clientId,emailId,content,visiblity,date_of_sugestion)
    values(:crid,:cid,:eml,:eid,:emid,:cmod)";
		$stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':crid',$comid, PDO::PARAM_STR);                               
                $stmt->bindParam(':cid',$this->client_id, PDO::PARAM_STR); 
                 $stmt->bindParam(':eml',$this->email, PDO::PARAM_STR); 
		$stmt->bindParam(':eid',$this->content, PDO::PARAM_STR); 
		$stmt->bindParam(':emid',$this->status, PDO::PARAM_STR); 
		$stmt->bindParam(':cmod',$cd, PDO::PARAM_STR);       
        
                if($stmt->execute())
	     {
	     
	     /*******************************mail to Hr*******************************************/

                 $to1 = "virendra@benepik.com";
                 $subject1 = "Suggestion From Employee";
                 $text1 =$this->content;
                  if($this->status == 'no')
                  {
                  $email = $this->email;
                  }
                  else
                  {
                  $email = "Anonymous";
                  }

                 $headers1= "From:".$email."\r\n";

                 mail($to1,$subject1,$text1,$headers1);
                
	 /*********************************************************************************************/ 
	     
                  $response =array();
                  $response["success"]=1;
                  $response["message"]="Sugestion is sent";
                  return json_encode($response);
             }
               
		}    
		catch(PDOException $e) 
		{
		echo $e;                 
        }              
        
   } 
   
   /******************************************************** Get Complain ***********************************/
   public $client_id;
   function getComplain($cid)
   {
   $this->client_id = $cid;
   try
   {
   $query = "select Tbl_EmployeeComplaints.*, Tbl_EmployeePersonalDetails.* from Tbl_EmployeeComplaints join Tbl_EmployeePersonalDetails on Tbl_EmployeeComplaints.emailId = Tbl_EmployeePersonalDetails.emailId where Tbl_EmployeeComplaints.clientId = :cid order by date_of_complaint desc";
   $stmt = $this->db_connect->prepare($query);
   $stmt->bindParam(':cid',$this->client_id,PDO::PARAM_STR);
   $stmt->execute();
   $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return json_encode($row);
   
   }
   catch(PDOException $e)
   {
   echo $e;
   
   }
   
   }
   
   /******************************************************** Get suggestion ***********************************/
   
   function getSuggestion($cid1)
   {
   $this->client_id = $cid1;
   try
   {
   $query = "select Tbl_EmployeeSugestions.*, Tbl_EmployeePersonalDetails.* from Tbl_EmployeeSugestions join Tbl_EmployeePersonalDetails on Tbl_EmployeeSugestions.emailId = Tbl_EmployeePersonalDetails.emailId where Tbl_EmployeeSugestions.clientId = :cid order by date_of_sugestion desc";
   $stmt = $this->db_connect->prepare($query);
   $stmt->bindParam(':cid',$this->client_id,PDO::PARAM_STR);
   $stmt->execute();
   $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return json_encode($row1);
   
   }
   catch(PDOException $e)
   {
   echo $e;
   
   }
   
   }
}
?>