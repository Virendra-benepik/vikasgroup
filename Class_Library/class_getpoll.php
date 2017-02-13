<?php
include_once('class_connect_db_Communication.php');

class GetPoll
{
 public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
    	$this->DB = $db->getConnection_Communication();
  
  }
  
  public $pollid;
  public $clientid;
  public $pollimg;
  public $pollques;
  public $group;
  public $author;
  public $cdate;
  public $status;
 
 

/********************FOR GETTING ANSWERS FROM DATABASE BASED ON POLLID STARTS*****************************/
  
function getAnswerOptions($pollid,$clientid)
  {
     $this->idpoll = $pollid;
     $this->idclient = $clientid;
   
     try{
     $query = "select * from Tbl_C_PollDetails where pollId=:poll and clientId=:cli";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':poll',$this->idpoll, PDO::PARAM_STR);
             $stmt->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetchAll();

$response = array();

               if($rows)
                  {
                  $poll = $rows[0]["pollId"];
                  $client = $rows[0]["clientId"];
                  
             $query1 = "select * from Tbl_C_PollOption where pollId=:poll and clientId=:cli";
             $stmt1 = $this->DB->prepare($query1);
             $stmt1->bindParam(':poll',$poll, PDO::PARAM_STR);
             $stmt1->bindParam(':cli',$client, PDO::PARAM_STR);
             $stmt1->execute();
             $row = $stmt1->fetchAll(PDO::FETCH_ASSOC);
               if($row)
                  {
                  $response["success"]=1;
                  $response["message"]="You successfully fetched";
                  $response["poll_question"]=$rows[0]["pollQuestion"];
                  $response["poll_image"]= $rows[0]["pollImage"];
                  $response["option"]= $row;
                  return json_encode($response);
                  }
                  } 
                  else
                  {
                  $response["success"]=0;
                  $response["message"]="client id or poll id doesn't match";
                  return json_encode($response);
                  } 
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }

 /********************FOR GETTING ANSWERS FROM DATABASE BASED ON POLLID ENDS*****************************/

function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue/1024;
        
        if($valueimage > 40)
        {  
	$info = getimagesize($source_url);
 
	if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
	elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
	elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
 
	//save it
	imagejpeg($image, $destination_url, $quality);
 
	//return destination file url
	return $destination_url;
        }
        else
        {
          move_uploaded_file($source_url,$destination_url);
        }
}


 
  function pollMaxId()
  {
      try{
			$max = "select max(autoId) from Tbl_C_PollDetails";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$pollid = "Poll-".$m_id1;
				 
				 return $pollid;
				 }
				
				}
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
		        }
		
      
  }
  function optionMaxId()
  {
      try{
			$max = "select max(autoId) from Tbl_C_PollOption";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$optionid = "Opt-".$m_id1;
				 
				 return $optionid;
				 }
				
		         }
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
		        }
		
      
  }

/********************FOR GETTING POLL DETAILS FROM DATABASE BASED ON CLIENTID STARTS*****************************/
  
function pollDetails($clientid)
  {
     $this->idclient = $clientid;

   
     try{
     $query = "select * from Tbl_C_PollDetails where clientId=:cli";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetchAll();

$response = array();

               if($rows)
                  {
                  $response["success"]=1;
                  $response["message"]="You successfully fetched";
                  $response["posts"]= $rows;
                  return json_encode($response);
                  }
                  else
                  {
                  $response["success"]=0;
                  $response["message"]="data doesn't fetch";
                  return json_encode($response);
                  } 
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }

/********************FOR GETTING POLL DETAILS FROM DATABASE BASED ON POLLID AND CLIENTID ENDS****************************/

/********************ANDROID FOR GETTING POLL DETAILS FROM DATABASE BASED ON CLIENTID STARTS*****************************/
  
function pollDetailsFORandroid($clientid,$val)
  {
     $this->idclient = $clientid;
     $this->value = $val;
   
     try{
     $query = "select * from Tbl_C_PollDetails where clientId=:cli limit ".$this->value.",5";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = array();

               if($rows)
                  {
                  $response["success"]=1;
                  $response["message"]="You successfully fetched";
                  $response["posts"]= $rows;
                  return json_encode($response);
                  }
                  else
                  {
                  $response["success"]=0;
                  $response["message"]="client id or initial value is incorrect";
                  return json_encode($response);
                  } 
     }
     catch(PDOException $e)
     {
                  $response["success"]=0;
                  $response["message"]="client id or initial value is incorrect";
                  return json_encode($response);
     //echo $e;
     }
  }

 /********************FOR GETTING POLL DETAILS FROM DATABASE BASED ON POLLID AND CLIENTID ENDS*****************************/

function getAnswerResult($pollid)
  {
     $this->idpoll = $pollid;
   
     try{
     $query = "select * from Tbl_C_PollOption where pollId=:cli";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cli',$this->idpoll, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows)
            {
               $response["posts"]=array();

foreach($rows as $r)
{
$post["optionId"] = $r["optionId"];
$idoption = $post["optionId"];

             $query1="select count(answerBy) as option_total from Tbl_Analytic_PollResult where pollId=:cli and optionId=:opt";
             $stmt1 = $this->DB->prepare($query1);
             $stmt1->bindParam(':cli',$this->idpoll, PDO::PARAM_STR);
             $stmt1->bindParam(':opt',$idoption, PDO::PARAM_STR);
             $stmt1->execute();
             $row = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$post["TotalAnswerOFoption"] = $row[0]["option_total"];
$post["pollId"] = $r["pollId"];
$post["ansInText"] = $r["ansInText"];
$post["ansInImage"] = $r["ansInImage"];
array_push($response["posts"],$post);
}
             $query1 = "select count(Tbl_Analytic_PollResult.answerBy) as Alltotals from Tbl_Analytic_PollResult where pollId=:cli";
             $stmt1 = $this->DB->prepare($query1);
             $stmt1->bindParam(':cli',$this->idpoll, PDO::PARAM_STR);
             $stmt1->execute();
             $row = $stmt1->fetchAll(PDO::FETCH_ASSOC);
             if($row)
             {
               $response["success"] =1; 
               $response["message"]="successfully display data";
               $response["posts1"]=$row;
               return json_encode($response);
             }
            }
else
{
               $response["success"] =0; 
               $response["message"]="please enter correct pollid";
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