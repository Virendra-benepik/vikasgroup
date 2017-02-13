<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

if (!class_exists('FindGroup')) {
    require_once('Api_Class/class_find_groupid.php');
}

class HappinessQuestion {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function surveyMaxId() {
        try {
            $max = "select max(surveyId) from Tbl_C_HappinessQuestion";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $qid = $m_id1;

                return $qid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function createSurvey($surveyid, $clientid, $questiontext, $enableComment, $startdate, $expiryDate, $createdby, $createddate) {
//        echo $clientid . ' - ' . $questiontext . ' - ' . $enableComment . ' - ' . $startdate . ' - ' . $expiryDate . ' - ' . $createdby . ' - ' . $createddate;die;

        $this->idclient = $clientid;
        $this->questiontext = $questiontext;
        $this->enable_comment = $enableComment;
        $this->startdate = $startdate;
        $this->expiryDate = $expiryDate;
        $this->createdby = $createdby;
        $this->createddate = $createddate;

        try {

            $query1 = "select * from Tbl_C_HappinessQuestion where expiryDate > '" . $this->startdate . "' and status = 1 and clientId=:cid";
            $stmt1 = $this->DB->prepare($query1);
            //  $stmt1->bindParam(':dte1', $this->startdate, PDO::PARAM_STR);
            $stmt1->bindParam(':cid', $this->idclient, PDO::PARAM_STR);

            $stmt1->execute();
            $value = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            echo "this is existing survey";
            echo "<pre>";
            //print_r($value);


            if (count($value) > 0) {
                $result['succes'] = 0;
                $result['message'] = "survey is Available";
                return($result);
            } else {
                $query = "insert into Tbl_C_HappinessQuestion(surveyId,clientId,question,enableComment,startDate,expiryDate,createdBy,createdDate) values(:sid,:cid,:ques_text,:enable_comment, :startdate, :expiryDate, :createdby, :createddate)";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':sid', $surveyid, PDO::PARAM_STR);
                $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':ques_text', $this->questiontext, PDO::PARAM_STR);
                $stmt->bindParam(':enable_comment', $this->enable_comment, PDO::PARAM_STR);
                $stmt->bindParam(':startdate', $this->startdate, PDO::PARAM_STR);
                $stmt->bindParam(':expiryDate', $this->expiryDate, PDO::PARAM_STR);
                $stmt->bindParam(':createdby', $this->createdby, PDO::PARAM_STR);
                $stmt->bindParam(':createddate', $this->createddate, PDO::PARAM_STR);
                $stmt->execute();

                $result['succes'] = 1;
                $result['message'] = "survey is successfully started";
                return($result);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function SurveyDetails($clientid, $user_uniqueid, $user_type) {
        $this->idclient = $clientid;
        $this->eid = $user_uniqueid;
        $this->utype = $user_type;

        if ($this->utype == "SubAdmin") {
            try {
                $query = "select * from Tbl_C_HappinessQuestion where clientId=:cli and createdBy =:cb order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':cb', $this->eid, PDO::PARAM_STR);
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
        } else {
            try {
                $query = "select * from Tbl_C_HappinessQuestion where clientId=:cli order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    }

    function updateSurveyStatus($pid, $sta) {
        $this->pollid = $pid;
        $this->status = $sta;
        /* if ($this->status == 'Live') {
          $pollstatus = 1;
          } else {
          $pollstatus = 0;
          } */

        try {
            /* $wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :comm1 ";
              $stmtw = $this->DB->prepare($wquery);
              $stmtw->bindParam(':comm1', $this->pollid, PDO::PARAM_STR);
              $stmtw->bindParam(':sta1', $pollstatus, PDO::PARAM_STR);
              $stmtw->execute();
             */

            $query = "update Tbl_C_HappinessQuestion set status=:sta where questionId =:pid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->pollid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response[success] = 1;
                $response[message] = "Successfully Feedback status changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************FOR GETTING ANSWERS FROM DATABASE BASED ON POLLID STARTS**************************** */

    function getresultquestion($qid, $clientid, $sid) 
                {
   
        try {
            $query = "select value as label,count(value) as value    from Tbl_Analytic_EmployeeHappiness where clientId=:cli and surveyId = :sid and questionId = :qid group by value;
";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
            
             $query1 = "select question from Tbl_C_HappinessQuestion where clientId=:cli and surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);    
            $stmt1->execute();
                $value = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                
                $response["data"] = $rows;
               // $response["question"] = $value;
         }   
        catch (PDOException $e) {
            echo $e;
        }
        return json_encode($response);
    }
    
    
     function getSurveyquestion($qid, $clientid, $sid) 
                {
   
        try {
           
             $query1 = "select question from Tbl_C_HappinessQuestion where clientId=:cli and surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);    
            $stmt1->execute();
                $value = $stmt1->fetch(PDO::FETCH_ASSOC);
                
               
               // $response["question"] = $value;
         }   
        catch (PDOException $e) {
            echo $e;
        }
        return json_encode($value);
    }
    
    
    function getSurveyResponse($qid, $clientid, $sid) 
                {
   
        try {
            $query = "select *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_Analytic_EmployeeHappiness where clientId=:cli and surveyId = :sid and questionId = :qid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
           // print_r($rows);
                 if(count($rows)>0)
                 {
                $response["success"] = 1;
                $response["data"] = $rows;
               // $response["question"] = $value;
                 }
                 else{
                     $response["success"] = 0;
                     $response["msg"] = "No Rresponse Found";
                 }
         }   
        catch (PDOException $e) {
            echo $e;
        }
        return json_encode($response);
    }
    
    

    }
  
