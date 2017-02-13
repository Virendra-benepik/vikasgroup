<?php
include_once('class_connect_db_Communication.php');

class Recognize {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $idclient;

    function getRecognizeDetails($client_id) {
        $this->idclient = $client_id;

        try {
            $query = "select * from Tbl_RecognizedEmployeeDetails where clientId=:cid order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($row);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $id_recog;

    function getonerecogdetails($regid) {
        $this->id_recog = $regid;

        try {
            $query = "select * , DATE_FORMAT(dateOfEntry,'%d %b %Y %h:%i %p') as dateOfEntry from Tbl_RecognizedEmployeeDetails where recognitionId =:rid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':rid', $this->id_recog, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = $rows;

        return json_encode($response);
    }

    public $status;
    public $regid;
    public $topic;
    public $uid;
    public $point;
    public $recozby;

    //  updaterecognizestatus($rzid,$status,$cid,$topic,$userid,$point);          
    function updaterecognizestatus($regid, $status, $cid, $topic, $uid, $recozby, $point) {

        $this->regid = $regid;
        $this->status = $status;
        $this->idclient = $cid;
        $this->topic = $topic;
        $this->uid = $uid;
        $this->recozby = $recozby;
        $this->point = $point;

//echo "points -".$this->point;

        $this->recozby = $recozby;
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d H:i:s A");
        if ($this->status == "Reject") {
            try {
                $query = "update Tbl_RecognizedEmployeeDetails SET status =:sta where recognitionId =:rid and clientId =:cid";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':rid', $this->regid, PDO::PARAM_STR);
                $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
                $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                $response = array();
                if ($stmt->execute()) {
                    $response["success"] = 1;
                    $response["message"] = "Recognition status has changed successfully";
                    return json_encode($response);
                }
            } catch (PDOException $t) {
                echo $t;
            }
        }


        if ($this->status == "Approve") {
            $account_status = "Credited";
//echo $uid;
            $totalpointsdata = self::getMaxtotalPoints($cid, $uid);
            $ert = json_decode($totalpointsdata, true);
            /* echo "<pre>";
              print_r($ert);
              echo "</pre>"; */
//echo "total point ".$ert['data'][0]['totalPoints'];
//echo $ert['success'];
            if ($ert['success'] == 1) {
                // $ert['data'][0]['totalPoints']
                $totlpoint = $ert['data'][0]['totalPoints'] + $this->point;
            } else {
                $totlpoint = $this->point;
            }
//echo "total_point ".$totlpoint."<br>";
            try {
                $query = "update Tbl_RecognizedEmployeeDetails SET status =:sta where recognitionId =:rid and clientId =:cid";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':rid', $this->regid, PDO::PARAM_STR);
                $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
                $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                $response = array();
                if ($stmt->execute()) {

                    $query1 = "insert into Tbl_RecognizeApprovDetails(clientId,recognizeId,userId,recognizeBy,quality,points,totalPoints,entryDate,stmtStatus,regStatus)
               values(:cid,:rid,:uid,:uid1,:qul,:pts,:tpts,:edate,:regstatus,:ststatus)";

                    $stmt = $this->DB->prepare($query1);
                    $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                    $stmt->bindParam(':rid', $this->regid, PDO::PARAM_STR);
                    $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
                    $stmt->bindParam(':uid1', $this->recozby, PDO::PARAM_STR);
                    $stmt->bindParam(':qul', $this->topic, PDO::PARAM_STR);
                    $stmt->bindParam(':pts', $this->point, PDO::PARAM_STR);
                    $stmt->bindParam(':tpts', $totlpoint, PDO::PARAM_STR);
                    $stmt->bindParam(':edate', $date, PDO::PARAM_STR);
                    $stmt->bindParam(':ststatus', $this->status, PDO::PARAM_STR);
                    $stmt->bindParam(':regstatus', $account_status, PDO::PARAM_STR);
                    $response = array();
                    if ($stmt->execute())
                        $response["success"] = 1;
                    $response["message"] = "Recognition status has changed successfully";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        }
    }

    function getMaxtotalPoints($cid, $uid) {
        $this->idclient = $cid;
        $this->uid = $uid;
        //echo "userid:-".$this->uid."<br/>";
        //echo $this->idclient;
        try {
            $query = "select totalPoints from Tbl_RecognizeApprovDetails where autoId =(select max(autoId) from RecognizeApprovDetails where clientId=:cid and userId =:uid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
            $stmt->execute();
            $totalpoints = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //print_r($totalpoints);
            if (count($totalpoints) > 0) {
                $response1["success"] = 1;
                $response1['msg'] = 'data found';
                $response1["data"] = $totalpoints;
                return json_encode($response1);
            } else {
                $response1["success"] = 0;
                $response1["msg"] = 'data not found';

                return json_encode($response1);
            }
        } catch (PDoException $k) {
            echo $k;
        }
    }

    public function recognizeGetData($clientid) {
        try {
            $query = "select topicId,recognizeTitle,points, concat('http://admin.benepik.com/employee/virendra/benepik_admin/',image) as image,createdDate from Tbl_RecognizeTopicDetails where clientId=:cli";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query2 = "select topicId from Tbl_RecognizeTopicDetails where clientId=:cli";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);

            if (COUNT($rows) > 0) {
                $response['success'] = 1;
                $response['msg'] = "User recognition value is added for client";
                $response['posts'] = $rows;
                $response['shortRecognised'] = $rows2;
            } else {
                $response['success'] = 0;
                $response['msg'] = "Recognised values and topic not found";
            }
            return $response;
        } catch (PDOException $e) {
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function create_Comment($client, $pid, $comby, $comcon) {
        $this->clientid = $client;
        $this->postid = $pid;
        $this->commentedby = $comby;
        $this->commentcontent = $comcon;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date('Y-m-d, h:i:s');

        try {
            $max = "select max(autoId) from Tbl_Analytic_RecognitionComment";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $commentid = "RegCom-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }



        try {
            $query = "insert into Tbl_Analytic_RecognitionComment(commentId,clientId,recognitionId,comment,commentBy,dateOfComment)
            values(:pid,:cli,:pt,:cc,:pi,:cb)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $commentid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':cc', $this->commentcontent, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $this->commentedby, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $cd, PDO::PARAM_STR);

            if ($stmt->execute()) {
                try {
                    $query1 = "SELECT * FROM Tbl_Analytic_RecognitionComment WHERE recognitionId = :pstid order by autoId desc";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':pstid', $this->postid, PDO::PARAM_STR);
                    $stmt1->execute();
                    $rows = $stmt1->fetchAll();

                    $response["posts"] = array();


                    if ($rows) {
                        $forimage = "http://admin.benepik.com/employee/virendra/benepik_admin/";

                        $response["success"] = 1;
                        $response["message"] = "Comment posted successfully";

                        for ($i = 0; $i < count($rows); $i++) {
                            $post = array();

                            $post["comment_id"] = $rows[$i]["commentId"];
                            $post["recognitionId"] = $rows[$i]["recognitionId"];
                            $post["comment"] = $rows[$i]["comment"];
                            $post["commentby"] = $rows[$i]["commentBy"];
                            $mailid = $rows[$i]["commentBy"];

                            $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $row = $stmt2->fetch();

                            $post["firstname"] = $row["firstName"];
                            $post["lastname"] = $row["lastName"];
                            $post["designation"] = $row["designation"];
                            $post["userImage"] = $forimage . $row["userImage"];
                            $d1 = $rows[$i]["dateOfComment"];

                            $date = date_create($d1);
                            $post["dateOfComment"] = date_format($date, "d M Y H:i A");

                            array_push($response["posts"], $post);
                        }

                        return $response;
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "There is no comments for this post";
                        return $response;
                    }
                } catch (PDOException $e) {
                    echo $e;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function Comment_display($clientid, $postid) {

        $path = "http://admin.benepik.com/employee/virendra/benepik_admin/";
        try {
            $query = "select * from Tbl_Analytic_RecognitionComment where recognitionId =:pi and clientId=:cli order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {

                $response["Success"] = 1;
                $response["Message"] = "Recognition Comments are display here";
                $response["Posts"] = array();

                foreach ($rows as $row) {
                    $post["commentId"] = $row["commentId"];
                    $post["commentBy"] = $row["commentBy"];
                    $employeeid = $row["commentBy"];


                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post["name"] = $rows["firstName"];
                    $post["userImage"] = $path . $rows["userImage"];
                    $post["designation"] = $rows["designation"];
                    $post["comment"] = $row["comment"];
                    $d1 = $row["dateOfComment"];

                    $date = date_create($d1);
                    $post["dateOfComment"] = date_format($date, "d M Y H:i A");

                    array_push($response["Posts"], $post);
                }
            } else {
                $response["Success"] = 0;
                $response["Message"] = "There is no comment for this recognition";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>