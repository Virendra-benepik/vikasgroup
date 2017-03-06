<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('../../Class_Library/class_push_notification.php');
require_once('../../Class_Library/class_post.php');
require_once('../../Class_Library/Api_Class/class_comment.php');
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
//echo json_encode($response);
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$jsonArr = json_decode(file_get_contents("php://input"), true);
/*{
	"clientid":"CO-24",
	"post_id":"Post-3",
	"employeeid":"bllQIibhNzypMGlEtwU8Bn5JpbdHdp",
	"message":"hello nice comment",
	"flag":"1"
	"device":"IOS"
}*/
if (!empty($jsonArr['clientid'])) {
    $comment = new Comment();
    $push = new PushNotification();
    $obj = new Post();                                        // object of class post page

    extract($jsonArr);

    $userimage = $push->getImage($jsonArr['employeeid']);
    $image = $userimage[0]['userImage'];

    $maxid = $obj->maxID();  //---------get latest post_id

    /** ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */

    $googleapiIOSPem = $push->getKeysPem($clientid);

    $createComment = $comment->create_Comment($clientid, $post_id, $employeeid, $message, $flag, $device);
    $myArray = $comment->getGroups($clientid, $post_id, $flag);
	//print_r($myArray);
    $POST_ID = $post_id;
    $POST_TITLE = "Comment";
    $POST_IMG = "";
    $POST_TEASER = "";
    $POST_CONTENT = substr($createComment['posts'][0]['firstname'] ." ". $createComment['posts'][0]['lastname'] . " commented " .'"'. $createComment['posts'][0]['content'], 0, 30) . '....."';
    $DATE = date('Y-m-d H:i:s A');
    $FLAG = $flag;
    $fullpath = '';
    $flag_name = "Comment : ";
    $BY = $createComment['posts'][0]['firstname'] . $createComment['posts'][0]['lastname'];
    /** ******************************************** like push selection start ***************************************** */
    $like = 'LIKE_YES';
    if (!isset($like) && $like != 'LIKE_YES') {
        $like = 'LIKE_NO';
        $like_val = 'No';
    } else {
        $like_val = 'Yes';
    }

    $comment = 'COMMENT_YES';
    if (!isset($comment) && $comment != 'COMMENT_YES') {
        $comment = 'COMMENT_NO';
        $comment_val = 'No';
    } else {
        $comment_val = 'Yes';
    }


    $User_Type = "Selected";
    /** ****************  fetch all user employee id from user detail start **************************** */
    $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
    $token = json_decode($gcm_value, true);

    /*     * *************************get group admin uuid  form group admin table if user type not= all *************************** */
    if ($User_Type != 'All') {
//echo "within not all user type".$User_Type."<br/>";
        $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
        $adminuuid = json_decode($groupadminuuid, true);
/*         echo "hello groupm admin id";
          echo "<pre>";
          print_r($adminuuid)."<br/>";
          echo "</pre>";
          echo "--------------all employee id---------"; */

        $allempid = array_merge($token, $adminuuid);
       /*  echo "<pre>";
          print_r($allempid);
          echo "<pre>";

          echo "--------------all unique employee id---------"; */

        $allempid1 = array_values(array_unique($allempid));
       /*  echo "user unique id";
          echo "<pre>";
          print_r($allempid1);
          echo "<pre>"; */
    } else {
//echo "within all user type".$User_Type."<br/>";
        $allempid1 = $token;
    }

	//print_r($allempid1);
	
    /*** ** get all registration token  for sending push **************** */
    $reg_token = $push->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
	//echo "regtoken";
	//print_r($token1);

    /** *******************Create file of user which this post send  start******************** */
    $val = array();
    foreach ($token1 as $row) {
        array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
    }

    $file = @fopen("../send_push_datafile/" . $maxid . ".csv", "w");

    foreach ($val as $line) {
        @fputcsv($file, @explode(',', $line));
    }
    @fclose($file);
    /*     * *******************Create file of user which this post send End******************** */

    $hrimg = ($image=='')?"":dirname(SITE_URL)."/" . $image;
    $sf = "successfully send";
    $ids = array();
    $idsIOS = array();

    foreach ($token1 as $row) {

        if ($row['deviceName'] == 'ios') {
            array_push($idsIOS, $row["registrationToken"]);
        } else {
            array_push($ids, $row["registrationToken"]);
        }
        //array_push($ids,$row["registrationToken"]);
    }

    $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath,'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);

	//print_r($data);
	
    //$IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile'], $device);
    //$revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

    //$rt = json_decode($revert, true);
    //$iosrt = json_decode($IOSrevert, true);
//print_r($rt);
//print_r($iosrt);
    $response = $createComment;
} else {
    $response['success'] = 0;
    $response['result'] = "Invalid json";
}
//header('Content-type: application/json');
echo json_encode($response);
?>
 
