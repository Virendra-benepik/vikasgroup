<?php
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_jobpost.php');
require_once('../Class_Library/class_push_notification.php');

if (!empty($_GET)) {
    $obj = new JobPost();
    $read = new Reading();

    $pid = $_GET['jobid'];
    $pst = $_GET['poststatus'];
    $clientid = $_GET['client'];
    $User_Type = 'All';

    $server = SITE_URL;

    if ($pst == 2) {
        $pst1 = 2;
        $disapprove_reason = $_GET['reason'];
        $result = $obj->status_Job($pid, $pst1, $disapprove_reason);
        if ($result) {
            echo "<script>alert('Job has been Disapproved')</script>";
            echo "<script>window.location='" . $server . "view_jobs_directory.php'</script>";
        }
    } else {
        $pst2 = 1;
        $result = $obj->status_Job($pid, $pst2);

        $push = new PushNotification();                   // object of class push notification page

        /*         * **************************************** check like & comment start ********************** */
        $like = 'LIKE_YES';
        if (!isset($like) && $like != 'LIKE_YES') {
            $like = 'LIKE_NO';
            $like_val = 'like_no';
        } else {
            $like_val = 'like_yes';
        }
        $comment = 'COMMENT_YES';
        if (!isset($comment) && $comment != 'COMMENT_YES') {
            $comment = 'COMMENT_NO';
            $comment_val = 'comment_no';
        } else {
            $comment_val = 'comment_yes';
        }

        $push_noti = 'PUSH_YES';
        if (!isset($push_noti) && $push_noti != 'PUSH_YES') {
            $PUSH_NOTIFICATION = 'PUSH_NO';
        } else {
            $PUSH_NOTIFICATION = 'PUSH_YES';
        }

        /*         * **************************************** check like & comment end ********************** */
        $POST_ID = $pid;
        $POST_TITLE = "Job Approval";
        $POST_IMG = '';
        $POST_IMG_THUMB = '';
        $POST_CONTENT = "Posted Job has been approved";
        $DATE = date('Y-m-d H:i:s A');
        $FLAG = '15';
        $flag_name = "Job Post";
        $User_Type = "Selected";

        if ($User_Type == 'Selected') {
            $user1 = $_GET['selected_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
        } else {
            $User_Type = "All";
            $user1 = '';
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
        }

        /*         * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
        $googleapiIOSPem = $push->getKeysPem($clientid);
        /*         * ************************************************************************************ */
        $groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
            $result1 = $read->postSentToGroup($clientid, $pid, $myArray[$k], $FLAG);
        }

        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
        $token = json_decode($gcm_value, true);

        if ($User_Type != 'All') {
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
            $adminuuid = json_decode($groupadminuuid, true);
            $allempid = array_merge($token, $adminuuid);

            $allempid1 = array_values(array_unique($allempid));
        } else {
            $allempid1 = $token;
        }

        $total = count($allempid1);
        for ($i = 0; $i < $total; $i++) {
            $uuid = $allempid1[$i];
            if (!empty($uuid)) {
                $read->postSentTo($clientid, $pid, $uuid, $FLAG);
            } else {
                continue;
            }
        }
        /*         * *** get all registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($allempid1, $clientid);
        $token1 = json_decode($reg_token, true);

        /*         * *******************Create file of user which this post send  start******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = fopen("../send_push_datafile/" . $pid . ".csv", "w");

        foreach ($val as $line) {
            fputcsv($file, explode(',', $line));
        }
        fclose($file);

        /*         * *******************Create file of user which this post send End******************** */

        /*         * *******************check push notificaticon enabale or disable******************** */
        if ($PUSH_NOTIFICATION == 'PUSH_YES') {

            /*             * ******************* send push by  push notification******************** */

            $hrimg = '';
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();

            foreach ($token1 as $row) {

                if ($row['deviceName'] == 'ios') {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
            }

//            echo'<pre>';print_r($idsIOS);die;

            $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);

            $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
            $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

            $rt = json_decode($revert, true);
            $iosrt = json_decode($IOSrevert, true);

            if ($result) {
                echo "<script>alert('Job has been Approved')</script>";
                echo "<script>window.location='" . $server . "view_jobs_directory.php'</script>";
            }
        } else {
            echo "<script>alert('Job has been Approved');</script>";
            echo "<script>window.location='" . $server . "view_jobs_directory.php'</script>";
        }
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">


        <p>Post id:
            <label for="textfield"></label>
            <input type="text" name="post_id" id="textfield">
        </p>
        <p>Post status:
            <label for="textfield"></label>
            <input type="text" name="post_status" id="textfield">
        </p>

        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <?php
}
?>