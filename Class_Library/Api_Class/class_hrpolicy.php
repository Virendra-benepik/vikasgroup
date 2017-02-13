<?php
error_reporting(E_ALL ^ E_NOTICE);

include_once('class_connect_db_Communication.php');

class GetPages
{
    
    public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
      $this->DB = $db->getConnection_Communication();
  }

/****************************************use less ****************************************************
  function getAllpages($idclient)
  {
  $this->clientid = $idclient ;

	  try
	  {
                 $query = "select * from Tbl_C_HRPolicies where clientId =:cli order by createdDate desc";
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':cli',$this->clientid, PDO::PARAM_STR);
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	 $rows = $stmt->fetchAll();
    	 return json_encode($rows);
		
      
  }
/*********************************************************************************/
  function getAllpagesFORandroid($idclient,$val,$module ="")
  {
	  /****************************************
    $module  = 1
	we consider flag value 1  for display data in web view of application 
	   
	*****/
	  
  $this->clientid = $idclient ;
  $this->value = $val;
  $this->module = $module;
  $status = "Show";
//  $path = "http://".$_SERVER['SERVER_NAME']."/";
  $path = site_url;
	  try
	  {
		  if($this->module == 1)
		  {
			  $query = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_HRPolicies where clientId =:cli and status =:sta  order by autoId asc limit 5";
			  }
			  else
			  {
                 $query = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_HRPolicies where clientId =:cli and status =:sta  order by autoId asc limit ".$this->value.",10";
			  }
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':cli',$this->clientid, PDO::PARAM_STR);
                  $stmt->bindParam(':sta',$status, PDO::PARAM_STR);
		 $stmt->execute();
             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

             $response = array();

               if(count($rows)>0)
                  {

     $query1 = "select count(pageId) as totals from Tbl_C_HRPolicies where clientId=:cli and status =:sta";
             $stmt1 = $this->DB->prepare($query1);
             $stmt1->bindParam(':cli',$this->clientid, PDO::PARAM_STR);
              $stmt1->bindParam(':sta',$status, PDO::PARAM_STR);
             $stmt1->execute();
             $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                  $response["success"]=1;
                  $response["message"]="You successfully fetched";
                  $response["totals"]=$rows1[0]["totals"];
                  $response["posts"]=array();

foreach($rows as $row)
{
$post["pageId"] = $row["pageId"];
$post["pageTitle"] = $row["pageTitle"];
$post["imageName"] = $path.$row["imageName"];
$post["fileName"] = $path.$row["fileName"];
$post["createdBy"] = $row["createdBy"];
$post["createdDate"] = $row["createdDate"];
array_push($response["posts"],$post);
}
                  }
                  else
                  {
                  $response["success"]=0;
                  $response["message"]="No HR Policy Available";
                  }
return $response;
	  }
         
         catch(PDOException $e)
         {
                  $response["success"]=0;
                  $response["message"]="client id or initial value is incorrect";
                  return json_encode($response);
         //echo $e;
         }
       
      
  }

/***************************************************************************  
  public $id;
  function getSinglePage($k)
  {
  $this->id = $k;
      $query = "select * from Tbl_C_HRPolicies where pageId =:pid";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':pid',$this->id, PDO::PARAM_STR);
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll();
    	 return json_encode($rows);
		
      
  }
******************************************************************************
  function updatePageStatus($pid,$sta)
  {
  $this->pageid = $pid;
  $this->status = $sta;

      $query = "update Tbl_C_HRPolicies set status=:sta where pageId =:pid";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':pid',$this->pageid, PDO::PARAM_STR);
                 $stmt->bindParam(':sta',$this->status, PDO::PARAM_STR);
		 if($stmt->execute())
                 {
                    $response[success] =1;
                    $response[message] ="Successfully page status changed";
                    return json_encode($response); 
                 }
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
  }
  
  *********************************************************************/
}
?>