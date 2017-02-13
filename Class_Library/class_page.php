<?php
session_start();
include_once('class_connect_db_Communication.php');

class Page
{

  public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
  
  }
  
 function maxId()
  {
      try{
			$max = "select max(autoId) from Tbl_C_HRPolicies";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$postid = "Page-".$m_id1;
				 
				 return $postid;
				 }
				
				}
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
				}
		
      
  }

public $id;
public $title;
public $pagename;
public $created_by;
public $pdate;
public $img;
public $clint;
function addPage($maxid,$client,$title,$img,$pagename,$createdby,$post_date,$ptime,$utime)
{

 $this->id = $maxid;
 $this->title = $title;
 $this->pagename = $pagename;
 $this->created_by = $createdby;
 $this->pdate = $post_date;
 $this->img = $img;
 $this->client = $client;
  $status = "Show";
 $this->ptym = $ptime;
 $this->uptym = $utime;

		//echo $postid;
		try
		{
		 $qu = "insert into Tbl_C_HRPolicies(clientId,pageId,pageTitle,imageName,fileName,createdBy,createdDate,status,publishingTime,unpublishingTime)
                values(:cid,:pid,:ptitle,:pimg,:fname,:cb,:cd,:st,:pt,:upt)";
                $stmt = $this->DB->prepare($qu);
                $stmt->bindParam(':cid',$this->client, PDO::PARAM_STR);
                $stmt->bindParam(':pid',$this->id, PDO::PARAM_STR);
                $stmt->bindParam(':ptitle',$this->title, PDO::PARAM_STR);
                 $stmt->bindParam(':pimg',$this->img, PDO::PARAM_STR);
                $stmt->bindParam(':fname',$this->pagename, PDO::PARAM_STR);
                $stmt->bindParam(':cb',$this->created_by, PDO::PARAM_STR);
                $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
                $stmt->bindParam(':st',$status, PDO::PARAM_STR);
                $stmt->bindParam(':pt',$this->ptym, PDO::PARAM_STR);
                $stmt->bindParam(':upt',$this->uptym, PDO::PARAM_STR);
              
                if($stmt->execute())
                {
                $response['success'] = 1;
                $response['msg'] = 'Page Successfully Createdd';
                 return($response);
                           }
                
		}
		catch(PDOException $ex)
		{
		 echo $ex;
		}
      
       }

function updatePage($cid,$pid,$title,$post_date)
{
 $this->id = $pid;
 $this->title = $title;
 $this->pdate = $post_date;
 //$this->img = $img_name;
 $this->client = $cid;
		try
		{
		
		 $qu = "update Tbl_C_HRPolicies set pageTitle=:ptitle,createdDate =:cd where pageId =:pid and clientId = :cid";
                 $stmt = $this->DB->prepare($qu);
                 $stmt->bindParam(':cid',$this->client, PDO::PARAM_STR);
                  $stmt->bindParam(':pid',$this->id, PDO::PARAM_STR);
                 $stmt->bindParam(':ptitle',$this->title, PDO::PARAM_STR);
                // $stmt->bindParam(':pimg',$this->img, PDO::PARAM_STR);
                 $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
                 
                if($stmt->execute())
                {
                $response['success'] = 1;
                $response['msg'] = 'Page updated Successfully';
                 return($response);
                           }
                
		}
		catch(PDOException $ex)
		{
		 echo $ex;
		}
      
       }
	  
}
 	   
    
      /**********************************file csv start ***********************************/  
 
?>