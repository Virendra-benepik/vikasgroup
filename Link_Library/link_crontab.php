<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once('../Class_Library/class_crontab.php');
require_once('../Class_Library/class_push_notification.php');

$db = new Cronjob();
 $push = new PushNotification();


/************************************** Publish Noticen ********************************/
 
 $result = $db->publishNotice();
//echo $result;
$res = json_decode($result, true);
//echo "<pre>";
//print_r($res);
//echo "<pre>";
 
$countnotice = count($res["noticedetails"]);
//echo "count details-".$countnotice;
if($res["success"] ==1)
{
for($rt=0;$rt<$countnotice;$rt++)
{
    $noticedata = $res["noticedetails"][$rt]["noticedata"];
    $maxid = $res["noticedetails"][$rt]["noticedata"]["noticeId"];
    $title = $res["noticedetails"][$rt]["noticedata"]["noticeTitle"];
    $pagename = $res["noticedetails"][$rt]["noticedata"]["fileName"];
    $createdby = $res["noticedetails"][$rt]["noticedata"]["createdBy"];
    $ptime1 = $res["noticedetails"][$rt]["noticedata"]["publishingTime"];
    $utime1 = $res["noticedetails"][$rt]["noticedata"]["unpublishingTime"];
    
    $clientid = $res["noticedetails"][$rt]["noticedata"]["clientId"];
   
    $FLAG = 7;
    $flag_name = "Notice : ";
    $post_date = "";
    
    $alluserid =  $res["noticedetails"][$rt]["userdata"];
     /***** get all registration token  for sending push **************** */
    $reg_token = $push->getGCMDetails($alluserid, $clientid);
    $token1 = json_decode($reg_token, true);
   /* echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>";
*/
    
	/************************************** end user group *****************************/
    $googleapiIOSPem = $push->getKeysPem($clientid);
    /*     * ************************************************************************************ */
    
    
    $hrimg = '';
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


	$data = array('Id' =>$maxid,'Title' => $title,'Content' => SITE_URL.$pagename, 'SendBy'=> $createdby, 'Picture'=> $hrimg, 'Publishing_time'=>$ptime1,'Unpublishing_time'=>$utime1,'Date' => $post_date, 'flag'=>$FLAG,'flagValue'=>$flag_name,'success'=>$sf);

	$IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
	$revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
	$rt = json_decode($revert, true);
	$iosrt = json_decode($IOSrevert, true);
        //print_r($iosrt);
       // print_r($rt);
}
}


/****************************** End of notice *********************************/

/*********************************** publish survey ****************************************/

$result = $db->publishSurvey();
//echo $result;
$res = json_decode($result, true);
echo "<pre>";
print_r($res);
echo "<pre>";
//$countnotice = count($res["surveydetails"]);
//echo "count details-".$countnotice;
die;
if($res["success"] ==1)
{
for($rt=0;$rt<$countnotice;$rt++)
{
    $noticedata = $res["noticedetails"][$rt]["noticedata"];
    $maxid = $res["noticedetails"][$rt]["noticedata"]["noticeId"];
    $title = $res["noticedetails"][$rt]["noticedata"]["noticeTitle"];
    $pagename = $res["noticedetails"][$rt]["noticedata"]["fileName"];
    $createdby = $res["noticedetails"][$rt]["noticedata"]["createdBy"];
    $ptime1 = $res["noticedetails"][$rt]["noticedata"]["publishingTime"];
    $utime1 = $res["noticedetails"][$rt]["noticedata"]["unpublishingTime"];
    
    $clientid = $res["noticedetails"][$rt]["noticedata"]["clientId"];
   
    $FLAG = 7;
    $flag_name = "Notice : ";
    $post_date = "";
    
    $alluserid =  $res["noticedetails"][$rt]["userdata"];
     /***** get all registration token  for sending push **************** */
    $reg_token = $push->getGCMDetails($alluserid, $clientid);
    $token1 = json_decode($reg_token, true);
   /* echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>";
*/
    
	/************************************** end user group *****************************/
    $googleapiIOSPem = $push->getKeysPem($clientid);
    /*     * ************************************************************************************ */
    
    
    $hrimg = '';
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


	$data = array('Id' =>$maxid,'Title' => $title,'Content' => SITE_URL.$pagename, 'SendBy'=> $createdby, 'Picture'=> $hrimg, 'Publishing_time'=>$ptime1,'Unpublishing_time'=>$utime1,'Date' => $post_date, 'flag'=>$FLAG,'flagValue'=>$flag_name,'success'=>$sf);

	$IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
	$revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
	$rt = json_decode($revert, true);
	$iosrt = json_decode($IOSrevert, true);
        print_r($iosrt);
        print_r($rt);
}
}

?>