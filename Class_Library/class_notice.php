<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//session_start();
include_once('class_connect_db_Communication.php');

class Notice {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function maxId() {
        try {
            $max = "select max(autoId) from Tbl_C_NoticeDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = "Notice-" . $m_id1;

                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    public $id;
    public $title;
    public $noticename;
    public $created_by;
    public $pdate;
    public $loc;

    function addNotice($client, $maxid, $title, $noticename, $createdby, $ptime, $utime, $post_date, $flag, $device) {
        $now = time();
        $publishtime = strtotime($ptime);
        $timediff = $publishtime - $now;
        
        $this->id = $maxid;
        $this->title = $title;
        $this->noticename = $noticename;
        $this->created_by = $createdby;
        $this->client = $client;
        $status = ($timediff>0)?"Pending":"Live";
        $this->pubtym = $ptime;
        $this->unpubtym = $utime;
        $this->post_dat = $post_date;

        //echo $postid;
        try {
            $qu = "insert into Tbl_C_NoticeDetails(ClientId,noticeId,noticeTitle,fileName,createdBy,status,device,flagType,publishingTime,unpublishingTime,createdDate)
                values(:cid,:nid,:ntitle,:fname,:cb,:st,:device,:flagt,:pt,:upt,:cd)";
            $stmt = $this->DB->prepare($qu);
            $stmt->bindParam(':nid', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':ntitle', $this->title, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $this->noticename, PDO::PARAM_STR);

            $stmt->bindParam(':cb', $this->created_by, PDO::PARAM_STR);
            $stmt->bindParam(':st', $status, PDO::PARAM_STR);
             $stmt->bindParam(':device',$device, PDO::PARAM_STR);
            $stmt->bindParam(':flagt',$flag, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->pubtym, PDO::PARAM_STR);
            $stmt->bindParam(':upt', $this->unpubtym, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->post_dat, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response['success'] = 1;
                        $response['msg'] = 'Notice Successfully Createdd';
            }
        } catch (PDOException $ex) {
            echo $ex;
            $response['success'] = 0;
                        $response['msg'] = 'Notice not Successfully Createdd';
        }
        return $response;   
    }

    public $selection;
    public $client;
    public $noticid;
    public $location;

    function addNoticeLocation($clientid, $noticeid, $usertype, $location) {
        $this->selection = $usertype;
        $this->client = $clientid;
        $this->noticid = $noticeid;
        $this->location = $location;

        if ($this->selection == 'All') {
            try {
                // not in use
                $query = "insert into NoticeLocationDetails(clientId,noticeId,location)values(:cid,:notid,:loc)";
                $stmt1 = $this->DB->prepare($query);
                $stmt1->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt1->bindParam(':notid', $this->noticid, PDO::PARAM_STR);
                $stmt1->bindParam(':loc', $this->selection, PDO::PARAM_STR);
                $stmt1->execute();
                $response['success'] = 1;
                $response['msg'] = 'Notice Successfully Createdd';
            } catch (PDOException $ex) {
                echo $ex;
            }
        } else {
            $countlocation = count($this->location);
            echo "total location := " . $countlocation . "<br/>";
            for ($i = 0; $i < $countlocation; $i++) {
                echo "execuation := " . $i . "<br/>";
                try {

                    // not in use
                    $query1 = "insert into NoticeLocationDetails(clientId,noticeId,location)values(:cid,:notid,:loc)";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':cid', $this->client, PDO::PARAM_STR);
                    $stmt1->bindParam(':notid', $this->noticid, PDO::PARAM_STR);
                    $stmt1->bindParam(':loc', $location[$i], PDO::PARAM_STR);
                    if ($stmt1->execute()) {
                        $response['success'] = 1;
                        $response['msg'] = 'Notice Successfully Createdd';
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
            }
        }
        return($response);
    }

    function displayNotice($cli) {
        $this->clientid = $cli;

//        $path = "admin.benepik.com/employee/virendra/Mahle_AdminPanel/";
        $path = SITE_URL;

        try {
            $qu = "select * from Tbl_C_NoticeDetails where clientId=:cli";
            $stmt = $this->DB->prepare($qu);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $response = array();
            if ($rows) {
                $response['success'] = 1;
                $response['msg'] = 'Notice Successfully Createdd';
                $response['posts'] = array();

                foreach ($rows as $row) {
                    $post["noticePath"] = $path . $row["fileName"];
                    $post["noticeTitle"] = $row["noticeTitle"];
                    array_push($response['posts'], $post);
                }
                return json_encode($response);
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    function updateNotice($clientid, $noticeid, $title) {
        try {
            $qu = "update Tbl_C_NoticeDetails set noticeTitle=:ntitle where clientId=:cli and noticeId=:nid";
            $stmt = $this->DB->prepare($qu);
            $stmt->bindParam(':nid', $noticeid, PDO::PARAM_STR);
            $stmt->bindParam(':ntitle', $title, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "successfully updated data";
                return $response;
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ********************************welcome updated ********************************** */
}

?>