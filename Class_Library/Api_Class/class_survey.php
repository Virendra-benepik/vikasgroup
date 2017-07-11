<?php

include_once('class_connect_db_Communication.php');
include_once('class_find_groupid.php');

class Survey {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function getSurveyQuestion($clientid, $uuid, $surveyId) {
        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //print_r($rows);

            if (count($rows) > 0) {

                /*                 * ************************** find group ******************** */
                $uuids = $rows[0]['employeeId'];
                //echo "employee id -".$uuids;
                $group_object = new FindGroup();    // this is object to find group id of given unique id 
                $getgroup = $group_object->groupBaseofUid($clientid, $uuids);
                $value = json_decode($getgroup, true);
                /* echo'<pre>';
                  print_r($value); */

                /*                 * ************************ end find group ****************** */
                if (count($value['groups']) > 0) {
                    $in = implode("', '", array_unique($value['groups']));


		    /*
                    $post = array();

                    $query3 = "select distinct(postId) from Tbl_Analytic_PostSentToGroup where clientId=:cli and status = 1 and flagType = 20 and groupId IN('" . $in . "') order by autoId desc";

                    $stmt3 = $this->DB->prepare($query3);
                    $stmt3->bindParam(':cli', $clientid, PDO::PARAM_STR);
                    $stmt3->execute();
                    $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
			
                    if (count($rows3) > 0) {
                        $postid = $rows3[0]["postId"];
		    */
		    
                        $query = "select * from Tbl_C_HappinessQuestion where clientId= :cid and status =1 and surveyId = :surveyid";
                        $nstmt = $this->DB->prepare($query);
                        $nstmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                        $nstmt->bindParam(':surveyid', $surveyId, PDO::PARAM_STR);
                        $nstmt->execute();
                        $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($welrows) > 0) {
                            $query1 = "select * from Tbl_Analytic_EmployeeHappiness where clientId=:cid1 and surveyId=:sid1 and useruniqueId=:uid1 and status = 1";
                            $nstmt1 = $this->DB->prepare($query1);
                            $nstmt1->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                            $nstmt1->bindParam(':sid1', $welrows[0]['surveyId'], PDO::PARAM_STR);
                            $nstmt1->bindParam(':uid1', $uuid, PDO::PARAM_STR);
                            $nstmt1->execute();
                            $welrows1 = $nstmt1->fetchAll(PDO::FETCH_ASSOC);
                            //echo count($welrows1);
                            if (count($welrows1) > 0) {
                                $response['surveysubmit'] = 1;
                                $response['msg'] = "Currently no survey is available";
                            } else {
                                $response['surveysubmit'] = 0;
                                $response['msg'] = "Successfully Display data";
                            }

                            $response['success'] = 1;
                            $response["posts"] = array();
                            $response['posts'] = $welrows;
                        } else {
                            $response['success'] = 0;
                            $response['msg'] = "Currently no survey is available";
                        }
                        /*
                    } else {

                        $response['success'] = 0;
                        $response['msg'] = "Currently no survey is available";
                    }
                    */
                } else {
                    $response['success'] = 0;
                    $response['msg'] = "You are not selected in any group";
                }
            } else {
                echo "sory ur not authorized user";
                $response['success'] = 0;
                $response['msg'] = "Sorry u r not authorized user";
            }
        } catch (PDOException $es) {
            $response['success'] = 0;
            $response['msg'] = "there is some error please contact info@benepik.com" . $es;
        }

        return $response;
    }

    function addSurveyAnswer($clientid, $employeeid, $surveyId, $noofquestion, $comment, $device, $ans) {
        date_default_timezone_set('Asia/Calcutta');
        $cd = date('Y-m-d H:i:s A');
        $flag = 20;
        $status = 1;
        // $ans1 =  json_decode($ans,true);
        // print_r($ans);

        $query1 = "select * from Tbl_Analytic_EmployeeHappiness where surveyId = :sid and useruniqueid = :uid";
        $nstmt1 = $this->DB->prepare($query1);
        $nstmt1->bindParam(':uid', $employeeid, PDO::PARAM_STR);
        $nstmt1->bindParam(':sid', $surveyId, PDO::PARAM_STR);
        // $nstmt->bindParam(':status', $status, PDO::PARAM_STR);
        $nstmt1->execute();
        $resp = $nstmt1->fetchAll(PDO::FETCH_ASSOC);
        //print_r($resp);
        if (count($resp) > 0) {
            $response['success'] = 0;
            $response['msg'] = "You already submitted this survey";
        } else {
            $quesno = count($ans);
            for ($i = 0; $i < $quesno; $i++) {
                $value = $ans[$i]['feedback_id'];
                $key = $ans[$i]['question_id'];

                if ($ans[$i]['feedback_id'] == 's1') {
                    $value = -5;
                } elseif ($value == 'a1') {
                    $value = 0;
                } elseif ($value == 'es1') {
                    $value = 10;
                } else {
                    $value = 5;
                }
                //   echo "this is quesid-".$key;
                //  echo "this is value - ".$value."\n";
                $query = "insert into Tbl_Analytic_EmployeeHappiness(clientId,surveyId,questionId,value,comment,"
                        . "useruniqueid,createdDate,flagetype,device,status)value(:cid,:sid,:qid,:ans,:cmnt,:uid,:dte,:flag,:device,:status)";
                $nstmt = $this->DB->prepare($query);
                $nstmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                $nstmt->bindParam(':sid', $surveyId, PDO::PARAM_STR);
                $nstmt->bindParam(':qid', $key, PDO::PARAM_STR);
                $nstmt->bindParam(':ans', $value, PDO::PARAM_STR);
                $nstmt->bindParam(':cmnt', $comment, PDO::PARAM_STR);
                $nstmt->bindParam(':uid', $employeeid, PDO::PARAM_STR);
                $nstmt->bindParam(':dte', $cd, PDO::PARAM_STR);
                $nstmt->bindParam(':flag', $flag, PDO::PARAM_STR);
                $nstmt->bindParam(':device', $device, PDO::PARAM_STR);
                $nstmt->bindParam(':status', $status, PDO::PARAM_STR);
                if ($nstmt->execute()) {
                    $res = 'True';
                }
            }
            $response['success'] = 1;
            $response['msg'] = "Survey submitted successfully";
        }
        return $response;
    }

    function getSurvey($clientid, $uuid, $val) {
        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            

            if (count($rows) > 0) {

                /*                 * ************************** find group ******************** */
                $uuids = $rows[0]['employeeId'];
                $group_object = new FindGroup();    // this is object to find group id of given unique id 
                $getgroup = $group_object->groupBaseofUid($clientid, $uuids);
                $value = json_decode($getgroup, true);
//		print_r($value);die;
                /*                 * ************************ end find group ****************** */
                if (count($value['groups']) > 0) {
                    $in = implode("', '", array_unique($value['groups']));

		    $query2 = "select distinct(surveyId) from Tbl_Analytic_EmployeeHappiness where clientId=:cli and status = 1 and flagetype = 20 and userUniqueId=:uid";
		    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
                    $stmt2->bindParam(':uid', $uuid, PDO::PARAM_STR);
                    $stmt2->execute();
                    $rows2 = $stmt2->fetchAll();

			//print_r($rows2);die;
			$arr = array();
			foreach($rows2 as $surveyIds){
			   array_push($arr, $surveyIds[0]);
			}
			
		       $inSurvey = implode(",", $arr);
	   	     
		       		
		    $query3 = "select distinct(postgroup.postId) from Tbl_Analytic_PostSentToGroup as postgroup JOIN Tbl_C_SurveyDetails as survey ON postgroup.postId = survey.surveyId where survey.expiryDate >= CURDATE() AND postgroup.clientId=:cli and postgroup.status = 1 and postgroup.flagType = 20 and postgroup.groupId IN('" . $in . "')";
		    
		    if(!empty($inSurvey) && ($inSurvey!='')){
			$query3 .= " and postgroup.postId NOT IN($inSurvey) ";
		    }
		    
		    $query3 .= "order by postgroup.autoId desc";
		    // "limit $val,8";
//echo ($query3);die;
                    $stmt3 = $this->DB->prepare($query3);
                    $stmt3->bindParam(':cli', $clientid, PDO::PARAM_STR);
                    $stmt3->execute();
                    $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

		    $query1 = "select count(distinct(postgroup.postId)) as total from Tbl_Analytic_PostSentToGroup as postgroup JOIN Tbl_C_SurveyDetails as survey ON postgroup.postId = survey.surveyId where survey.expiryDate >= CURDATE() AND postgroup.clientId=:cid and postgroup.status = 1 and postgroup.flagType = 20 and postgroup.groupId IN('" . $in . "')";
		    if(!empty($inSurvey) && ($inSurvey!='')){
			$query1 .= " and postgroup.postId NOT IN($inSurvey)";
		    }

	            $nstmt1 = $this->DB->prepare($query1);
	            $nstmt1->bindParam(':cid', $clientid, PDO::PARAM_STR);
	            $nstmt1->execute();
	            $total = $nstmt1->fetch(PDO::FETCH_ASSOC);
		        		
		    //print_r($rows3);die;
		    if (count($rows3) > 0) {
		        $surveyArr= array();
		        
		        
			foreach($rows3 as $surveyId){
			
		            $query = "select survey.*, if(datediff(survey.expiryDate, CURDATE()) = 0, 'Today is the last day', if(datediff(survey.expiryDate, CURDATE())=1, concat(datediff(survey.expiryDate, CURDATE()), ' day left'), concat(datediff(survey.expiryDate, CURDATE()), ' days left'))) as expiryDate from Tbl_C_SurveyDetails as survey where survey.expiryDate >= CURDATE() and survey.surveyId=:surveyId and survey.clientId= :cid and survey.status =1";
		            $nstmt = $this->DB->prepare($query);
		            $nstmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
		            $nstmt->bindParam(':surveyId', $surveyId['postId'], PDO::PARAM_STR);
		            $nstmt->execute();
		            $welrows = $nstmt->fetch(PDO::FETCH_ASSOC);
			
			    array_push($surveyArr,$welrows);
			}	
	    		    $response['success'] = 1;
			    $response['total_surveys'] = $total['total'];
			    $response['message'] = "Survey List";
			    $response['posts'] = $surveyArr;
		    }else{
			    $response['success'] = 0;
			    $response['total_surveys'] = $total['total'];
    			    $response['message'] = "No more surveys available";
		    }
                } else {
                    $response['success'] = 0;
                    $response['message'] = "You are not selected in any group";
                }
            } else {
                echo "sory ur not authorized user";
                $response['success'] = 0;
                $response['message'] = "Sorry u r not authorized user";
            }
        } catch (PDOException $es) {
            $response['success'] = 0;
            $response['message'] = "there is some error please contact info@benepik.com" . $es;
        }

        return $response;
    }
}
