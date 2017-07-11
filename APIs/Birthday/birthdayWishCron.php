<?php

error_reporting(0);
//ini_set('display_errors','1');

$project = "/Benepik_testing/vikasgroup/";

$_SERVER['SERVER_NAME'] = "52.66.130.250";
define('SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] . $project);

require_once('/var/www/html/'.$project.'/Class_Library/class_push_notification.php');
require_once('/var/www/html/'.$project.'/Class_Library/Api_Class/class_wish.php');
$obj = new wish();
$push = new PushNotification();            // class_push_notification.php

$client_id = "CO-27";
$BY = "Vikas Live";
$fullpath = SITE_URL . "images/push_wish_images/birthday.jpg";
$flag_name = "Wish : ";
$FLAG = 19;
$sf = "successfully send";
$ptime = "";
$utime = "";
$hrimg = "";
$device = "device";
$DATE = "";
$POST_ID = date('h:i:s', time());
$POST_CONTENT = "Birthday wish from Admin";

$response = $obj->getTodaysBirthdays($client_id);
$IDS = array();
$ids = array();
$idsIOS = array();
if ($response['success'] == 1) {
    $googleapiIOSPem = $push->getKeysPem($client_id);
    foreach ($response['Data'] as $row) { 
        $POST_TITLE = "Happy Birthday " . $row['username'];
        $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);
        
        if ($row['deviceName'] == 3) {
        	$data['device_token'] = $row['registrationToken'];
		$IOSrevert = $push->sendAPNSPushCron($data, $googleapiIOSPem['iosPemfile'], $device);
        } else {
	        $data['device_token'] = $row['registrationToken'];
		$revert = $push->sendGoogleCloudMessageCron($data, $googleapiIOSPem['googleApiKey']);
        }	
    }

} else {
    $data['success'] = 0;
    $data['message'] = "No Birthday today";
}

//header('Content-type: application/json');
//echo json_encode($data);
?>
    
