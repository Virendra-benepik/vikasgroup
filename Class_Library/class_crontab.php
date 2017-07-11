<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//session_start();
include_once('class_connect_db_Communication.php');

class Cronjob {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

   
   function publishNotice()
   {
      date_default_timezone_set('Asia/Calcutta');
      $post_date = date('Y-m-d H:i:s');
      
      $timestamp = strtotime($post_date);
      $timestamp1hour = date("Y-m-d H:i:s", strtotime('+1 hours'));
    //  echo "current time-".$post_date."<br/>";
     //  echo "time with 1 hour".$timestamp1hour;
      $clientid = 'CO-27';
      try 
        {
           $query = "select noticeId from Tbl_C_NoticeDetails as tcn where tcn.status = 'Pending' and tcn.publishingTime between'".$post_date."'and '".$timestamp1hour."' and tcn.clientId = :cli";
      $stmt = $this->DB->prepare($query);
       $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($data);
      $noticecount = count($data);
      
       $response = array();
       $uid = '';
       if ($noticecount>0) { 
        
                 $response["success"] = 1;
                 $response["message"] = "successfully find data";
                 $response["noticedetails"] = array();
               
         for($k=0;$k<$noticecount;$k++)
           {
             $response1 = array();
               $noticeid = $data[$k]['noticeId'];
               
               /********************************************/
                $query = "select * from Tbl_C_NoticeDetails where noticeId =:nid and clientId = :cli";
      $stmt = $this->DB->prepare($query);
       $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
       $stmt->bindParam(':nid', $noticeid, PDO::PARAM_STR);
      $stmt->execute();
      $data1 = $stmt->fetch(PDO::FETCH_ASSOC);
       $response1["noticedata"] = $data1;
               /*********************************************/
               $response1["userdata"] = array();
               /*****************************************************/  
               $query1 = "select userUniqueId from Tbl_Analytic_NoticeSentTo where noticeId = :nid  and clientId = :cli";
      $stmt1 = $this->DB->prepare($query1);
       $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
       $stmt1->bindParam(':nid', $noticeid, PDO::PARAM_STR);
      $stmt1->execute();
      $uid = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                   foreach($uid as $userid)
                   {
                        $uid1 = $userid['userUniqueId'];
                       
                         array_push($response1["userdata"],$uid1);
                   }
               /*******************************************************/
           
               
               $status = 'Live';
               $status1 = 1;
               /*************************  tbl_C_Details update *********************/
               $qu = "update Tbl_C_NoticeDetails set status=:sts where clientId = :cli and noticeId=:nid";
            $stmt1 = $this->DB->prepare($qu);
            $stmt1->bindParam(':nid', $noticeid, PDO::PARAM_STR);
            $stmt1->bindParam(':sts', $status, PDO::PARAM_STR);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
               $stmt1->execute();
                /*************************  *********************/
               
                /*************************  Tbl_Analytic_NpticeSentToGroup update *********************/
               $qu1 = "update Tbl_Analytic_NoticeSentToGroup set status=:sts1 where clientId = :cli and noticeId=:nid";
            $stmt2 = $this->DB->prepare($qu1);
            $stmt2->bindParam(':nid', $noticeid, PDO::PARAM_STR);
            $stmt2->bindParam(':sts1', $status1, PDO::PARAM_STR);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
               $stmt2->execute();
                /*************************  *********************/
               
                /************************* Tbl_C_WelcomeDetails update *********************/
               $qu2 = "update Tbl_C_WelcomeDetails set status=:sts1 where clientId = :cli and id=:nid";
            $stmt2 = $this->DB->prepare($qu2);
            $stmt2->bindParam(':nid', $noticeid, PDO::PARAM_STR);
            $stmt2->bindParam(':sts1', $status1, PDO::PARAM_STR);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
               $stmt2->execute();
                /*************************  *********************/
                  
                  
                    array_push($response["noticedetails"],$response1);
                    
           }
          
            }
            else
            {
             
                  $response["success"] = 0;
                $response["message"] = "data not found";
                $response["noticedetails"] = array();
               
                
            }
        } catch (Exception $ex) {
                 $response["success"] = 0;
                 $response["message"] = "data not found".$ex;
               $response["noticedetails"] = array();
      }
     
       return json_encode($response);
      
   }

   
   /*******************************************************************************************/
   
   
   function publishSurvey()
   {
      date_default_timezone_set('Asia/Calcutta');
      $post_date = date('Y-m-d H:i:s');
      
      $timestamp = strtotime($post_date);
      $timestamp1hour = date("Y-m-d H:i:s", strtotime('+1 hours'));
      echo "current time-".$post_date."<br/>";
       echo "time with 1 hour".$timestamp1hour;
      $clientid = 'CO-27';
      try 
        {
           $surveyquery = "select surveyId from Tbl_C_SurveyDetails as tcs where tcs.status = 2 and tcs.startDate between'".$post_date."'and '".$timestamp1hour."' and tcs.clientId = :cli";
      $stmt = $this->DB->prepare($surveyquery);
       $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
     print_r($data);
      $surveycount = count($data);
      
       $response = array();
       $uid = '';
       if ($surveycount>0) { 
        
                 $response["success"] = 1;
                 $response["message"] = "successfully find data";
                 $response["surveydetails"] = array();
               
         for($k=0;$k<$noticecount;$k++)
           {
             $response1 = array();
               $surveyid = $data[$k]['surveyId'];
               
               /********************************************/
                $query = "select * from Tbl_C_SurveyDetails where surveyId =:sid and clientId = :cli";
      $stmt = $this->DB->prepare($query);
       $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
       $stmt->bindParam(':sid', $surveyid, PDO::PARAM_STR);
      $stmt->execute();
      $data1 = $stmt->fetch(PDO::FETCH_ASSOC);
       $response1["sureydata"] = $data1;
               /*********************************************/
               $response1["userdata"] = array();
               /*****************************************************/  
               $query1 = "select userUniqueId from Tbl_Analytic_PostSentTo where postId = :sid  and clientId = :cli and flagType=20";
      $stmt1 = $this->DB->prepare($query1);
       $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
       $stmt1->bindParam(':sid', $surveyid, PDO::PARAM_STR);
      $stmt1->execute();
      $uid = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                   foreach($uid as $userid)
                   {
                        $uid1 = $userid['userUniqueId'];
                       
                         array_push($response1["userdata"],$uid1);
                   }
               /*******************************************************/
           
               
               $status = 'Live';
               $status1 = 1;
               /*************************  tbl_C_Details update *********************/
               $qu = "update Tbl_C_SurveyDetails set status=:sts where clientId = :cli and surveyId=:sid";
            $stmt1 = $this->DB->prepare($qu);
            $stmt1->bindParam(':sid', $surveyid, PDO::PARAM_STR);
            $stmt1->bindParam(':sts', $status1, PDO::PARAM_STR);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
               $stmt1->execute();
                /*************************  *********************/
               
                /*************************  Tbl_Analytic_NpticeSentToGroup update *********************/
               $qu1 = "update Tbl_Analytic_PostSentToGroup set status=:sts1 where clientId = :cli and postId=:sid and flagType = 20";
            $stmt2 = $this->DB->prepare($qu1);
            $stmt2->bindParam(':sid', $surveyid, PDO::PARAM_STR);
            $stmt2->bindParam(':sts1', $status1, PDO::PARAM_STR);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
               $stmt2->execute();
                /*************************  *********************/
              
                    array_push($response["noticedetails"],$response1);
                    
           }
          
            }
            else
            {
             
                  $response["success"] = 0;
                $response["message"] = "data not found";
                $response["surveydetails"] = array();
               
                
            }
        } catch (Exception $ex) {
                 $response["success"] = 0;
                 $response["message"] = "data not found".$ex;
               $response["surveydetails"] = array();
      }
     
       return json_encode($response);
      
   }


}

?>