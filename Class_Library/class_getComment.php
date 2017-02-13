<?php
include_once('class_connect_db_Communication.php');

class GetComment
{
    
    public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();  
  }

  public $postid;
 public $cid;
  function getAllComment($cid)
  {
  $this->cid = $cid;
      $query = "select pc.*, DATE_FORMAT(pc.commentDate,'%d %b %Y %h:%i %p') as commentDate, pd.post_title,pd.post_content from Tbl_Analytic_PostComment as pc join Tbl_C_PostDetails as pd on pd.post_id = pc.postId where pd.clientid =:cid order by pc.autoId desc";
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

public $commentid;
function delete_Comment($com)
 {
$this->commentid = $com;
     try{
     $query = "delete from Tbl_Analytic_PostComment where commentId = :comm ";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':comm',$this->commentid, PDO::PARAM_STR);

              $response = array();

                  if($stmt->execute())
                  {
                     $val = True;
                     return $val;
                  }
     }
     catch(PDOException $e)
     {
     echo $e;
     } 
 }

public $comentid;
public $comentstatus;

function status_Comment($com,$coms)
 {

$this->comentid = $com;
$this->comentstatus = $coms;

$status = "";
     try{
     $query = "update Tbl_Analytic_PostComment set status = :sta where commentId = :comm ";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':comm',$this->comentid, PDO::PARAM_STR);
             $stmt->bindParam(':sta',$this->comentstatus, PDO::PARAM_STR);

              $response = array();

                  if($stmt->execute())
                  {
                     $response["success"] = 1;
                     $response["message"] = "Comment status has changed";
                     return json_encode($response);
                  }
     }
     catch(PDOException $e)
     {
     echo $e;
     } 
 }

/* this is unuse

  function getSinglePost($pid)
  {
     $this->postid = $pid;
    
     try{
     $query = "Select * from Tbl_C_PostDetails where post_id =:pid";
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
	  $query = "select * from Tbl_C_PostDetails order by created_date desc limit 0,3";
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