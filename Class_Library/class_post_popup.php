<?php
include_once('class_connect_db_Communication.php');
class PostPopup{

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 40) {
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
            $max = "select max(popupId) from Tbl_C_WelcomePopUp";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1; 
                return $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function create_PopupPost($clientid,$POST_IMG,$POST_CONTENT,$DATE,$USERID) 
	{
       
        try {
            $query = "insert into Tbl_C_WelcomePopUp(clientId,imagename,imageCaption,createdDate,createdBy)
                                              values(:cid,:imgpath,:imgcaption,:cd,:cb)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);         
            $stmt->bindParam(':imgpath', $POST_IMG, PDO::PARAM_STR);
            $stmt->bindParam(':imgcaption', $POST_CONTENT, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $DATE, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $USERID, PDO::PARAM_STR);          
            if ($stmt->execute()) 
			{
                $response['status'] = 1;
				$response['msg'] = 'data added';
            }
        } catch (PDOException $e) {
           $response['status'] = 0;
				$response['msg'] = 'data not added';
        }
		return json_encode($response);
    }

    public $idpost;
    public $statuspost;

    function status_Post($com, $coms) 
	{

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 1) {
            $welstatus = 1;
        } else {
            $welstatus = 0;
        }
        try {
            $query = "update Tbl_C_WelcomePopUp set status = :sta where popupId = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->idpost, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "PopUp status has changed";
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
/******************** check for use , find APIs where this function use , currently useless*******************/
    function getAllPopimage($clientid,$user_uniqueid) 
	{
        //$this->id_posts = $user_uniqueid;
     $site_url = dirname(SITE_URL)."/";
        try {
            $query = "select * , DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate,Concat('".$site_url."',imageName) as imageName from Tbl_C_WelcomePopUp where  clientId =:cli" ;
            $stmt = $this->DB->prepare($query);
           // $stmt->bindParam(':comm', $this->id_posts, PDO::PARAM_STR);
			$stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//print_r($res);
			if($res)
			{
          $response["success"] = 1;
          $response["message"] = "Displaying post details";
          $response["posts"] = $res;
		}
        } 
		catch (PDOException $e) 
		{
           
			$response["success"] = 0;
          $response["message"] = "post not found".$e;
        }

		return json_encode($response);
    }

    /*     * ************************ SELECT ONE POST FOR MESSAGE WITH SENDR IMAGE AND NAME ******************* */

   
    public $type;
    public $id;

    function getSinglePopUpData($cid, $id) 
	{
        $this->client = $cid;
       // $this->id = $id;
       $site_url = dirname(SITE_URL)."/";
        try {
			$query = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate,Concat('".$site_url."',imageName) as imageName from Tbl_C_WelcomePopUp where  clientId =:cli and status = 1 order by popupId desc limit 1";
           
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->client, PDO::PARAM_STR);
           // $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
		   $stmt->execute();
		   $val = $stmt->fetchAll(PDO::FETCH_ASSOC);
		   $response = array();
            if ($val) 
			{
				
				$response['status'] = 1;
				$response['message'] = 'data found';
				$response['data'] = $val;  
            }
			else
			{
			$response['status'] = 0;
			$response['message'] = 'data Not found';
			}
			return json_encode($response);
        } catch (PDOException $e) {
			//$response['status'] = 0;
			//$response['message'] = 'data not found'.$e;
			echo $e;
        }
		
    }

/*************************** get all popup ************************************/

 function getAllPopUp($cid) 
	{
        $this->client = $cid;
      
       $site_url = SITE;
        try {
			/*$query = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate,Concat('".$site_url."',imageName) as imageName from Tbl_C_WelcomePopUp where  clientId =:cli order by createdDate desc";*/
			
			$query = "select twp.*, DATE_FORMAT(twp.createdDate,'%d %b %Y %h:%i %p') as createdDate,Concat('".$site_url."',twp.imageName) as imageName, tfm.moduleName from Tbl_C_WelcomePopUp as twp Left join FlagMaster as tfm ON twp.flagType = tfm.flagId where twp.clientId =:cli order by twp.createdDate desc";
           
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->client, PDO::PARAM_STR);
           
		   $stmt->execute();
		   $val = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($val) 
			{
				
				$response['status'] = 1;
				$response['message'] = 'data found';
				$response['Data'] = $val;
                
            }
        } catch (PDOException $e) {
			$response['status'] = 0;
				$response['message'] = 'data not found';
            //echo $e;
        }
		return json_encode($response);
    }

/************************************ end get all popup *************************************/	




}

?>