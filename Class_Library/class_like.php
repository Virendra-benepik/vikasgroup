<?php
include_once('class_connect_db.php');

class Like
{
    
  public $DB;
  public function __construct()
  {
    $db = new Connection_Client();
    $this->DB = $db->getConnection_Client();
  }

  public $postid;  
  public $likeby;

  function create_Like($pid,$likby)
  {
     $this->postid = $pid;
     $this->likeby = $likby;
          
     date_default_timezone_set('Asia/Calcutta');

      $cd = date('d M Y, h:i A');    


     try{
              $query = "select *from PostLike where postId = :pi and likeBy = :ei";
              $stmt = $this->DB->prepare($query);
              $stmt->bindParam(':pi',$this->postid, PDO::PARAM_STR);
              $stmt->bindParam(':ei',$this->likeby, PDO::PARAM_STR);
              $stmt->execute();
              $rows = $stmt->fetchAll();

              if($rows)
              { $val ="no you cant insert"; return $val;}
              else
              { 
             $query = "insert into PostLike(postId,likeBy,likeDate)
             values(:pt,:li,:cd)";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':pt',$this->postid, PDO::PARAM_STR);
             $stmt->bindParam(':li',$this->likeby, PDO::PARAM_STR);
             $stmt->bindParam(':cd',$cd, PDO::PARAM_STR);
             if($stmt->execute())
             {$val = "Data inserted"; return $val; }
             else
             {$val = "Data not inserted"; return $val; }
              }
     }
     catch(PDOException $e)
     {
     echo $e;
     }         
}
  
 public $post_id;
 
 function getlike($postid)
  {
      $this->post_id = $postid;

	  try
	  { 
 	     $query = "select count(postId) as count from PostLike where postId = :pi";
             $stmt = $this->DB->prepare($query); 
             $stmt->bindParam(':pi',$this->post_id, PDO::PARAM_STR);

             $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetch();
          
          //return json_encode($rows);
         if($rows)
         { 
              $rows["success"] = 1;
              $rows["message"] = "like success";
              echo json_encode($rows);
         }
         else
         {    
               $response["success"] = 0;
               $response["message"] = "no display like";
               echo json_encode($response);
         }		  
    }
	
 public $post_ids; 
 function getlike1($postid)
  {
      $this->post_ids = $postid;

	  try
	  { 
 	     $query = "select count(postId) as count from PostLike where postId = :pi";
             $stmt = $this->DB->prepare($query); 
             $stmt->bindParam(':pi',$this->post_ids, PDO::PARAM_STR);

             $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetch();
          
         /*if($rows)
         { 
              $rows["success"] = 1;
              $rows["message"] = "like success";
              echo json_encode($rows);
         }
         else
         {    
               $response["success"] = 0;
               $response["message"] = "no display like";
               echo json_encode($response);
         }*/
		 
	  try
	  { 
 	     $query1 = "select count(commentId) as count from PostComment where postId = :pi";
             $stmt1 = $this->DB->prepare($query1); 
             $stmt1->bindParam(':pi',$this->post_ids, PDO::PARAM_STR);

             $stmt1->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $row = $stmt1->fetch();

          $responses = array();

         if($row)
         { 
           
              $posts["result"]=array();
              $posts["success"] = 1;
              $posts["message"] = "total successfull";
              
              $response["total_likes"] = $rows["count"];
              $response["total_comments"] = $row["count"];

              array_push($posts["result"],$response);
              echo json_encode($posts);
         }
         else
         {    
               $response["success"] = 0;
               $response["message"] = "no display like";
               echo json_encode($response);
         }			 
    }
}
?>