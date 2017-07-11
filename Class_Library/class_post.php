<?php
if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class Post {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 200) {
            $info = getimagesize($source_url);

            if ($info['mime'] == 'image/jpeg')
                $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif')
                $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png')
                $image = imagecreatefrompng($source_url);

            //save it
            imagejpeg($image, $destination_url, $quality);

            //return destination file url
            return $destination_url;
        }
        else {
            move_uploaded_file($source_url, $destination_url);
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

    function maxId() {
        try {
            $max = "select max(auto_id) from Tbl_C_PostDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = "Post-" . $m_id1;

                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }
          // $clientid, $POST_ID, $POST_TITLE, $POST_IMG,$POST_THUMB_IMG, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment, $device
    // note : teaser use only in case of welcome aboard
    
    function create_Post($cid, $pid, $ptitle, $pimg, $thumb_img, $teaser, $pcontent, $pdate, $mail, $by, $flag, $like, $comment, $device) {
        $this->postid = $pid;
        $this->posttitle = $ptitle;
        $this->imgpath = $pimg;
        $this->postcontent = $pcontent;
        $this->author = $by;
        $this->email = $mail;
        $this->flag = $flag;
        $stat = "Publish";
        $this->pdate = $pdate;
        $this->like = $like; 
        $this->comment = $comment;
        $this->client = $cid;
//echo "this is device-".$devcie;
        try {
            $query = "insert into Tbl_C_PostDetails(clientId,post_id,post_title,post_img,thumb_post_img,postTeaser,post_content,created_date,created_by,userUniqueId,flagcheck,likeSetting,comment,status,device)
            values(:cid,:pid,:pt,:pi,:thumb_img,:teaser,:pc,:cd,:cb,:em,:fl,:lk,:ck,:st,:device)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->posttitle, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $this->imgpath, PDO::PARAM_STR);
            $stmt->bindParam(':thumb_img', $thumb_img, PDO::PARAM_STR);
            $stmt->bindParam(':pc', $this->postcontent, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->pdate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->author, PDO::PARAM_STR);
            $stmt->bindParam(':em', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':fl', $this->flag, PDO::PARAM_INT);
            $stmt->bindParam(':lk', $this->like, PDO::PARAM_INT);   
            $stmt->bindParam(':ck', $this->comment, PDO::PARAM_INT);
            $stmt->bindParam(':st', $stat, PDO::PARAM_STR);
              $stmt->bindParam(':teaser',$teaser, PDO::PARAM_STR);
               $stmt->bindParam(':device', $device, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function previewPostid() {
        try {
            $max = "select max(autoId) from postPreview";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = "Post-" . $m_id1;
                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function save_Post($pre, $ptitle, $pcontent, $pimg) {
        $this->posttitle = $ptitle;
        $this->postcontent = $pcontent;
        $this->postimg = $pimg;
        $this->preview = $pre;

        try {
            $query = "insert into postPreview(postId,postTitle,postContent,postImage) values(:pid,:pt,:pi,:ptt)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->preview, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->posttitle, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $this->postcontent, PDO::PARAM_STR);
            $stmt->bindParam(':ptt', $this->postimg, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $idpost;
    public $statuspost;

    function status_Post($com, $coms) {

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 'Publish') {
            $welstatus = 1;
        } else {
            $welstatus = 0;
        }
        try {
            $query = "update Tbl_C_PostDetails set status = :sta where post_id = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->idpost, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);
            $stmt->execute();


            $gquery = "update Tbl_Analytic_PostSentToGroup set status = :sta2 where postId = :comm2 ";
            $stmtg = $this->DB->prepare($gquery);
            $stmtg->bindParam(':comm2', $this->idpost, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $welstatus, PDO::PARAM_STR);
            $stmtg->execute();
			
			$pquery = "update Tbl_C_WelcomePopUp set status = :sta3 where id = :comm3 ";
            $stmtp = $this->DB->prepare($pquery);
            $stmtp->bindParam(':comm3', $this->idpost, PDO::PARAM_STR);
            $stmtp->bindParam(':sta3', $welstatus, PDO::PARAM_STR);
            $stmtp->execute();

            $wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :comm1 ";
            $stmtw = $this->DB->prepare($wquery);
            $stmtw->bindParam(':comm1', $this->idpost, PDO::PARAM_STR);
            $stmtw->bindParam(':sta1', $welstatus, PDO::PARAM_STR);
            $response = array();

            if ($stmtw->execute()) {
                $response["success"] = 1;
                $response["message"] = "Post status has changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function status_memory($com, $coms) {

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 'Publish') {
            $welstatus = 1;
        } else {
            $welstatus = 0;
        }
        try {
            $query = "update Tbl_C_AlumniMemory set status = :sta where memoryId = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->idpost, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Memory status has changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $id_post;

    function delete_Post($com) {

        $this->id_post = $com;

        try {
            $query = "delete from Tbl_C_PostDetails where post_id = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->id_post, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Post has deleted successfully";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $id_posts;

    function onegetpostdetails($postid) {
        $this->id_posts = $postid;

        try {
            $query = "select * , DATE_FORMAT(created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where post_id =:comm";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->id_posts, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = array();

        if ($rows) {
            for ($i = 0; $i < count($rows); $i++) {
                $post["post_title"] = $rows[$i]["post_title"];
                $post["post_img"] = $rows[$i]["post_img"];
                $post["post_content"] = $rows[$i]["post_content"];
                $post["created_date"] = $rows[$i]["created_date"];
                array_push($response["posts"], $post);
            }
            return json_encode($response);
        }
    }

    /*     * ************************ SELECT ONE POST FOR MESSAGE WITH SENDR IMAGE AND NAME ******************* */

    function get1PostDetailsForMessage($postid) {
        $this->id_posts = $postid;

        try {
            $query = "select *, DATE_FORMAT(created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where post_id =:comm";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->id_posts, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = array();

        if ($rows) {
            for ($i = 0; $i < count($rows); $i++) {
                $post["post_title"] = $rows[$i]["post_title"];
                $post["post_img"] = $rows[$i]["post_img"];
                $post["post_content"] = $rows[$i]["post_content"];
                $post["created_date"] = $rows[$i]["created_date"];
                array_push($response["posts"], $post);
            }
            return json_encode($response);
        }
    }

    public $type;
    public $id;

    function createWelcomeData($cid, $id, $type, $ptitle, $pimg, $pdate, $by, $FLAG) {
        $this->client = $cid;
        $this->id = $id;
        $this->type = $type;
        $this->posttitle = $ptitle;
        $this->imgpath = $pimg;
        $this->pdate = $pdate;
        $this->author = $by;
        try {
            $query = "insert into Tbl_C_WelcomeDetails(clientId,id,type,title,image,createdDate,createdBy, flagType)
            values(:cid,:id,:type,:title,:img,:cd,:cb,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->posttitle, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->imgpath, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->pdate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->author, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $FLAG, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

/************************ update post *****************************/	
function updatePost($cid,$pid,$title,$content, $POST_IMG, $post_date, $USERID , $leadername='')
{
	
if($leadername=='')
	{
		$teaser='';
	}
	else{
		$teaser = $leadername;
	}
	
 $this->client = $cid;
 $this->id = $pid;
 $this->title = $title;
 $this->img = $POST_IMG;
 $this->pdate = $post_date;
		try
		{
                 $qu1 = "update Tbl_C_WelcomeDetails set title=:ptitle,image=:pimg, updatedDate =:cd,updatedBy=:by where id =:pid and clientId =:cid";
                 $stmt1 = $this->DB->prepare($qu1);
                 $stmt1->bindParam(':cid',$this->client, PDO::PARAM_STR);
                 $stmt1->bindParam(':pid',$this->id, PDO::PARAM_STR);
                 $stmt1->bindParam(':ptitle',$this->title, PDO::PARAM_STR);
                 $stmt1->bindParam(':pimg',$this->img, PDO::PARAM_STR);
                 $stmt1->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
                 $stmt1->bindParam(':by',$USERID, PDO::PARAM_STR);  
                 $stmt1->execute();        
                  /*********************************************/             
		         $qu = "update Tbl_C_PostDetails set post_title=:ptitle,post_content=:content,post_img =:pimg, updatedDate =:cd,updatedBy=:by,postTeaser=:teaser where post_id =:pid and clientId =:cid";
                 $stmt = $this->DB->prepare($qu);
                 $stmt->bindParam(':cid',$this->client, PDO::PARAM_STR);
                 $stmt->bindParam(':pid',$this->id, PDO::PARAM_STR);
                 $stmt->bindParam(':ptitle',$this->title, PDO::PARAM_STR);
                 $stmt->bindParam(':pimg',$this->img, PDO::PARAM_STR);
                 $stmt->bindParam(':content',$content, PDO::PARAM_STR);
                 $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
                 $stmt->bindParam(':by',$USERID, PDO::PARAM_STR);
				  $stmt->bindParam(':teaser',$teaser, PDO::PARAM_STR);
                if($stmt->execute())
                {   
                $response['success'] = 1;
                $response['msg'] = 'Post Updated Successfully';  
                }
                else 
				{
				$response['success'] = 0;
                $response['msg'] = 'Post not Updated';
				}   
		}
		catch(PDOException $ex)
		{
		 echo $ex;
                 $response['success'] = 0;
                $response['msg'] = 'there is some error please contact info@benepik.com'.$ex;
		}
      return($response);
}	
/********************** end update post ***************************/

}

?>