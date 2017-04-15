<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_HappinesQuestion.php');
require_once('../Class_Library/class_push_notification.php');
//include_once('../Class_Library/class_get_group.php');  // for getting all group
//require_once('../Class_Library/class_reading.php');
//require_once('../Class_Library/class_welcomeTable.php');

$survey_obj = new HappinessQuestion();

$push_obj = new PushNotification();
//$welcome_obj = new WelcomePage();
date_default_timezone_set('Asia/Calcutta');
$post_date = date("Y-m-d H:i:s A");
  
if (!empty($_GET['idpost'])) {
    /**     * **************** check poll image and poll question exist or not ************************* */
    $FLAG = 20;
    //  $dev = $_POST['device'];
    $flag_name = "Survey : ";
    //  $USERID = $_POST['useruniqueid'];
    $POST_TITLE = "";
    $username = $_SESSION['user_name'];
    $clientid = $_SESSION['client_id'];
    $createdby = $_SESSION['user_unique_id'];
    //    $surveytitle = $_POST['surveytitle'];
    //  $enableComment = $_POST['surveychoice'];
    //  $ptime1 = $_POST['publish_date1'];
    //   $utime1 = $_POST['publish_date2'];
      
    $surveyId = $_GET['idpost'];

    $countsurvey = $survey_obj->getSurveyReminderUser($clientid, $surveyId);
     $allempid1 = json_decode($countsurvey, true);
     //echo "<pre>";
     //print_r($allempid1);
     $reg_token = $push_obj->getGCMDetails($allempid1['data'], $clientid);
    
    $token1 = json_decode($reg_token, true);
    
  /* echo "<pre>";
   print_r($token1);
   echo "</pre>";
  */ 
    $val[] = array();
    foreach ($token1 as $row) {
        array_push($val, $row["userUniqueId"] . ",".$row["registrationToken"]);
    }
     /*         * *********************************** Get GoogleAPIKey and IOSPEM file ********************************* */
    $content = "Fill-out ".$allempid1['survey']['surveyTitle'];
        $googleapiIOSPem = $push_obj->getKeysPem($clientid);
$PUSH_NOTIFICATION = 'PUSH_YES';
      
        /*         * *******************check push notificaticon enabale or disable******************** */
        if ($PUSH_NOTIFICATION == 'PUSH_YES') {
            $fullpath = '';
            $hrimg = SITE_URL . $_SESSION['image_name'];
//echo "hr image:-".$hrimg;
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();
            foreach ($token1 as $row) {

                if ($row['deviceName'] == 3) {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
            }

            // $content = str_replace("\r\n", "", strip_tags($ques));
            $data = array('Id' => $surveyId, 'Title' => $content, 'Content' => $content, 'SendBy' => $username, 'image' => $fullpath, 'Picture' => $hrimg, 'Date' => $post_date,
               'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);

            //print_r($data);

            $IOSrevert = $push_obj->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
            $revert = $push_obj->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
            $rt = json_decode($revert, true);
           
            if ($rt['success'] == 1)    {

                echo "<script>alert('Survey Reminder Send Successfully');</script>";
                echo "<script>window.location='../view_survey.php'</script>";
            } else {
                echo "<script>alert('Some problem');</script>";
                echo "<script>window.location='../view_survey.php'</script>";
            }
        
    }
} else {
    echo "survey id not found";
}
?>