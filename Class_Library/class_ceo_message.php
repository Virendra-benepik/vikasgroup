<?php
/* DB connection changed
	include_once('class_connect_db.php');
*/
include_once('class_connect_db_Communication.php');

class Post
{
    
    public $DB;
  public function __construct()
  {
/* DB connection changed  
      $db = new Connection_Client();
      $this->DB = $db->getConnection_Client();
*/
	$db = new Connection_Communication();
       $this->DB = $db->getConnection_Communication();
  }

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

  public $postid;
  public $posttitle;
  public $postcontent;
  public $imgpath;
  public $pdate;
  public $author;
  public $by;
  public $flag;
  public $email;
  public $teaser;
  public $like;
  public $comment;
  public $client;

  function maxId()
  {
      try{
			$max = "select max(auto_id) from Tbl_C_PostDetails";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$postid = "Post-".$m_id1;
				 
				 return $postid;
				 }
				
				}
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
		        }
		
      
  }

               //  $clientid, $POST_ID, $POST_TITLE, $POST_IMG, $POST_IMG_THUMB, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment
  function create_Post($cid,$pid,$ptitle,$pimg,$POST_IMG_THUMB,$pcontent,$pdate,$mail,$by,$flag,$like,$comment)
  {
     $this->postid = $pid;
     $this->posttitle = $ptitle;
     $this->imgpath = $pimg;
     $this->postcontent = $pcontent;
      $this->teaser = $pteaser;
     $this->author = $by;
     $this->email = $mail;
     $this->flag = $flag;
     $stat = "Publish";
     $this->pdate = $pdate;
     $this->like = $like;
     $this->comment = $comment;
     $this->client = $cid;
    
     try{
     $query = "insert into Tbl_C_PostDetails(clientId,post_id,post_title,post_img,thumb_post_img,post_content,created_date,created_by,userUniqueId,flagcheck,likeSetting,comment,status)
                                      values(:cid,:pid,:pt,:pi,:thumbimg,:pc,:cd,:cb,:em,:fl,:lk,:ck,:st)";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cid',$this->client, PDO::PARAM_STR);
              $stmt->bindParam(':pid',$this->postid, PDO::PARAM_STR);
             $stmt->bindParam(':pt',$this->posttitle, PDO::PARAM_STR);
             $stmt->bindParam(':pi',$this->imgpath, PDO::PARAM_STR);
             $stmt->bindParam(':thumbimg',$POST_IMG_THUMB, PDO::PARAM_STR);
             
             $stmt->bindParam(':pc',$this->postcontent, PDO::PARAM_STR);
             $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
             $stmt->bindParam(':cb',$this->author, PDO::PARAM_STR);
                 $stmt->bindParam(':em',$this->email, PDO::PARAM_STR);
                  $stmt->bindParam(':fl',$this->flag, PDO::PARAM_INT);
                    $stmt->bindParam(':lk',$this->like, PDO::PARAM_INT);
                     $stmt->bindParam(':ck',$this->comment, PDO::PARAM_INT);
           $stmt->bindParam(':st',$stat, PDO::PARAM_STR);
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
  
 function previewPostid()
 {
                         try{
			$max = "select max(autoId) from postPreview";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			     {
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$postid = "Post-".$m_id1;
				return $postid;
		              }
				
			}
		
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
		        }
 }  
  function save_Post($pre,$ptitle,$pcontent,$pimg)
  {
     $this->posttitle = $ptitle;
     $this->postcontent = $pcontent;
     $this->postimg = $pimg;
     $this->preview = $pre;
    
     try{
     $query = "insert into postPreview(postId,postTitle,postContent,postImage) values(:pid,:pt,:pi,:ptt)";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':pid',$this->preview, PDO::PARAM_STR);
             $stmt->bindParam(':pt',$this->posttitle, PDO::PARAM_STR);
             $stmt->bindParam(':pi',$this->postcontent, PDO::PARAM_STR);
             $stmt->bindParam(':ptt',$this->postimg, PDO::PARAM_STR);
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
  
public $idpost;
public $statuspost;

function status_Post($com,$coms)
 {

$this->idpost = $com;
$this->statuspost = $coms;

$status = "";
     try{
     $query = "update Tbl_C_PostDetails set status = :sta where post_id = :comm ";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':comm',$this->idpost, PDO::PARAM_STR);
             $stmt->bindParam(':sta',$this->statuspost, PDO::PARAM_STR);
             $response = array();

                  if($stmt->execute())
                  {
                     $response["success"] = 1;
                     $response["message"] = "Post status has changed";
                     return json_encode($response);
                  }
         }
     catch(PDOException $e)
     {
     echo $e;
     } 
 }
public $id_post;

function delete_Post($com)
 {

$this->id_post = $com;

     try{
     $query = "delete from Tbl_C_PostDetails where post_id = :comm ";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':comm',$this->id_post, PDO::PARAM_STR);
             $response = array();

                  if($stmt->execute())
                  {
                     $response["success"] = 1;
                     $response["message"] = "Post has deleted successfully";
                     return json_encode($response);
                  }
         }
     catch(PDOException $e)
     {
     echo $e;
     } 
 } 

  public $id_posts;

  function onegetpostdetails($postid)
  {
     $this->id_posts = $postid;

      try
	  {
	     $query = "select * , DATE_FORMAT(created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where post_id =:comm";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':comm',$this->id_posts, PDO::PARAM_STR);
	     $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll();
          $response["success"]= 1;
          $response["message"]= "Displaying post details";
          $response["posts"]= array();	  
      
	  if($rows)
          {
             for($i=0;$i<count($rows);$i++)
             {
             $post["post_title"]= $rows[$i]["post_title"];
             $post["post_img"]= $rows[$i]["post_img"];
             $post["post_content"]= $rows[$i]["post_content"];
             $post["created_date"]= $rows[$i]["created_date"];
             array_push($response["posts"],$post);
             }
			 return json_encode($response);
          }
		  
  } 
  
  /************************** SELECT ONE POST FOR MESSAGE WITH SENDR IMAGE AND NAME ********************/
  
  function get1PostDetailsForMessage($postid)
  {
     $this->id_posts = $postid;

      try
	  {
	     $query = "select *, DATE_FORMAT(created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where post_id =:comm";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':comm',$this->id_posts, PDO::PARAM_STR);
	     $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll();
          $response["success"]= 1;
          $response["message"]= "Displaying post details";
          $response["posts"]= array();	  
      
	  if($rows)
          {
             for($i=0;$i<count($rows);$i++)
             {
             $post["post_title"]= $rows[$i]["post_title"];
             $post["post_img"]= $rows[$i]["post_img"];
             $post["post_content"]= $rows[$i]["post_content"];
             $post["created_date"]= $rows[$i]["created_date"];
             array_push($response["posts"],$post);
             }
			 return json_encode($response);
          }
		  
  } 
  public $type;
  public $id;
  function createWelcomeData($cid,$id,$type,$ptitle,$pimg,$pdate,$by,$flag)
  {
     $this->client = $cid;
     $this->id = $id;
     $this->type = $type;
     $this->posttitle = $ptitle;
     $this->imgpath = $pimg;
     $this->pdate = $pdate; 
      $this->author = $by;  
     try{
     $query = "insert into Tbl_C_WelcomeDetails(clientId,id,type,title,image,createdDate,createdBy,flagType)
            values(:cid,:id,:type,:title,:img,:cd,:cb,:flagtype)";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cid',$this->client, PDO::PARAM_STR);
              $stmt->bindParam(':id',$this->id, PDO::PARAM_STR);
             $stmt->bindParam(':type',$this->type, PDO::PARAM_STR);
             $stmt->bindParam(':title',$this->posttitle, PDO::PARAM_STR);
             $stmt->bindParam(':img',$this->imgpath, PDO::PARAM_STR);
             $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
             $stmt->bindParam(':cb',$this->author, PDO::PARAM_STR);     
             $stmt->bindParam(':flagtype',$flag, PDO::PARAM_STR);     
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

}
?>