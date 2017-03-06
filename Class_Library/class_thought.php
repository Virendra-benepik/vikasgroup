<?php
include_once('class_connect_db_Communication.php');
include_once('Api_Class/class_find_groupid.php');
class ThoughtOfDay {

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

    public $tid;
    public $clid;
    public $tcontent;
    public $timgpath;
    public $tdate;
    public $author;

    function thoughtMaxId() {
        try {
            $max = "select max(autoId) from Tbl_C_Thought";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = "Tht-" . $m_id1;

                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function createThought($cid, $tid, $tcontent, $timg,$flag, $by, $ptime, $utime, $post_date) {
        $this->clid = $cid;
        $this->tid = $tid;
        $this->tcontent = $tcontent;
        $this->timgpath = $timg;
        $this->author = $by;
        $this->putime = $ptime;
        $this->untime = $utime;
        $status = 1;
        $this->pos_dat = $post_date;

        try {
            $query = "insert into Tbl_C_Thought(clientId,thoughtId,message,thoughtImage,flagType,createdBy,publishingTime,unpublishingTime,status,createdDate)
            values(:cid,:tid,:msg,:img,:flag1,:cb,:ptym,:utym,:st,:cd)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->clid, PDO::PARAM_STR);
            $stmt->bindParam(':tid', $this->tid, PDO::PARAM_STR);
            $stmt->bindParam(':msg', $this->tcontent, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->timgpath, PDO::PARAM_STR);
            $stmt->bindParam(':flag1',$flag, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->author, PDO::PARAM_STR);
            $stmt->bindParam(':ptym', $this->putime, PDO::PARAM_STR);
            $stmt->bindParam(':utym', $this->untime, PDO::PARAM_STR);
            $stmt->bindParam(':st', $status, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->pos_dat, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************ANDROID FOR GETTING Thought DETAILS FROM DATABASE BASED ON CLIENTID STARTS**************************** */

    function getthoughtlist($clientid,$uuid,$value) {
        $this->idclient = $clientid;
        $this->value = $value;
		//  echo $module;

		/****************************** check user detail *******************************************/
        $query2 = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
        $stmt2 = $this->DB->prepare($query2);
        $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
        $stmt2->bindParam(':empid', $uuid, PDO::PARAM_STR);
        $stmt2->execute();
        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
       // print_r($rows2);
		
        /****************************** end check user detail *************************************/
		if (count($rows2) > 0) {
			
			/************************ find user group ********************************/

            $uuids = $rows2[0]['employeeId'];
            //echo "employee id -".$uuids;
            $group_object = new FindGroup();    // this is object to find group id of given unique id 
            $getgroup = $group_object->groupBaseofUid($clientid, $uuids);
            $value = json_decode($getgroup, true);
             // echo'<pre>';
              //print_r($value);
		/*********************** end find user group*******************************/
		
		if (count($value['groups']) > 0) {
               $in = implode("', '", array_unique($value['groups']));
        try {
			/******************* count thought *****************************/
			$query1 = "select count(distinct(thoughtId)) as totals from Tbl_Analytic_ThoughtSentToGroup where clientId=:cli and status = 1 and groupId IN('" . $in . "')";
               
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt1->execute();
                $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
				//print_r($rows1);
		    /************************ end count thought ***************************/
			
							
                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["totals"] = $rows1[0]["totals"];
				$response["posts"] = array();
				$post = array();
				
			/*********************** find thought id ***********************/
			
			$query3 = "select distinct(thoughtId) from Tbl_Analytic_ThoughtSentToGroup where clientId=:cli and status = 1 and groupId IN('" . $in . "') order by autoId desc";

                    $stmt3 = $this->DB->prepare($query3);
                    $stmt3->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    $stmt3->execute();
                    $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
			//print_r($rows3);
			
			/********************** end thought id *************************/
			 if (count($rows3) > 0) {
				  foreach ($rows3 as $row) {
			$path = dirname(SITE_URL)."/";
			 $postid = $row["thoughtId"];
            $query = "select thoughtId,message,if(thoughtImage = '' or thoughtImage IS NULL ,'',CONCAT('".$path."',thoughtImage))as thoughtImage,createdBy,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p')as createdDate from Tbl_C_Thought where clientId=:cli and status = 1 and thoughtId = :thoughtid and flagType = 5 order by autoId desc";
           
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
			$stmt->bindParam(':thoughtid', $postid, PDO::PARAM_STR);
			//$stmt->bindValue(':lim', (int)$this->value, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($rows);
			
			$post["message"] = strip_tags(trim($rows["message"]));
             array_push($response["posts"], $rows);
		}
		return json_encode($response);
			 }
		else
		{
				$response["success"] = 0;
                $response["message"] = "No more post available";
                return json_encode($response);
		}
			
        } catch (PDOException $e) {
            echo $e;
        }
		}
		else
		{
			 $response["success"] = 0;
             $response["message"] = "You are not selected in any group";
             return json_encode($response);
		}
		}
		else
		{
			$response["success"] = 0;
            $response["message"] = "Sorry! You are Not Authorized User";
            return json_encode($response);
		}
		
		
    }

    /*     * ******************FOR GETTING THOUGHT DETAILS FROM DATABASE BASED ON CLIENTID STARTS**************************** */

    function thoughtDetails($clientid,$user_uniqueid,$user_type) {
        $this->idclient = $clientid;
		if($user_type == 'SubAdmin')
		{
		try {
            $query = "select * , DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_Thought where clientId=:cli and createdBy = :uid order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
			$stmt->bindParam(':uid', $user_uniqueid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $response = array();

            if ($rows) {
                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No more post available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }	
		}
		else
		{
        try {
            $query = "select * , DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_Thought where clientId=:cli order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $response = array();

            if ($rows) {
                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No more post available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
		}
    }

    /*     * ******************FOR GETTING THOUGHT DETAILS FROM DATABASE BASED ON POLLID AND CLIENTID ENDS**************************** */
	
/******************************** thought status *********************/
public $idpost;
    public $statuspost;

    function status_Post($com, $coms) {

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 1) {
            $welstatus = 'Publish';
        } else {
            $welstatus = 'Unublish';
        }
        try {
            $query = "update Tbl_C_Thought set status = :sta where thoughtId = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->idpost, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);
            $stmt->execute();

            $gquery = "update Tbl_Analytic_ThoughtSentToGroup set status = :sta2 where thoughtId = :comm2 ";
            $stmtg = $this->DB->prepare($gquery);
            $stmtg->bindParam(':comm2', $this->idpost, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $this->statuspost, PDO::PARAM_STR);
            $stmtg->execute();
			
			$wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :comm1 ";
            $stmtw = $this->DB->prepare($wquery);
            $stmtw->bindParam(':comm1', $this->idpost, PDO::PARAM_STR);
            $stmtw->bindParam(':sta1', $this->statuspost, PDO::PARAM_STR);
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
/************************ end thought status *************************/

/*************************** get single thought ************************/
function getSinglethought($k) {
        $this->id = $k;
        $query = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDates  from Tbl_C_Thought where thoughtId ='" . $this->id . "'";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }
/**************************** end get single thought ********************/

/******************************** update thought *****************************/
/************************ update post *****************************/	
function updateThought($cid,$pid,$content, $POST_IMG, $post_date, $USERID)
{
 $this->client = $cid;
 $this->id = $pid;
 $this->title = $content;
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
		         $qu = "update Tbl_C_Thought set message=:ptitle,thoughtImage =:pimg, updatedDate =:cd,updatedBy=:by where thoughtId =:pid and clientId =:cid";
                 $stmt = $this->DB->prepare($qu);
                 $stmt->bindParam(':cid',$this->client, PDO::PARAM_STR);
                 $stmt->bindParam(':pid',$this->id, PDO::PARAM_STR);
                 $stmt->bindParam(':ptitle',$this->title, PDO::PARAM_STR);
                 $stmt->bindParam(':pimg',$this->img, PDO::PARAM_STR);
                 $stmt->bindParam(':cd',$this->pdate, PDO::PARAM_STR);
                 $stmt->bindParam(':by',$USERID, PDO::PARAM_STR);
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
/***************************** end update thought ****************************/
}
