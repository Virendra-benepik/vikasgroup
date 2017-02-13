<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class AchiverStory {

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

    function maxId() {
        try {
            $max = "select max(storyId) from Tbl_C_AchiverStory";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = $m_id1;

                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function create_AchiverStory($cid, $atitle, $astory, $aimgpath, $device, $flag, $like, $comment, $cdate, $cby) {

        try {
            $query = "insert into Tbl_C_AchiverStory(clientId,title,story,imagepath,device,flagType,likeType,comment,createdDate,createdBy)
            values(:cid,:title,:story,:img,:device,:flg,:liket,:comm,:cd,:cby)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->bindParam(':title', $atitle, PDO::PARAM_STR);
            $stmt->bindParam(':story', $astory, PDO::PARAM_STR);
            $stmt->bindParam(':img', $aimgpath, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
            $stmt->bindParam(':flg', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':liket', $like, PDO::PARAM_STR);
            $stmt->bindParam(':comm', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':cby', $cby, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $cdate, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************************ SELECT ONE POST FOR MESSAGE WITH SENDR IMAGE AND NAME ******************* */

    public $type;
    public $id;

    function createWelcomeData($cid, $id, $type, $ptitle, $pimg, $pdate, $by, $flag) {
        $this->client = $cid;
        $this->id = $id;
        $this->type = $type;
        $this->posttitle = $ptitle;
        $this->imgpath = $pimg;
        $this->pdate = $pdate;
        $this->author = $by;
        try {
            $query = "insert into Tbl_C_WelcomeDetails(clientId,id,type,title,image,createdDate,createdBy,flagType)
            values(:cid,:id,:type,:title,:img,:cd,:cb,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->posttitle, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->imgpath, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->pdate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->author, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ****************************** show achiver list details ************************************* */

    function getAchiverListDetails($clientid) {
        $path = SITE;
        try {

            $query = "SELECT Tbl_C_AchiverStory . * ,CONCAT('" . $path . "',Tbl_C_AchiverStory.imagePath) as imagePath , DATE_FORMAT(Tbl_C_AchiverStory.createdDate,'%d %b %Y %h:%i %p') as createdDate , (
            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostComment.flagType = 16
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostLike.flagType = 16
            ) as likeCount , (

            SELECT COUNT(distinct userUniqueId) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostView.flagType = 16
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostView.flagType = 16
            ) as TotalCount

            FROM Tbl_C_AchiverStory where Tbl_C_AchiverStory.flagType = 16 and Tbl_C_AchiverStory.clientId =:cli order by Tbl_C_AchiverStory.storyId desc";



            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($res) {
                $response["success"] = 1;
                $response["message"] = "Data Found";
                $response["Data"] = $res;
            }
        } catch (PDOException $e) {

            $response["success"] = 0;
            $response["message"] = "Data Not Found" . $e;
        }

        return json_encode($response);
    }

    /*     * *************************** end show achiver list details ***************************************** */

    /*     * **************************** one achiver post detail ****************************************** */

    function getoneachiverpostdetails($postid) {
        $this->id_posts = $postid;

        try {
            $query = "select tac.* , DATE_FORMAT(tac.createdDate,'%d %b %Y %h:%i %p') as createdDate, user.firstName, user.lastName, user.emailId, user.contact from Tbl_C_AchiverStory as tac JOIN Tbl_EmployeeDetails_Master as user ON tac.createdBy = user.employeeId where tac.storyId =:comm";
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
                $post["post_title"] = $rows[$i]["title"];
                $post["post_img"] = $rows[$i]["imagePath"];
                $post["post_content"] = $rows[$i]["story"];
                $post["storyId"] = $rows[$i]["storyId"];
				$post["clientId"] = $rows[$i]["clientId"];
				$post["createdBy"] = $rows[$i]["createdBy"];
				$post["flagType"] = $rows[$i]["flagType"];
				$post["created_date"] = $rows[$i]["createdDate"];
				
				$post["firstName"] = $rows[$i]["firstName"];
				$post["lastName"] = $rows[$i]["lastName"];
				$post["emailId"] = $rows[$i]["emailId"];
				$post["contact"] = $rows[$i]["contact"];
				
				
                array_push($response["posts"], $post);
            }
            return json_encode($response);
        }
    }

    /*     * ****************************** end one achiver post detail ****************************************** */

    /*     * *********************** Achiver status ************************************** */

    public $idpost;
    public $statuspost;

    function status_Post($com, $coms) {

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 1) {
            $welstatus = "Publish";
        } else {
            $welstatus = "Unpublish";
        }
        try {
            $query = "update Tbl_C_AchiverStory set status = :sta where storyId = :comm";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->idpost, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);
            $stmt->execute();

            $wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :comm1 ";
            $stmtw = $this->DB->prepare($wquery);
            $stmtw->bindParam(':comm1', $this->idpost, PDO::PARAM_STR);
            $stmtw->bindParam(':sta1', $this->statuspost, PDO::PARAM_STR);
            $stmtw->execute();
			
			$pquery = "update Tbl_C_WelcomePopUp set status = :sta3 where id = :comm3 ";
            $stmtp = $this->DB->prepare($pquery);
            $stmtp->bindParam(':comm3', $this->idpost, PDO::PARAM_STR);
            $stmtp->bindParam(':sta3', $this->statuspost, PDO::PARAM_STR);
            $stmtp->execute();

            $gquery = "update Tbl_Analytic_StorySentToGroup set status = :sta2 where storyId = :comm2 ";
            $stmtg = $this->DB->prepare($gquery);
            $stmtg->bindParam(':comm2', $this->idpost, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $this->statuspost, PDO::PARAM_STR);
            //$stmtg->execute();
            $response = array();

            if ($stmtg->execute()) {
                $response["success"] = 1;
                $response["message"] = "status has changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * *********************** end Achiver status ************************************** */

    /*     * ****************************** generate three digit random number **************************** */

    function randomNumber($length) {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    /*     * ******************************end generate three digit random number **************************** */
    /*     * ******************************** convert into image ******************************************** */

    public $img;

    function convertIntoImage($encodedimage) {
        $num = self::randomNumber(6);
        $img = imagecreatefromstring(base64_decode($encodedimage));

        $imgpath = dirname(BASE_PATH) . '/images/achiverimage/' . $num . '.jpg';
        //echo $imgpath;
        imagejpeg($img, $imgpath);
        $imgpath1 = 'images/achiverimage/' . $num . '.jpg';
        return $imgpath1;
    }

    /*     * ********************************end convert into image ******************************************** */

    public function achiever_details($clientid, $storyId, $flag) {
        try {
            $site_url = dirname(SITE_URL).'/';

            $query = "select achiever.*,if(user.userImage IS NULL or user.userImage='','',CONCAT('" . $site_url . "',user.userImage)) as userImage, if(achiever.thumb_imagePath IS NULL or achiever.thumb_imagePath='' , CONCAT('" . $site_url . "', achiever.imagePath), CONCAT('" . $site_url . "',achiever.thumb_imagePath)) as imagePath, Concat(user_master.firstName, ' ', user_master.lastName) as createdBy from Tbl_C_AchiverStory as achiever join Tbl_EmployeePersonalDetails as user on achiever.createdBy = user.employeeId join Tbl_EmployeeDetails_Master as user_master on user_master.employeeId=achiever.createdBy where achiever.clientId=:cli and achiever.flagType=:flag and achiever.storyId=:storyId";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':storyId', $storyId, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($rows);
            $response['success'] = 1;
            $response['message'] = "data found";
            $response['data'] = $rows;
        } catch (Exception $ex) {
            echo $e;
            $response['success'] = 0;
            $response['message'] = "data not found " . $e;
        }
        return $response;
    }
	
/************************************ status update achiver approve *******************************/

function status_approveAchiver($storyId, $POST_TITLE, $POST_CONTENT, $achiver_status, $updatedby, $DATE,$clientid) {
		
        try {
            $query = "update Tbl_C_AchiverStory set status = :status, title = :title , story = :content , updatedBy = :uby, updatedDate = :udate where storyId = :sid And clientId = :cid ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $storyId, PDO::PARAM_STR);
            $stmt->bindParam(':title', $POST_TITLE, PDO::PARAM_STR);
			$stmt->bindParam(':content',  $POST_CONTENT, PDO::PARAM_STR);
			$stmt->bindParam(':status', $achiver_status, PDO::PARAM_STR);
			$stmt->bindParam(':uby', $updatedby, PDO::PARAM_STR);
			$stmt->bindParam(':udate', $DATE, PDO::PARAM_STR);
			$stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
			
            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "updated Successfully";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

/********************************* end status update achiver approve *****************************/

}

?>