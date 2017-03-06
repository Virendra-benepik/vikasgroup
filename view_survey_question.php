<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<?php
require_once('Class_Library/class_HappinesQuestion.php');
//session_start();

require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$poll_obj = new HappinessQuestion();
//$clientid = $_SESSION['client_id'];
//$user_uniqueid = $_SESSION['user_unique_id'];
//$user_type = $_SESSION['user_type'];

if (isset($_GET['sid']) && isset($_GET['cid'])) {
    $sid = $_GET['sid'];
    $cid = $_GET['cid'];
    $result = $poll_obj->SurveyquestionDetails($sid, $cid);
    $getcat = json_decode($result, true);
//echo "<pre>";
//print_r($getcat);
//echo "</pre>";
    $value2 = $getcat['posts'];
    $count2 = count($value2);
    $happycount = count($getcat['posts'][0]['happycount']);
}
if (isset($_GET['ques_id']) && isset($_GET['status'])) {
    $idpoll = $_GET['ques_id'];
    $status = $_GET['status'];

    if ($status == 'Live') {
        $status1 = 0;
    }
    $result = $poll_obj->updateSurveyStatus($idpoll, $status1);
    $output = json_decode($result, true);

    $value = $output['success'];
    $message = $output['message'];

    if ($value == 1) {
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

                                        <th>Survey Question</th>
                                       
                                          <th>  <img src="img/sad_icon.png" style="height:23px;width:23px;"/></th>
                                          <th> <img src="img/normal_icon.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                          <th>   <img src="img/happiness_icon.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                          <th>   <img src="img/smileyoutline.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                       
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Respondent</th>
                                        <th>Average</th>
                                        <th>Chart</th>
                                       
                                         <!--<th>Salary</th>-->
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>

                                        <th>Survey Question</th>
                                       
                                          <th>  <img src="img/sad_icon.png" style="height:23px;width:23px;"/></th>
                                          <th> <img src="img/normal_icon.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                          <th>   <img src="img/happiness_icon.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                          <th>   <img src="img/smileyoutline.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Respondent</th>
                                        <th>Average</th>
                                        <th>Chart</th>
                                       
                                         <!--<th>Salary</th>-->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                   
                                    for ($i = 0; $i < $count2; $i++) 
                                    {
                                        $surveyid = $value2[$i]['surveyId'];
                                        $qid = $value2[$i]['questionId'];
                                        
                                     /************************************************************************/
                                        $sad = -5;
                                        $happy = 5;
                                        $normal = 0;
                                        $ehappy = 10;
                                        $happy_avg = 0;
                                         $sadcount = $poll_obj->getSurveyCount($surveyid,$qid,$sad); 
                                         $happycount = $poll_obj->getSurveyCount($surveyid,$qid,$happy); 
                                         $normalcount = $poll_obj->getSurveyCount($surveyid,$qid,$normal); 
                                         $ehappycount = $poll_obj->getSurveyCount($surveyid,$qid,$ehappy); 
                                         
                                       $happy_avg1 =   $sadcount['surveycount'] * $sad;
                                       $happy_avg2 =   $normalcount['surveycount'] * $normal;
                                       $happy_avg3 =   $happycount['surveycount'] * $happy;
                                       $happy_avg4 =   $ehappycount['surveycount'] * $ehappy;
                                       
                                        $totalRespondent = ($sadcount['surveycount'] +$normalcount['surveycount']+ $happycount['surveycount']+$ehappycount['surveycount']);
                                        $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4)/4;
                                     //    print_r($ehappycount);
                                    //    echo "<br/>";
                                        /*****************************************************************/
                                        
                                        if ($value2[$i]['status'] == 1) {
                                            $sta = "Unpublish";
                                            $gly = "glyphicon glyphicon-eye-close";
                                            $dis = "";
                                            $status = "Live";
                                        } else {
                                            $sta = "Unpublish";
                                            $gly = "glyphicon glyphicon-eye-open";
                                            $dis = "disabled";
                                            $status = "Expire";
                                        }
                                        $surveyid = $value2[$i]['surveyId'];
                                        ?>       	
                                        <tr>

                                            <td class="padding_right_px"><?php
                                                if (strlen($value2[$i]['question']) > 50) {
                                                    echo substr($value2[$i]['question'], 0, 50) . "<b>...</b>";
                                                } else {
                                                    echo $value2[$i]['question'];
                                                }
                                                ?></td>
                                            <td><span style="font-size:23px;"><?php echo $sadcount['surveycount']; ?></span></td>
                                            <td> <span style="font-size:23px;"><?php echo $normalcount['surveycount']; ?></span></td>
                                            <td>  <span style="font-size:23px;margin-left:22%;"><?php echo $happycount['surveycount']; ?></span></td>
                                           <td> <span style="font-size:23px;margin-left:22%;"><?php echo  $ehappycount['surveycount']; ?></span></td>
                                                           <!--   <td class="padding_right_px"><?php
                                            $uid = $value2[$i]['createdBy'];
                                            //   echo $uid;
                                            $na = $gt->getUserData($clientid, $uid);
                                            //  echo $na;
                                            $name = json_decode($na, true);
                                            echo $name[0]['firstName'] . " " . $name[0]['lastName'];
                                            ?></td>--->
                                                             <!-- <td class="padding_right_px"><?php echo $value2[$i]['startDate']; ?></td> -->
                                            <td class="padding_right_px"><?php echo $value2[$i]['expiryDate']; ?></td>
                                            <td class="padding_right_px"><?php echo $status; ?></td>
                                            <td class="padding_right_px"><?php echo  $totalRespondent; ?></td>
                                            <td class="padding_right_px"><?php echo $happy_avg; ?></td>
                                            <td>

                                      <!--  <a href="view_survey_question.php?ques_id=<?php echo $value2[$i]['questionId']; ?>&status=<?php echo $status; ?>">
                                    <button style="background-color:#fff;color:red" type="button" onclick="return confirm( 'Are you sure you want to unpublish this Survey Question?');" class="btn btn-sm" <?php echo $dis . ">" . $sta; ?></span></button></a> -->

                                                <a href="view_survey_result.php?qid=<?php echo $value2[$i]['questionId']; ?>&clientid=<?php echo $value2[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" target="_blank" style="color:#00a4fd;margin-left:29px !important;">Result</a> 

                                             <!--   <a href="view_survey_respondent.php?qid=<?php echo $value2[$i]['questionId']; ?>&clientid=<?php echo $value2[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Respondent</a> --->

                                    <!--<a href="view_survey_result1.php?qid=<?php echo $value2[$i]['questionId']; ?>&clientid=<?php echo $value2[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Result</a>   --->

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
<?php include 'footer.php'; ?>