<?php
include_once('class_connect_db_Communication.php');

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

    function createThought($cid, $tid, $tcontent, $timg, $by, $ptime, $utime, $post_date) {
        $this->clid = $cid;
        $this->tid = $tid;
        $this->tcontent = $tcontent;
        $this->timgpath = $timg;
        $this->author = $by;
        $this->putime = $ptime;
        $this->untime = $utime;
        $status = "Live";
        $this->pos_dat = $post_date;

        try {
            $query = "insert into Tbl_C_Thought(clientId,thoughtId,message,thoughtImage,createdBy,publishingTime,unpublishingTime,status,createdDate)
            values(:cid,:tid,:msg,:img,:cb,:ptym,:utym,:st,:cd)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->clid, PDO::PARAM_STR);
            $stmt->bindParam(':tid', $this->tid, PDO::PARAM_STR);
            $stmt->bindParam(':msg', $this->tcontent, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->timgpath, PDO::PARAM_STR);
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

    function thoughtDetailsFORandroid($clientid,$val,$module) {
        $this->idclient = $clientid;
        $this->value = $val;
		//  echo $module;

        try {
			if($module == 1)
			{
				$query = "select * from Tbl_C_Thought where clientId=:cli order by autoId desc limit 2";
			}
			else{
				$query = "select * from Tbl_C_Thought where clientId=:cli order by autoId desc limit " . $this->value . ",5";
			}
           
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = array();

//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";
            $path = SITE_URL;
            if ($rows) 
			{
				if($module == 1)
				{
					$query1 = "select count(thoughtId) as totals from Tbl_C_Thought where clientId=:cli limit 2";
				}
				else{
					 $query1 = "select count(thoughtId) as totals from Tbl_C_Thought where clientId=:cli";
				}
               
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt1->execute();
                $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["totals"] = $rows1[0]["totals"];
                $response["posts"] = array();
                foreach ($rows as $row) {
                    $post["thoughtId"] = $row["thoughtId"];
                    $post["message"] = strip_tags(trim($row["message"]));
                    $post["thoughtImage"] = $path . $row["thoughtImage"];
                    $post["createdBy"] = $row["createdBy"];
                    $post["createdDate"] = $row["createdDate"];
                    array_push($response["posts"], $post);
                }
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "data doesn't fetch";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************FOR GETTING THOUGHT DETAILS FROM DATABASE BASED ON CLIENTID STARTS**************************** */

    function thoughtDetails($clientid) {
        $this->idclient = $clientid;

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
                $response["message"] = "data doesn't fetch";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************FOR GETTING THOUGHT DETAILS FROM DATABASE BASED ON POLLID AND CLIENTID ENDS**************************** */
}
