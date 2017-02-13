<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//if (!class_exists('Connection_Communication')) {
require_once('class_connect_db_Communication.php');
//}
//if (!class_exists('FindGroup')) {
require_once('class_find_groupid.php');

//}
/* if (!class_exists('getUserData')) {
  require_once('class_get_useruniqueid.php');
  } */

class GetLearning {

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function getAllLearningDetails($clientid, $empid, $val, $module) {

        /*         * **************************************
          $module  = 1
          we consider flag value 1  for display data in web view of application

         * *** */
        $this->idclient = $clientid;
        $this->employeeId = $empid;
        $this->value = $val;

        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $this->employeeId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            if (count($rows) > 0) {
                $group_object = new FindGroup();    // this is object to find group id of given unique id 
                $getgroup = $group_object->groupBaseofUid($clientid, $empid);
                $value = json_decode($getgroup, true);
                //print_r($value);
                /*                 * *********************************************************************************************** */

                $count_group = count($value['groups']);
                //echo "total group of empid =: ".$count_group."<br/>";
                if ($count_group <= 0) {
                    $response["success"] = 0;
                    $response["message"] = "Sorry You are Not in Any Group";
                } else {
                    $in = implode("', '", array_unique($value['groups']));
                    //echo "group array : ".$in."<br/>";

                    /**                     * ************************************************************************************************ */
                    $query21 = "select count(distinct(emplearningId)) as total_emplearningId from Tbl_Analytic_LearningSentToGroup where clientId=:cli and groupId IN ('" . $in . "')";
                    $stmt21 = $this->DB->prepare($query21);
                    $stmt21->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    // $stmt2->bindParam(':uid',$uuids, PDO::PARAM_STR);
                    $stmt21->execute();
                    $rows2 = $stmt21->fetch(PDO::FETCH_ASSOC);

                    if ($module == 1) {
                        $noticequery = "select distinct(emplearningId) as emplearningId from Tbl_Analytic_LearningSentToGroup where groupId IN('" . $in . "') and clientId =:cid order by autoId desc limit 5";
                    } else {
                        $noticequery = "select distinct(emplearningId) as emplearningId from Tbl_Analytic_LearningSentToGroup where groupId IN('" . $in . "') and clientId =:cid order by autoId desc ";
//                        . limit $this->value . ",5";
                    }

                    $nstmt = $this->DB->prepare($noticequery);
                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                    $nstmt->execute();
                    $lrows1 = $nstmt->fetchAll(PDO::FETCH_ASSOC);

                    //print_r($noticerows);

                    $response["total_learning"] = $rows2["total_emplearningId"];

                    $response['learning'] = array();
                    $status = "Publish";

                    if (count($lrows1) > 0) {
                        $site_url = site_url;
                        $response["success"] = 1;
                        $response["message"] = "Learning data available for you";
                        foreach ($lrows1 as $learnrows) {
                            $emplearnid = $learnrows['emplearningId'];
                            $query2 = "SELECT DATE_FORMAT(et.trainingDate, '%d %b %Y' ) AS trainingDate, et.clientId,et.createdBy, et.empTrainingId,tem.firstName, tem.middleName, tem.lastName, if(epd.userImage IS NULL or epd.userImage = '','',concat('$site_url', epd.userImage )) AS userImages, tm.trainingName
								FROM Tbl_EmployeeTraining AS et
								JOIN Tbl_EmployeeDetails_Master AS tem ON tem.autoId = et.employeeId
								JOIN Tbl_EmployeePersonalDetails AS epd ON tem.employeeId = epd.employeeId
								JOIN Tbl_TrainingMaster AS tm ON tm.trainingId = et.trainingId
								WHERE et.empTrainingId = :nid
								AND et.clientId = :cli";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                            $stmt2->bindParam(':nid', $emplearnid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $rows = $stmt2->fetch(PDO::FETCH_ASSOC);

                            $post["clientId"] = $rows["clientId"];
                            $post["empTrainingId"] = $rows["empTrainingId"];
                            $post["userImages"] = $rows["userImages"];
                            $post["firstName"] = $rows["firstName"];
                            $post["middleName"] = $rows["middleName"];
                            $post["lastName"] = $rows["lastName"];
                            $post["trainingName"] = $rows["trainingName"];
                            $post["createdBy"] = $rows["createdBy"];
                            $post["trainingDate"] = $rows["trainingDate"];
                            //$post["status"] = $rows["status"];

                            array_push($response["learning"], $post);
                        }
                    } else {
                        $response['success'] = 0;
                        $response['msg'] = "Currently no more data available";
                    }
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "You are not authorized user please check youe employee code";
            }
        } catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = "there is some error" . $e;
        }
        return json_encode($response);
    }

    /*     * *********************************************************************************************************** */
}

?>