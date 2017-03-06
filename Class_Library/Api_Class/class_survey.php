<?php
include_once('class_connect_db_Communication.php');
class Survey {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }
    
function getSurveyQuestion($clientid,$uuid,$date)
{
     try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows)>0)
            {
            $query = "select * from Tbl_C_HappinessQuestion where startdate <= :dte and expiryDate > :dte and clientId= :cid and status =1"; 
            $nstmt = $this->DB->prepare($query);
                    $nstmt->bindParam(':cid',$clientid, PDO::PARAM_STR);
                    $nstmt->bindParam(':dte', $date, PDO::PARAM_STR);
                    $nstmt->execute();
                    $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                  
                   if(count($welrows)>0)
                   {
                    $query1 = "select * from Tbl_Analytic_EmployeeHappiness where clientId=:cid1 and surveyId=:sid1 and useruniqueId=:uid1";
                    $nstmt1 = $this->DB->prepare($query1);
                    $nstmt1->bindParam(':cid1',$clientid, PDO::PARAM_STR);
                    $nstmt1->bindParam(':sid1',$welrows[0]['surveyId'], PDO::PARAM_STR);
                    $nstmt1->bindParam(':uid1',$uuid, PDO::PARAM_STR);
                    $nstmt1->execute();
                    $welrows1 = $nstmt1->fetchAll(PDO::FETCH_ASSOC); 
                    //echo count($welrows1);
                    if(count($welrows1)>0)
                    {
                        $response['surveysubmit'] = 1;
                        $response['msg'] = "No survey available";
                    }
                    else{ 
                        $response['surveysubmit'] = 0;  
                        $response['msg'] = "Successfully Display data";
                    }
                 
                    $response['success'] = 1;   
                   
                    $response['posts'] = $welrows;
                   }
                   else
                   {
                        $response['success'] = 0;
                    $response['msg'] = "No survey available";
                   }
                   
             }
             else 
                 {
                 echo "sory ur not authorized user";
                    $response['success'] = 0;
                    $response['msg'] = "Sorry u r not authorized user";  
             }
     }
       catch (PDOException $es)
       {
           $response['success'] = 0;
                    $response['msg'] = "there is some error please contact info@benepik.com".$es;
       }
    
    return $response;
}

 function addSurveyAnswer($clientid, $employeeid, $surveyId,$noofquestion,$comment,$device,$ans)
 {
      date_default_timezone_set('Asia/Calcutta');
        $cd =  date('Y-m-d H:i:s A');
     $flag = 20;
             $status = 1;
    // $ans1 =  json_decode($ans,true);
    // print_r($ans);
     
     $query1 = "select * from Tbl_Analytic_EmployeeHappiness where surveyId = :sid and useruniqueid = :uid";
     $nstmt1 = $this->DB->prepare($query1);
                   $nstmt1->bindParam(':uid',$employeeid, PDO::PARAM_STR);
                     $nstmt1->bindParam(':sid',$surveyId, PDO::PARAM_STR);
                    // $nstmt->bindParam(':status', $status, PDO::PARAM_STR);
                      $nstmt1->execute();
                   $resp  =  $nstmt1->fetchAll(PDO::FETCH_ASSOC);
                    //print_r($resp);
                  if(count($resp)>0)
                  {
                       $response['success'] = 0;
                    $response['msg'] = "You already submitted this survey"; 
                  }
                  else
                  {
             $quesno = count($ans);
     for($i = 0; $i<$quesno; $i++)
     {
         $value = $ans[$i]['feedback_id'];
         $key = $ans[$i]['question_id'];
         
         if($ans[$i]['feedback_id'] == 's1')
             { 
             $value = -5;
             }
             elseif($value == 'a1')
             {
                 $value = 0;
             }
             elseif($value == 'es1')
             {
                 $value = 10;
             }
           else {
               $value = 5;
                  }
      //   echo "this is quesid-".$key;
       //  echo "this is value - ".$value."\n";
         $query = "insert into Tbl_Analytic_EmployeeHappiness(clientId,surveyId,questionId,value,comment,"
                 . "useruniqueid,createdDate,flagetype,device,status)value(:cid,:sid,:qid,:ans,:cmnt,:uid,:dte,:flag,:device,:status)";
           $nstmt = $this->DB->prepare($query);
                    $nstmt->bindParam(':cid',$clientid, PDO::PARAM_STR);
                     $nstmt->bindParam(':sid',$surveyId, PDO::PARAM_STR);
                      $nstmt->bindParam(':qid',$key, PDO::PARAM_STR);
                       $nstmt->bindParam(':ans',$value, PDO::PARAM_STR);
                        $nstmt->bindParam(':cmnt',$comment, PDO::PARAM_STR);
                         $nstmt->bindParam(':uid',$employeeid, PDO::PARAM_STR);
                    $nstmt->bindParam(':dte', $cd, PDO::PARAM_STR);
                    $nstmt->bindParam(':flag', $flag, PDO::PARAM_STR);
                    $nstmt->bindParam(':device', $device, PDO::PARAM_STR);
                    $nstmt->bindParam(':status', $status, PDO::PARAM_STR);
                   if($nstmt->execute())
                   {
                      $res = 'True';
                   }
     }
       $response['success'] = 1;
                    $response['msg'] = "Survey Successfully Submitted"; 
                  }
                    return $response;
    
 }

}
    