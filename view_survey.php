<?php
include 'navigationbar.php';
include 'leftSideSlide.php';

require_once('Class_Library/class_HappinesQuestion.php');
require_once('Class_Library/class_get_useruniqueid.php');

$gt = new UserUniqueId();
$poll_obj = new HappinessQuestion();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $poll_obj->SurveyDetails($clientid, $user_uniqueid, $user_type);
$getcat = json_decode($result, true);

$value = "";
$count = "";
if ($getcat['success'] == 1) {
    $value = $getcat['posts'];
    $count = count($value);
}
if (isset($_GET['sid']) && isset($_GET['status'])) {
    $idpoll = $_GET['sid'];
    $status = $_GET['status'];

    if ($status == 'Live') {
        $status1 = 0;
    }
    $result = $poll_obj->updateSurveyStatus($idpoll, $status1);
    $output = json_decode($result, true);
//    echo "<pr>";print_r($output);echo "</pre>";
    $value = $output['success'];
    $message = $output['message'];

    if ($value == 1) {
        echo "<script>alert('$message')</script>";
        echo "<script>window.location='view_survey.php'</script>";
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
                                <div class="title">All Survey Details</div>
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
                                        <th>Survey Title</th>
                                        <th>No. of Question</th>
                                        <th>Created by</th>
                                        <th>Publish Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Response Count</th>
                                        <th><center>Action</center></th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Survey Id</th>
                                        <th>Survey Title</th>
                                        <th>No. of Question</th>
                                        <th>Created by</th>
                                        <th>Publish Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Response Count</th>
                                        <th><center>Action</center></th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $count; $i++) {
                                        if ($value[$i]['status'] == 1) {
                                            $sta = "Close";
                                            $gly = "glyphicon glyphicon-eye-close";
                                            $dis = "";
                                            $status = "Live";
                                        } else {
                                            $sta = "";
                                            $gly = "glyphicon glyphicon-eye-open";
                                            $dis = "disabled";
                                            $status = "Expired";
                                        }


                                        $surveyid = $value[$i]['surveyId'];

                                        /* if($imagevalue!="")
                                          {$valueimage = $imagevalue; }
                                          else
                                          {$valueimage = "Poll/poll_img/dummy.png";} */
                                        ?>       	
                                        <tr>
                                            <td>

                                                <?php echo $surveyid; ?>
                                            </td>
                                            <td class="padding_right_px"><?php
                                                if (strlen($value[$i]['surveyTitle']) > 50) {
                                                    echo substr($value[$i]['surveyTitle'], 0, 50) . "<b>...</b>";
                                                } else {
                                                    echo $value[$i]['surveyTitle'];
                                                }
                                                ?>
                                            </td>
                                            <td class="padding_right_px">
                                                <?php echo $value[$i]['quesno']; ?>
                                            </td> 
                                            <td class="padding_right_px"><?php
                                                $uid = $value[$i]['createdby'];
                                                //   echo $uid;
                                                $na = $gt->getUserData($clientid, $uid);
                                                //  echo $na;
                                                $name = json_decode($na, true);
                                                echo $name[0]['firstName'] . " " . $name[0]['lastName'];
                                                ?>
                                            </td>
                                            <td class="padding_right_px">
                                                <?php echo $value[$i]['startDate']; ?>
                                            </td> 
                                            <td class="padding_right_px">
                                                <?php echo $value[$i]['expiryDate']; ?>
                                            </td>
                                            <td class="padding_right_px">
                                                <?php echo $status; ?>
                                            </td>
                                            <td class="padding_right_px">
                                                <?php echo $getcat['responseCount'][$i]['responseCount']; ?>
                                            </td> 
                                            <td>

                                                <a href="view_survey.php?sid=<?php echo $value[$i]['surveyId']; ?>&status=<?php echo $status; ?>">
                                                    <button style="background-color:#fff;color:red" type="button" onclick="return confirm('Are you sure you want to unpublish this Survey Question?');" class="btn btn-sm" <?php echo $dis . ">" . $sta; ?></span></button></a>

                                                    <!--<a href="view_survey_result.php?qid=<?php echo $value[$i]['surveyId']; ?>&clientid=<?php echo $value[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Result</a>-->

                                                <a href="view_survey_question.php?cid=<?php echo $value[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;" target="_blank"> View </a> 

                                                <a onClick="javascript:if (confirm('Are you sure want to Send Reminder?')) {
                                                            return true;
                                                        } else {
                                                            return false
                                                        }" href="Link_Library/linkSendReminder.php?idpost=<?php echo $surveyid; ?>">
                                                    <button type="button"class="btn btn-xs  btn-success" <?php echo $dis; ?>><span class="glyphicon glyphicon-send"></span> Send Reminder
                                                    </button>
                                                </a> 


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
