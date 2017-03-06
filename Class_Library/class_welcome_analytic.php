<?php
@session_start();
include_once('class_connect_db_Communication.php');

class WelcomeAnalytic {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $postid;
    public $client;
    public $userid;
    public $usertype;

    function getLastThreeComment($k) {
        $query = "select * from Tbl_Analytic_PostComment where clientId=:cid order by commentDate desc limit 3";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute(array(':cid' => $cid));
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /*     * ****************************************************************************************************** */

    public $id;

    function getSinglePost($k) {
        $this->id = $k;
        $query = "select * from Tbl_C_PostDetails where flagCheck = 1 and post_id ='" . $this->id . "' and clientId='" . $cid . "'";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /*     * ********************************************************************************************************* */

    function totalviewpost($cid, $user_uniqueid, $user_type) {
        $this->client = $cid;
        $this->userid = $user_uniqueid;
        $this->usertype = $user_type;

        if ($this->usertype == "SubAdmin") {
            $query = "select count(pv.post_id) as count from Tbl_Analytic_PostView as pv join Tbl_C_PostDetails as pd on pd.post_id = pv.post_id  
      where pd.clientId=:cid and pd.userUniqueId =:uid";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->bindParam(':uid', $this->userid, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {

            $query = "select count(auto_id) as count from Tbl_Analytic_PostView where clientId=:cid";
            try {
                $stmt = $this->DB->prepare($query);

                $stmt->execute(array(':cid' => $this->client));
            } catch (PDOException $e) {
                echo $e;
            }
        }
        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /*     * ********************************************************************************************************* */

    function happinessScore($cid) {
        $happy_id = "h1";
        $month = date("m");
        $year = date("Y");
        $this->client = $cid;
        try {
            $query = "select avg(value) as count from Tbl_Analytic_EmployeeHappiness where MONTH(date_of_feedback)=:month and YEAR(date_of_feedback) =:year and clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':month', $month, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows1 = $stmt->fetchAll();
        return json_encode($rows1);
    }

    /*     * *************************************************************************************** */

    function commentScore($cid, $user_uniqueid, $user_type) {
        $this->client = $cid;
        $this->userid = $user_uniqueid;
        $this->usertype = $user_type;

        if ($this->usertype == "SubAdmin") {
            $query = "select count(pc.commentId) as count from Tbl_Analytic_PostComment as pc join Tbl_C_PostDetails as pd on pd.post_id = pc.postId where pd.clientId =:cid and pd.userUniqueId =:uid";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->bindParam(':uid', $this->userid, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            $query = "select count(commentId) as count from Tbl_Analytic_PostComment where clientId=:cid";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        }
        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /*     * ************************************************************************************************** */

    function likeScore($cid, $user_uniqueid, $user_type) {
        $this->client = $cid;
        $this->userid = $user_uniqueid;
        $this->usertype = $user_type;
        if ($this->usertype = "SubAdmin") {
            $query = "select count(pl.postId) as count from Tbl_Analytic_PostLike as pl join Tbl_C_PostDetails as pd on pd.post_id = pl.postId where pd.clientId=:cid and pd.userUniqueId =:uid";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->bindParam(':uid', $this->userid, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            $query = "select count(postId) as count from Tbl_Analytic_PostLike where clientId=:cid";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        }
        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /*     * ********************************************************************************************** */

    function postScore() {

        $query = "select count(post_id) as count from Tbl_C_PostDetails where clientId=:cid";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /*     * ************************************************************************* */

    function groupScore() {

        $query = "select count(channelid) as count from ChannelDetails";
        try {
            $stmt = $this->DB->prepare($query);
            //$stmt->bindParam(':h',$happy_id, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }

    /*     * *********************************************************************************************** */

    function latestUser($cid) {
        $access = "Admin";
        $site_url = SITE;
        $query = "select edm.*, Concat('$site_url',epd.userImage) as userImage from Tbl_EmployeeDetails_Master as edm join Tbl_EmployeePersonalDetails as epd on epd.employeeId = edm.employeeId where edm.accessibility =:val and edm.clientId = :cid";
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':val', $access, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();

        if ($rows) {
            $response = array();

            foreach ($rows as $row) {
                $post["firstName"] = $row["firstName"];
                $post["middleName"] = $row["middleName"];
                $post["lastName"] = $row["lastName"];
                $post['userimage'] = $row["userImage"];
                array_push($response, $post);
            }
            return json_encode($response);
        }
    }

    /*     * ******************************************************************************************************************* */

    function latestComment($cid, $user_uniqueid, $user_type) {
        $this->client = $cid;
        $this->userid = $user_uniqueid;
        $this->usertype = $user_type;

        if ($this->usertype == "SubAdmin") {
            $query = "select pc.*,
DATE_FORMAT(pc.commentDate,'%d %b %Y %h:%i %p') as commentDate from Tbl_Analytic_PostComment as pc join Tbl_C_PostDetails as pd on pd.post_id = pc.postId where pd.clientId = :cid and pd.userUniqueId =:uid and pc.status='show' order by pc.autoId desc limit 3";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->bindParam(':uid', $this->userid, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            $query = "select * from Tbl_Analytic_PostComment where clientId = :cid order by autoId desc limit 3";
            try {
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e;
            }
        }
        $rows = $stmt->fetchAll();
        //$forimage = "http://admin.benepik.com/employee/virendra/benepik_admin/";
        $forimage = $servername = SITE;
        if ($rows) {
            $response = array();

            for ($i = 0; $i < count($rows); $i++) {
                $post["comment"] = $rows[$i]["comment"];
                $post["commentBy"] = $rows[$i]["commentBy"];

                $commentedBy = $rows[$i]["commentBy"];

                $query2 = "SELECT ud.*, upd.* FROM Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as upd on ud.employeeId = upd.employeeId WHERE ud.employeeId =:maid and ud.clientId =:cid";
                $stmt2 = $this->DB->prepare($query2);
                $stmt2->bindParam(':maid', $commentedBy, PDO::PARAM_STR);
                $stmt2->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt2->execute();
                $row = $stmt2->fetchAll();
                $post["firstName"] = $row[0]["firstName"];
                $post["lastname"] = $row[0]["lastName"];
                $post["designation"] = $row[0]["designation"];
                $post["userimage"] = $forimage . $row[0]["userImage"];
                $post["commentDate"] = $rows[$i]["commentDate"];
                array_push($response, $post);
            }
            return json_encode($response);
        }
    }

    function latestChannel($cid,$user_type,$user_uniqueid) {
        $this->client = $cid;
		if($user_type == 'Admin')
		{
        $query = "select * , DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate  from Tbl_ClientGroupDetails where clientId = :cid order by createdDate desc limit 0,3";
        }
		else
		{
		$query = "select tgd.*, DATE_FORMAT(tgd.createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_ClientGroupAdmin as tga JOIN Tbl_ClientGroupDetails as tgd ON tga.groupId = tgd.groupId and tga.clientId = tgd.clientId where tgd.clientId = :cid and tga.userUniqueId = :uuid and tgd.status = 'active' order by tgd.createdDate desc limit 0,3";	
		}
		try {
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
			if($user_type != 'Admin'){$stmt->bindParam(':uuid', $user_uniqueid, PDO::PARAM_STR);}
			$stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();

        if ($rows) {
            $response = array();

            foreach ($rows as $row) {
                $post["groupName"] = $row["groupName"];
                $post["createdBy"] = $row["createdBy"];
                $post["createdDate"] = $row["createdDate"];

                array_push($response, $post);
            }
            return json_encode($response);
        }
    }

}

?>