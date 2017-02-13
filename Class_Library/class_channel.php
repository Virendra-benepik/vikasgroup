<?php
include_once('class_connect_db.php');
class Channel
{
  public $DB;
  public function __construct()
  {
    $db = new Connection_Client();
      $this->DB = $db->getConnection_Client();
  }
  
  function getallusers($char)
  {
      try{
     $query = "select * from UserDetails";
            $stmt = $this->DB->prepare($query);
            $stmt->execute();
            $row = $stmt->fetchAll();
            if($row)
             {
                  $response = array();
                  foreach($row as $r)
                  {
                    $post["userid"] = $r["userId"];
                    $post["firstName"] = $r["firstName"];
                    $post["middleName"] = $r["middleName"];
                    $post["lastName"] = $r["lastName"];

                    array_push($response,$post);
                  }
                  return $_GET['mm'].'('.json_encode($response).')';
             } 
                  
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }
  
  
  public $users;
  public $channeltitle;
  public $channelcontent;
  public $channel_created_by;
  public $channel_created_date;
  public $group_type;
  public $idauthor;

  function create_Channel($id_author,$user,$ctitle,$ccontent,$ct,$createdby,$createddate)
  {
     $this->idauthor = $id_author;
     $this->users = $user;
     $this->channeltitle = $ctitle;
     $this->channelcontent = $ccontent;
     $this->channel_created_by = $createdby;
     $this->channel_created_date = $createddate;

  $this->group_type = $ct;
  echo $this->group_type;
 
      try{
			$max = "select max(auto_id) from ChannelDetails";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$channelid = "Group".$m_id1;
                              //  $channel = "Channel".$m_id1."User"; 
				
				}
				
			}
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
			
		     
     try{
     $query = "insert into ChannelDetails(channelid,channelTitle,createdBy,description,createdDate,client_id)
            values(:cid,:ct,:cb,:cc,:cd,:clid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$channelid, PDO::PARAM_STR);
            $stmt->bindParam(':ct',$this->channeltitle, PDO::PARAM_STR);
            $stmt->bindParam(':cb',$this->channel_created_by, PDO::PARAM_STR);
            $stmt->bindParam(':cc',$this->channelcontent, PDO::PARAM_STR);
            $stmt->bindParam(':cd',$this->channel_created_date, PDO::PARAM_STR);
            $stmt->bindParam(':clid',$this->idauthor, PDO::PARAM_STR);

        if($stmt->execute())
        {	
      			try
       			 {         
                        $query = "create table IF NOT EXISTS $channelid(
                        autoId int(13) AUTO_INCREMENT primary key Not Null, 
                        groupId varchar(200) Not Null,
                        userId varchar(200), 
                        role varchar(200), 
                        createdDate varchar(200)
                        )ENGINE=InnoDB";
			$stmt = $this->DB->prepare($query);
			$result= $stmt->execute();
			
		
			}
			catch(PDOException $e)
			{ echo $e;
				//trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			} 
	}
            
                  
     }
     catch(PDOException $e)
     {
     echo $e;
     }
     
     /*if($this->group_type == 'Selected')
     {*/
     
    
 try{
			$max = "select max(autoId) from $channelid";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr1  = $stmt->fetch();
				$mid = $tr[0];
				$mid1 = $mid+1;
				$subchannelid = "SG-".$mid1;
				
			}
			}
			
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
			
			
		try{   
                      

            date_default_timezone_set('Asia/Calcutta');
            $dat = date('d M Y, h:i A');

	    $dummy = "Admin";	
            $query = "insert into $channelid(groupId,userId,role,createdDate) values(:cid,:ct,:cc,:dc)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$subchannelid, PDO::PARAM_STR);
            $stmt->bindParam(':ct',$this->channel_created_by, PDO::PARAM_STR);
            $stmt->bindParam(':cc', $dummy , PDO::PARAM_STR);
            $stmt->bindParam(':dc', $dat , PDO::PARAM_STR);

                 if($stmt->execute())
                 {
                   $rol = "User";
                   $users = rtrim($this->users,",");
                   $string = explode(",",$users);
                   
                   for($i=0;$i< count($string);$i++)
                   {
                   
                   $max = "select max(autoId) from $channelid";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr1  = $stmt->fetch();
				$mid = $tr[0];
				$mid1 = $mid+1;
				$subchannelid = "SG-".$mid1;
				
			}
                   
                   
                     $query = "insert into $channelid(groupId,userId,role,createdDate) values(:cid,:ct,:cc,:dc)";
                     $stmt = $this->DB->prepare($query);
                     $stmt->bindParam(':cid',$subchannelid, PDO::PARAM_STR);
                     $stmt->bindParam(':ct',$string[$i], PDO::PARAM_STR);
                     $stmt->bindParam(':cc', $rol , PDO::PARAM_STR);
                     $stmt->bindParam(':dc', $dat , PDO::PARAM_STR);
                     $stmt->execute();
                    }
                    $value = true;
                    return $value;
                 }
		    }

			catch(PDOException $e)
			{ echo $e;
				//trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
				
			
		
	// }
     
  }

  //public $clientid;
  function Channel_Display($cid)
  {  
     $this->clientid = $cid;

     try{
     $query = "select * from ChannelDetails where client_id =:clid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':clid',$this->clientid, PDO::PARAM_STR);
            $stmt->execute();      
        }
     catch(PDOException $e)
        {
         echo $e;
        }

            $rows = $stmt->fetchAll();

            if($rows)
            {
              $response = array();
              /*$response["success"] = 1;
              $response["message"] = "successfully group displaying"; */

             foreach($rows as $row)
             { 
               $post["channelid"] = $row["channelid"];
               $post["channelTitle"] = $row["channelTitle"];
               $post["description"] = $row["description"];
               $post["createdBy"] = $row["createdBy"];
               $post["createdDate"] = $row["createdDate"];

               array_push($response,$post);
             }
              return json_encode($response);
   
            }
       else
            {
              $response = array();
              $response["success"] = 0;
              $response["message"] = "No group"; 
              return json_encode($response);
            }
  }
  
  public $tabname;
  function Channel_Users($cid)
  {  

     $this->tabname = $cid;
     $tab = $this->tabname;

     try{
     $query = "select * from $tab";
            $stmt = $this->DB->prepare($query);
            $stmt->execute();      
        }
     catch(PDOException $e)
        {
         echo $e;
        }

            $rows = $stmt->fetchAll();

            if($rows)
            {
              $response = array();
              /*$response["success"] = 1;
              $response["message"] = "successfully group displaying";*/ 

             foreach($rows as $row)
             { 
               $post["userId"] = $row["userId"];
               $post["role"] = $row["role"];
               $post["createdDate"] = $row["createdDate"];

               array_push($response,$post);
             }
              return json_encode($response);
   
            }
       else
            {
              $response = array();
              $response["success"] = 0;
              $response["message"] = "No group"; 
              return json_encode($response);
            }
  }

  public $channel_id;
  public $user_id;
  public $like;
  public $comment;
  public $push;
  public $email;

  function Channel_Setting($cid,$uid,$lik,$com,$pus,$mail)
  {
     $this->channel_id = $cid;
     $this->user_id = $uid;
     $this->like = $lik;
     $this->comment = $com;
     $this->push = $pus;
     $this->email = $mail;
		     
     try{
     $query = "insert into ChannelDetails(channelid,channelTitle,description,createdBy,createdDate)
            values(:cid,:uid,:lik,:com,:pus,:mail)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$this->channel_id, PDO::PARAM_STR);
            $stmt->bindParam(':uid',$this->user_id, PDO::PARAM_STR);
            $stmt->bindParam(':lik',$this->like, PDO::PARAM_STR);
            $stmt->bindParam(':com',$this->comment, PDO::PARAM_STR);
            $stmt->bindParam(':pus',$this->push, PDO::PARAM_STR);
			$stmt->bindParam(':mail',$this->email, PDO::PARAM_STR);
            $stmt->execute();
                  
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }
}
?>