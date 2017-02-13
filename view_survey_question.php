<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_HappinesQuestion.php');
session_start();

require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$poll_obj = new HappinessQuestion();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
    
$result = $poll_obj->SurveyDetails($clientid,$user_uniqueid,$user_type);
$getcat = json_decode($result,true);
//echo "<pre>";
//print_r($getcat);
$value = $getcat['posts'];
$count = count($value);

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
echo "<script>window.location='view_survey_question.php'</script>";
}

}

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
                                   <!-- <div style="float:top; margin-top:13px; font-size:20px;"> 
                                    <a href="create_poll.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New Feedback</button>
                                    </a>
                                     </div>--->
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Survey Id</th>
                                                
                                                <th>Survey Question</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <th><center>Action</center></th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>Survey Id</th>
                                                
                                                <th>Survey Question</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                     for($i=0; $i<$count; $i++)
                                       {
if($value[$i]['status']== 1)
{
$sta = "Unpublish";
$gly = "glyphicon glyphicon-eye-close";
$dis = "";
$status="Live";
}
else
{
$sta = "Unpublish";
$gly = "glyphicon glyphicon-eye-open";
$dis = "disabled";
$status="Expire";
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
if(strlen($value[$i]['question'])>50)
{
echo substr($value[$i]['question'],0,50)."<b>...</b>";
}
else
{
echo $value[$i]['question'];
} ?></td>
                                             <td class="padding_right_px"><?php
                                               $uid = $value[$i]['createdBy'];
                                            //   echo $uid;
                                              $na = $gt->getUserData($clientid,$uid);
                                            //  echo $na;
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                              ?></td>
                                             <td class="padding_right_px"><?php echo $value[$i]['startDate']; ?></td> 
                                             <td class="padding_right_px"><?php echo $value[$i]['expiryDate']; ?></td>
                                             <td class="padding_right_px"><?php echo $status;  ?></td>
<td>

    <a href="view_survey_question.php?ques_id=<?php echo $value[$i]['questionId'];?>&status=<?php echo $status; ?>">
<button style="background-color:#fff;color:red" type="button" onclick="return confirm( 'Are you sure you want to unpublish this Survey Question?');" class="btn btn-sm" <?php echo $dis .">".$sta; ?></span></button></a>

<a href="view_survey_result.php?qid=<?php echo $value[$i]['questionId']; ?>&clientid=<?php echo $value[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Result</a> 

<a href="view_survey_respondent.php?qid=<?php echo $value[$i]['questionId']; ?>&clientid=<?php echo $value[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Respondent</a> 

<!--<a href="view_survey_result1.php?qid=<?php echo $value[$i]['questionId']; ?>&clientid=<?php echo $value[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Result</a>   --->

 </td>
                                               
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