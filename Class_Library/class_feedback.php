<?php
include_once('class_connect_db_Communication.php');

class Feedback
{
  public $DB;
  public function __construct()
  {  
    	$db = new Connection_Communication();
      	$this->DB = $db->getConnection_Communication();
  }
  public $feedbackidss;
  public $clientid;
  function getallfeedbacks($feedid,$cid)
  {
     $this->feedbackidss = $feedid;
      $this->clientid = $cid;
      try{
      $query = "select * from Tbl_Analytic_EmployeeHappiness where feedback_id =:fid and clientId =:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':fid',$this->feedbackidss, PDO::PARAM_STR);
            $stmt->bindParam(':cid',$this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll();
            if($row)
             {
                  $response = array();
                  foreach($row as $r)
                  {   
                     $posts["comment"] = $r["comment"];
                     $posts["date_of_feedback"] = $r["date_of_feedback"];
                    
                     array_push($response,$posts);
                  }
                  return json_encode($response);
             } 
                  
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }

  public $feedbackids;
  
  function getallfeedback($feedid,$startdate,$enddate, $cid)
  {
     $this->feedbackids = $feedid;
     $this->startdat = $startdate;
     $this->enddat = $enddate;
  $this->clientid = $cid;
      try{
     $query = "select * from Tbl_Analytic_EmployeeHappiness where feedback_id =:fid and  clientId =:cid and date_of_feedback between :sdat and :edat ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':fid',$this->feedbackids, PDO::PARAM_STR);
            $stmt->bindParam(':sdat',$this->startdat, PDO::PARAM_STR);
            $stmt->bindParam(':edat',$this->enddat, PDO::PARAM_STR);
             $stmt->bindParam(':cid',$this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll();
            if($row)
             {
                  $response = array();
                  foreach($row as $r)
                  {   
                     $posts["comment"] = $r["comment"];
                     $posts["date_of_feedback"] = $r["date_of_feedback"];
                    
                     array_push($response,$posts);
                  }
                  return json_encode($response);
             } 
                  
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }
  
  
  function create_Feedback($client,$feedid,$val,$feedcontent,$feedby)
  {
     $this->clientid=$client;
     $this->feedbackid = $feedid;
     $this->value = $val;
     $this->feedbackcontent = $feedcontent;
     $this->feedbackby = $feedby;

     date_default_timezone_set('Asia/Calcutta');
     $channel_date = date('Y-m-d h:i:s a');
		     
     try{
     $query = "insert into Tbl_Analytic_EmployeeHappiness(clientId,feedback_id,value,comment,userUniqueId,date_of_feedback)
            values(:cli,:cid,:val,:ct,:cb,:cc)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli',$this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':cid',$this->feedbackid, PDO::PARAM_STR);
             $stmt->bindParam(':val',$this->value, PDO::PARAM_STR);
            $stmt->bindParam(':ct',$this->feedbackcontent, PDO::PARAM_STR);
            $stmt->bindParam(':cb',$this->feedbackby, PDO::PARAM_STR);
            $stmt->bindParam(':cc',$channel_date, PDO::PARAM_STR);
            if($stmt->execute())
            {	
              $response = array();
              $response["success"] = 1;
              $response["message"] = "Successfully inserted data";
              return json_encode($response); 
    	    }
            else
            {
              $response = array();
              $response["success"] = 0;
              $response["message"] = "no inserted data";
              return json_encode($response);
            }
                  
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }
}
?>