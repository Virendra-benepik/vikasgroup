<?php
include_once('class_connect_db_Communication.php');

class GetGroupData
{
  public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
  
  }
  
  public $clientid;
  function getClientLocation($cid)
  {
  $this->clientid = $cid;
   try
   {
           $query = "select distinct(location) from Tbl_EmployeeDetails_Master where clientId =:cid";
           $stmt = $this->DB->prepare($query); 
           $stmt->bindParam(':cid',$this->clientid, PDO::PARAM_STR);
	   $stmt->execute();
	    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	   
    	 return json_encode($rows);
   }
   catch(PDOException $ex)
   {
     echo $ex; 
   }
  }
  
   function getClientDepartment($cid)
  {
  $this->clientid = $cid;
   try
   {
           $query = "select distinct(department) from Tbl_EmployeeDetails_Master where clientId =:cid";
           $stmt = $this->DB->prepare($query); 
           $stmt->bindParam(':cid',$this->clientid, PDO::PARAM_STR);
	   $stmt->execute();
	    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	 return json_encode($rows);
   }
   catch(PDOException $ex)
   {
     echo $ex; 
   }
  }
  
  
   function getClientDemoGraphy($cid)
  {
  $this->clientid = $cid;
   try
   {
           $query = "select Tbl_ClientGroupDemoGraphy.* from Tbl_ClientGroupDemoGraphy where clientId =:cid";
           $stmt = $this->DB->prepare($query); 
           $stmt->bindParam(':cid',$this->clientid, PDO::PARAM_STR);
	   $stmt->execute();
	    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //echo "<pre>";
           // print_r($rows);
	   $count = count($rows);
           $response['success'] = 1;
	    $response['posts'] = array();
	    
	    for($i=0;$i<$count;$i++)
	    {
	    
	    $demo = $rows[$i]['demoGraphy'];
	    
	   // echo $demo;
	   $query1 = "select distinct(".$demo.") from Tbl_EmployeeDetails_Master where clientId=:cid";
	   $stmt1 = $this->DB->prepare($query1); 
           $stmt1->bindParam(':cid',$this->clientid, PDO::PARAM_STR);
	    if($stmt1->execute())
	    {
	    $parameter = $stmt1->fetchAll(PDO::FETCH_COLUMN, 0);
	    
	    
	    $singleValues["columnName"] = $demo;
	    $singleValues["distinctValuesWithinColumn"] = $parameter;
	    array_push($response["posts"],$singleValues);
	    }
	  
	    }
    	
	  return json_encode($response);
   }
   catch(PDOException $ex)
   {
     echo $ex; 
   }
  }
}
?>