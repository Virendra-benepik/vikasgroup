<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class Reading {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    
    public $uuid;
    public $client;

    function postSentTo($client, $pid, $uuid, $flag = '') {
        $this->client = $client;
        $this->postid = $pid;
        $this->uuid = $uuid;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_PostSentTo(clientId,postId,userUniqueId,sentDate,flagType)
            values(:cid,:pid,:uid,:dc,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->uuid, PDO::PARAM_STR);
            $stmt->bindParam(':dc', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_INT);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $pollid;

    function PollSentTo($cid, $pid, $uuid) {
        $this->client = $cid;
        $this->pollid = $pid;
        $this->uuid = $uuid;
        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_PollSentTo(clientId,pollId,userUniqueId,sentDate)
            values(:ci,:pid,:uid,:dc)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':ci', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->pollid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->uuid, PDO::PARAM_STR);
            $stmt->bindParam(':dc', $cd, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $thoughtid;

    function thoughtSentTo($clientId, $tid, $uuid) {
        $this->client = $clientId;
        $this->thoughtid = $tid;
        $this->bycommented = $uuid;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_ThoughtSentTo(clientId,thoughtId,userUniqueId,sentDate)
            values(:cid,:th,:uid,:dc)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':th', $this->thoughtid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->bycommented, PDO::PARAM_STR);
            $stmt->bindParam(':dc', $cd, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $noticeid;

    function noticeSentTo($clientId, $nid, $uuid) {
        $this->client = $clientId;
        $this->noticeid = $nid;
        $this->bycommented = $uuid;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_NoticeSentTo(clientId,noticeId,userUniqueId,sentDate)
            values(:cid,:th,:uid,:dc)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':th', $this->noticeid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->bycommented, PDO::PARAM_STR);
            $stmt->bindParam(':dc', $cd, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $eventid;

    function eventSentTo($client, $eid, $uuid) {
        $this->client = $client;
        $this->eventid = $eid;
        $this->uuid = $uuid;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_EventSentTo(clientId,eventId,userUniqueId,sentDate)
            values(:cid,:pid,:uid,:dc)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->eventid, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->uuid, PDO::PARAM_STR);
            $stmt->bindParam(':dc', $cd, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ***************************************sent ot group start ************************************* */

    public $groupid;

    /*     * ************* post sent to group start ****************** */

    function postSentToGroup($clientId, $PostId, $GroupId, $flag) {
        $this->client = $clientId;
        $this->postid = $PostId;
        $this->groupid = $GroupId;

        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into Tbl_Analytic_PostSentToGroup(clientId,postId,groupId,flagType,sentDate)values(:cid,:pid,:gid,:flag,:today)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************* post sent to group end ****************** */

    function noticeSentToGroup($clientId, $noticeId, $GroupId,$flag,$status) {
        $this->client = $clientId;
        $this->noticeid = $noticeId;
        $this->groupid = $GroupId;
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into Tbl_Analytic_NoticeSentToGroup(clientId,noticeId,groupId,sentDate,flagType,status)values(:cid,:nid,:gid,:today,:flag,:sts)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':nid', $this->noticeid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':sts', $status, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************* notice sent to group end ****************** */

    function pollSentToGroup($clientId, $pollId, $GroupId, $flag) {
        $this->client = $clientId;
        $this->pollid = $pollId;
        $this->groupid = $GroupId;
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into Tbl_Analytic_PollSentToGroup(clientId,pollId,groupId,flagType,sentDate)values(:cid,:polid,:gid,:flag,:today)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':polid', $this->pollid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************* notice sent to group end ****************** */

    function eventSentToGroup($clientId, $eventId, $GroupId, $flag) {
        $this->client = $clientId;
        $this->eventid = $eventId;
        $this->groupid = $GroupId;
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into Tbl_Analytic_EventSentToGroup(clientId,eventId,groupId,flagType,sentDate)values(:cid,:eventid,:gid,:flag,:today)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':eventid', $this->eventid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************* event sent to group end ****************** */

    function recognizeSentToGroup($clientId, $recogId, $GroupId) {
        $this->client = $clientId;
        $this->eventid = $recogId;
        $this->groupid = $GroupId;
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into RecognizeSentToGroup(clientId,recognizeId,groupId,createdDate)values(:cid,:rid,:gid,:today)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':rid', $this->eventid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

 
    /*     * ************************************ learning sent to group ************************************************** */

    function learningSentToGroup($clientId, $emptrainingid, $GroupId) {

        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into Tbl_Analytic_LearningSentToGroup(clientId,emplearningId,groupId,sentDate)values(:clientId,:emptrainingid,:GroupId,:sentdate)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':emptrainingid', $emptrainingid, PDO::PARAM_STR);
            $stmt->bindParam(':GroupId', $GroupId, PDO::PARAM_STR);
            $stmt->bindParam(':sentdate', $today, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************************************* end learning sent to group *************************************** */

    function StorySentToGroup($clientId, $storyId, $GroupId, $flag) {
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into Tbl_Analytic_StorySentToGroup(clientId,storyId,groupId,flagType,sentDate)values(:cid,:pid,:gid,:flag,:today)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $storyId, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $GroupId, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
/************************* thought sent to group *************************/

 function thoughtSentToGroup($clientId, $PostId, $GroupId, $flag) {
        $this->client = $clientId;
        $this->postid = $PostId;
        $this->groupid = $GroupId;

        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "insert into Tbl_Analytic_ThoughtSentToGroup(clientId,thoughtId,groupId,sentDate)values(:cid,:pid,:gid,:today)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            //$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

/***************************** end thought sent to group *****************/

/****************************************************************************************/
    
     function getGroupDetails($clientId, $GroupId) {
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "select * from Tbl_ClientGroupDetails where clientId = :cid and groupId = :gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $GroupId, PDO::PARAM_STR);
            $stmt->execute();
           $VAL =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $VAL; 
               
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
	/***************************************************************************************/

}

?>