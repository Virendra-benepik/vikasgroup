<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_HappinesQuestion.php');
//@session_start();

require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$survey_obj = new HappinessQuestion();

//$clientid = $_SESSION['client_id'];
//$user_uniqueid = $_SESSION['user_unique_id'];
//$user_type = $_SESSION['user_type'];
   
$questionid = $_GET['qid'];
$clientid = $_GET['clientid'];
$surveyId = $_GET['sid'];

//echo $questionid;
//echo $clientid;
//echo $surveyId;

$ques1 =  $survey_obj->getSurveyquestion($questionid,$clientid,$surveyId);
//echo $ques1;
$ques = json_decode($ques1, true);

$result = $survey_obj->getSurveyResponse($questionid,$clientid,$surveyId);
$getcat = json_decode($result,true);
//echo "<pre>";
//print_r($getcat['data']);
$value = $getcat['data'];
$count = count($value);

/*
if(isset($_GET['ques_id']) && isset($_GET['status']))
{
$idpoll = $_GET['ques_id'];
$status = $_GET['status'];

if($status == 'Live')
{
$status1 = 0; 
}
$result = $poll_obj->updateSurveyStatus($idpoll,$status1);
$output = json_decode($result,true);

$value = $output['success'];
$message = $output['message'];

if($value == 1)
{
echo "<script>alert('$message')</script>";
echo "<script>window.location='view_survey_respondent.php'</script>";
}

}  */

?>
                  <div class="container-fluid">
			<div class="addusertest">
			
	</div>
	              <div class="side-body">
                   <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title">Survey Question</div>
                                    </div>
                                   
                                </div>
                                

                                <div class="card-body">
                                      <div>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                           
<div class='col-md-12 col-xs-12 col-sm-12 col-lg-12' style="font-size:16px;">
    <p><?php echo $ques['question']; ?></p>

</div>
               
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Survey Id</th>                                               
                                               
                                                <th>Resondent</th>
                                                 <th>Response</th>
                                                <th>Date</th>                                             
                                               <!-- <th><center>Action</center></th>--->
                                               
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>Survey Id</th>                                               
                                               
                                                <th>Resondent</th>
                                                 <th>Response</th>
                                                <th>Date</th>                                              
                                               <!-- <th><center>Action</center></th> -->
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                     for($i=0; $i<$count; $i++)
                                       {
if($value[$i]['value']== 10)
{
$sta = "Unpublish";
$gly = "glyphicon glyphicon-eye-close";
$dis = "";
$response ="Happy";
}
else if($value[$i]['value']== -10)
{
$sta = "Unpublish";
$gly = "glyphicon glyphicon-eye-open";
$dis = "disabled";
$response ="Sad";
}
else
  {
  $response = "Average";
  }


$surveyid = $value[$i]['surveyId'];

/*if($imagevalue!="")
{$valueimage = $imagevalue; }
else
{$valueimage = "Poll/poll_img/dummy.png";}*/

                                     ?>       	
					      <tr>
                                              <td>
                                  
                                         <?php echo $surveyid ; ?>
                                              </td>
                                              
                                             <td class="padding_right_px"><?php
                                               $uid = $value[$i]['userUniqueId'];
                                            //   echo $uid;
                                              $na = $gt->getUserData($clientid,$uid);
                                             // echo $na;
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                              ?></td>
                                             <td class="padding_right_px"><?php echo $response; ?></td> 
                                          <td class="padding_right_px"><?php echo $value[$i]['createdDate']; ?></td>
                                                                                          
                                            </tr>
                                      
                                        <?php
                                        }
                                        ?>
                                          </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			</div>
				<?php include 'footer.php';?>