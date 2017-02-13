 <?php

include_once('class_connect_db_Communication.php');

class Sponsership{

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }
	
	/******************************** compress image ***************************************/

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
	/************************************** end compress image *************************************/

  /*************************************** find max auto id *************************************/

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
	/************************************ end find max auto id ***************************************/
	
	/*********************************************** add event sponsership *****************************************/

    function addEventSponsership($clientid,$maxid,$eventtitle,$eventpostimage,$eventcontent,$createddate,$BY,$uuid,$flag_value,$like,$comment,$status) {
       
        try {
            $query = "insert into Tbl_C_PostDetails(clientId,post_id,post_title,post_img,post_content,created_date,created_by,userUniqueId,flagCheck,likeSetting,comment,status)
            values(:cid,:pid,:title,:pimg,:des,:pdate,:createdby,:uuid,:ft,:like,:comm,:status)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
			$stmt->bindParam(':pid', $maxid, PDO::PARAM_STR);
			$stmt->bindParam(':title', $eventtitle, PDO::PARAM_STR);
			$stmt->bindParam(':pimg', $eventpostimage, PDO::PARAM_STR);
			$stmt->bindParam(':des', $eventcontent, PDO::PARAM_STR);
			$stmt->bindParam(':pdate', $createddate, PDO::PARAM_STR); 
			$stmt->bindParam(':createdby', $BY, PDO::PARAM_STR);
			$stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
			$stmt->bindParam(':ft', $flag_value, PDO::PARAM_INT);
			$stmt->bindParam(':like', $like, PDO::PARAM_STR);
			$stmt->bindParam(':comm', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':status', $status, PDO::PARAM_STR);
			$response = array();
            if($stmt->execute()) {
               // $ft = 'True';
                //return $ft;
				$response["success"] = 1;
                $response["message"] = "Data Inserted";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
/********************************** insert into welcome table ************************************/

    function createWelcomeData($clientid,$maxid,$type,$eventtitle,$eventpostimage,$createddate,$uuid,$flag_value) {
        
        try {
            $query = "insert into Tbl_C_WelcomeDetails(clientId,id,type,title,image,createdDate,createdBy,flagType)
            values(:cid,:id,:type,:title,:img,:cd,:cb,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':id', $maxid, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $eventtitle, PDO::PARAM_STR);
            $stmt->bindParam(':img', $eventpostimage, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $createddate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $uuid, PDO::PARAM_STR);
			 $stmt->bindParam(':flag',$flag_value, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

/************************************** end insert into welcome table ****************************************/

function getAllContributor($clientid) 
	{
     $path = SITE;
        try {
            $query = "select tpd.*,CONCAT(edm.firstName,' ',edm.lastName) as name , DATE_FORMAT(tpd.created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails as tpd JOIN Tbl_EmployeeDetails_Master as edm ON tpd.userUniqueId = edm.employeeId and tpd.clientId = edm.clientId where tpd.clientId =:cli AND tpd.flagCheck = 17 order by tpd.created_date desc";
			
						
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if($res)
			{
          $response["success"] = 1;
          $response["message"] = "Data Found";
          $response["Data"] = $res;
		}
        } 
		catch (PDOException $e) 
		{
           
			$response["success"] = 0;
          $response["message"] = "Data Not Found".$e;
        }

		return json_encode($response);
    }

/**************************************** get all contributor ***************************************************/

/************************* pop up status ***************************************/
    function status_Post($com, $coms) 
	{

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 'Publish') {
            $welstatus = 1;
        } else {
            $welstatus = 0;
        }
        try {
            $query = "update Tbl_C_PostDetails set status = :sta where post_id = :comm";
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
                $response["message"] = "status has changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
/************************* end pop up status ***************************************/


/************************************ get contributor detail ******************************/

function getContributorList($clientid) 
	{
     $path = SITE;
        try {
           
			$query ="SELECT Tbl_C_PostDetails . * ,CONCAT('".$path."',Tbl_C_PostDetails.post_img) as post_img , DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date , (
            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostComment.flagType = 17
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostLike.flagType = 17
            ) as likeCount , (

            SELECT COUNT(distinct userUniqueId) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostView.flagType = 17
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_PostDetails.post_id AND Tbl_Analytic_PostView.flagType = 17
            ) as TotalCount

            FROM Tbl_C_PostDetails where Tbl_C_PostDetails.flagCheck = 17 and Tbl_C_PostDetails.clientId =:cli order by Tbl_C_PostDetails.auto_id desc";
			
			
			
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if($res)
			{
          $response["success"] = 1;
          $response["message"] = "Data Found";
          $response["Data"] = $res;
		}
        } 
		catch (PDOException $e) 
		{
           
			$response["success"] = 0;
          $response["message"] = "Data Not Found".$e;
        }

		return json_encode($response);
    }

/******************************** end get contributor detail *************************************/


/****************************** one post detail *******************************************/

function getonepostdetails($postid) {
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
	
/******************************** end one post detail *******************************************/

/****************************** get contributor query registration **************************************/

 function getcontributorqueriesreport($clientid, $contributorid) {
        $this->clientid = $clientid;
        $this->conid = $contributorid;
		$imagepath = SITE;
        try {
            $query = "select teq.autoId , tpd.post_title,teq.query,DATE_FORMAT(teq.createdDate,'%d %b %Y %h:%i %p') as createdDate, CONCAT(edm.firstName,' ',edm.lastName) as name from Tbl_C_EventQueries as teq JOIN Tbl_C_PostDetails as tpd ON teq.Id = tpd.post_id  and teq.clientId = tpd.clientId JOIN Tbl_EmployeeDetails_Master as edm ON teq.createdBy = edm.employeeId where teq.clientId =:cli and teq.Id =:cid and teq.flagType = 17 order by teq.createdDate desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->conid, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::PARAM_STR);

           if($row)
		   {
            $res["success"] = 1;
			$res["message"] = "show query report";
			$res["Data"] = $row;
		   }
            return json_encode($res);
        }
		catch (PDOException $e) {
            echo $e;
            $res["success"] = 0;
            $res["message"] = "error";
            return json_encode($res);
        }

        
    }

/***************************** end get contributor query registration ***********************************/

/******************************* get single query details ******************************************************/

function getSingleContributorQueryDetails($clientid,$postid,$queryid){
       
		$imagepath = SITE;
        try {
           $query = "select teq.autoId,tpd.post_title,teq.query,DATE_FORMAT(teq.createdDate,'%d %b %Y %h:%i %p') as createdDate, CONCAT(edm.firstName,' ',edm.lastName) as name ,CONCAT('" . $imagepath . "',tpd.post_img) as imageName from Tbl_C_EventQueries as teq JOIN Tbl_C_PostDetails as tpd ON teq.Id = tpd.post_id  and teq.clientId = tpd.clientId JOIN Tbl_EmployeeDetails_Master as edm ON teq.createdBy = edm.employeeId   where teq.clientId =:cli and teq.Id =:pid and teq.autoId = :qid and teq.flagType = 17";
		   
		  // $query = "select * from Tbl_C_EventDetails";
		   
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
			$stmt->bindParam(':qid', $queryid, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::PARAM_STR);

           if($row)
		   {
            $res["success"] = 1;
			$res["message"] = "show query report";
			$res["Data"] = $row;
		   }
            return json_encode($res);
        }
		catch (PDOException $e) {
            echo $e;
            $res["success"] = 0;
            $res["message"] = "error";
            return json_encode($res);
        }

        
    }

/********************************** end get single query details ************************************************/

	
}

?>