<?php
//include_once('class_connect_db_mahle.php');
if(  !class_exists('Connection_Communication') ) {
    include_once('class_connect_db_Communication.php');
}
class Post
{
    
  public $connect;
 
  public function __construct()
  {
      $db = new Connection_Communication();
      $this->connect = $db->getConnection_Communication();
    
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

  function maxId()
  {
      try{
			$max = "select max(auto_id) from Tbl_C_PostDetails";
			$stmt = $this->connect->prepare($max);
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
/******************************************************************************/
 function randomNumber($length)
  {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
  }
  
  /*****************************************************************************/
  
  public $img;
  function convertintoimage($encodedimage,$num)
  {
  $this->img = $encodedimage;
   $this->number = $num;
  $img = imagecreatefromstring(base64_decode($this->img));
  
  $imgpath = '../../images/post_img/'.$this->postid."-".$this->number.'.jpg';
  imagejpeg( $img , $imgpath ); //for converting jpeg of image
    
    $imgpath1 = 'images/post_img/'.$this->postid."-".$this->number.'.jpg';
   return $imgpath1;
  }
 
 /*****************************************************************************/
public $clientid;
public $useruniqueid;
//$clientid, $POST_ID, $POST_TITLE, $imgname,$POST_IMG_THUMB, $POST_TEASER, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $comment, $like,$device
  function create_Post($clid,$pid,$ptitle,$pimg,$POST_IMG_THUMB,$pteaser,$pcontent,$pdate,$uid,$by,$flag,$commen,$lik,$device)
  {
    $this->clientid = $clid;
     $this->postid = $pid;
   
     $this->posttitle = $ptitle;
     $this->imgpath = $pimg;
     $this->postcontent = $pcontent;
      $this->teaser = $pteaser;
     $this->author = $by;
     $this->useruniqueid = $uid;
     $this->flag = $flag;
     $stat = "Publish";
     $this->pdate = $pdate;
     $this->comment = $commen;
     $this->like = $lik;

     try{
     $query = "insert into Tbl_C_PostDetails(clientId,post_id,post_title,post_img,thumb_post_img,postTeaser,post_content,created_date,
                                 created_by,userUniqueId,flagcheck,likeSetting,comment,status,device)
            values(:cid,:pid,:pt,:pi,:pthi,:ptt,:pc,:cd,:cb,:uuid,:fl,:lik,:comm,:st,:device)";
             $stmt = $this->connect->prepare($query);
             $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
              $stmt->bindParam(':pid',$this->postid, PDO::PARAM_STR);
             $stmt->bindParam(':pt',$this->posttitle, PDO::PARAM_STR);
             $stmt->bindParam(':pi',$this->imgpath, PDO::PARAM_STR);
              $stmt->bindParam(':pthi',$POST_IMG_THUMB, PDO::PARAM_STR);
             $stmt->bindParam(':ptt',$this->teaser, PDO::PARAM_STR);
             $stmt->bindParam(':pc',$this->postcontent, PDO::PARAM_STR);
             $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
             $stmt->bindParam(':cb',$this->author, PDO::PARAM_STR);
             $stmt->bindParam(':uuid',$this->useruniqueid, PDO::PARAM_STR);
             $stmt->bindParam(':fl',$this->flag, PDO::PARAM_INT);
             $stmt->bindParam(':lik',$this->like, PDO::PARAM_STR);
             $stmt->bindParam(':comm',$this->comment, PDO::PARAM_STR);
             $stmt->bindParam(':st',$stat, PDO::PARAM_STR);      
              $stmt->bindParam(':device',$device, PDO::PARAM_STR);      
             if($stmt->execute())
                  {
                  return  $imgpath1;
                  }
     }
     catch(PDOException $e)
     {
     echo $e;
     }
}
  
  /**********************************************this is use less function not in use current time************************************************/
   function save_Post($pid,$ptitle,$pimg,$pteaser,$pcontent,$pdate,$mail,$by,$flag)
  {
     $this->postid = $pid;
     $this->posttitle = $ptitle;
     $this->imgpath = $pimg;
     $this->postcontent = $pcontent;
      $this->teaser = $pteaser;
     $this->author = $by;
     $this->email = $mail;
     $this->flag = $flag;
     $stat = "SaveInDraft";
     $this->pdate = $pdate;
    
     try{
     $query = "insert into Tbl_C_PostDetails(post_id,post_title,post_img,postTeaser,post_content,created_date,created_by,emailId,flagcheck,status)
            values(:pid,:pt,:pi,:ptt,:pc,:cd,:cb,:em,:fl,:st)";
             $stmt = $this->connect->prepare($query);
             $stmt->bindParam(':pid',$this->postid, PDO::PARAM_STR);
             $stmt->bindParam(':pt',$this->posttitle, PDO::PARAM_STR);
             $stmt->bindParam(':pi',$this->imgpath, PDO::PARAM_STR);
             $stmt->bindParam(':ptt',$this->teaser, PDO::PARAM_STR);
             $stmt->bindParam(':pc',$this->postcontent, PDO::PARAM_STR);
             $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
             $stmt->bindParam(':cb',$this->author, PDO::PARAM_STR);
             $stmt->bindParam(':em',$this->email, PDO::PARAM_STR);
             $stmt->bindParam(':fl',$this->flag, PDO::PARAM_INT);
           
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
  /****************************************************************/
 function getImage($mail)
 { 
  $this->emailid = $mail;
       try
	  {
             $query ="SELECT userImage FROM Tbl_EmployeePersonalDetails WHERE emailId = :emlid";
             $stmt = $this->connect->prepare($query);
             $stmt->bindParam(':emlid',$this->emailid, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
             if($rows)
              {
                   return $rows;
              }
          }

     catch(PDOException $e)
     {
     echo $e;
     }
 }  
}
?>