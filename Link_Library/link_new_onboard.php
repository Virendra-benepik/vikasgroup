<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_post.php');
require_once('../Class_Library/class_push_notification.php');

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s');


$obj = new Post();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
//$db = new Connection_Client();
$read = new Reading();

$maxid = $obj->maxID();  //---------get latest post_id

$target = '../images/post_img/';   // folder name for storing data
$folder = 'images/post_img/';      //folder name for add with image insert into table

/* * ******************************START HERE************************************************ */
//echo'<pre>';print_r($_POST);die;
if (!empty($_POST)) {

    $flag_value = $_POST['flag'];
    $flag_name = "Welcome Aboard : ";
    $dev = $_POST['device'];
    if (isset($_POST['news_post'])) {

        if ($dev == 'd1') {
            $USERID = $_POST['author'];
            $BY = $_POST['auth'];
            $clientid = $_POST['client'];
        }
        if ($dev == 'd2') {
            $USERID = $_POST['useruniqueid'];
            $googleapi = $_POST['googleapi'];
//echo "user id - ".$USERID;
            $BY = $_SESSION['user_name'];
            $clientid = $_SESSION['client_id'];
//echo $clientid;
        }
        $path = $_FILES['uploadimage']['name'];
        $pathtemp = $_FILES['uploadimage']['tmp_name'];
//echo $path;
        $path_name = $maxid . "-" . $path;

        $imagepath = $target . $path_name;

        $fullpath = SITE_URL . "images/post_img/" . $path_name;
//echo $fullpath;
        $obj->compress_image($pathtemp, $imagepath, 20);

        /*         * **************************************** check like & comment start ********************** */

        $like = $_POST['like'];
        if (!isset($like) && $like != 'LIKE_YES') {
            $like = 'LIKE_NO';
            $like_val = 'No';
        } else {
            $like_val = 'Yes';
        }

        $comment = $_POST['comment'];
        if (!isset($comment) && $comment != 'COMMENT_YES') {
            $comment = 'COMMENT_NO';
            $comment_val = 'No';
        } else {
            $comment_val = 'Yes';
        }


        $push_noti = $_POST['push'];
        if (!isset($push_noti) && $push_noti != 'PUSH_YES') {
            $PUSH_NOTIFICATION = 'PUSH_NO';
        } else {
            $PUSH_NOTIFICATION = 'PUSH_YES';
        }

        /*         * **************************************** check like & comment end ********************** */

        $POST_ID = $maxid;
        $POST_TITLE = $_POST['name'];
//echo "post title : ".$POST_TITLE."<br/>";
        $POST_IMG = $folder . $path_name;

        $about = $_POST['userabout'];
//echo "user about : ".$about."<br/>";
        $designation = $_POST['designation'];
        $doj = $_POST['doj'];
        $location = $_POST['location'];
//echo "MY LIFE : ".$POST_CONTENT1."<br/>";
        $drinks = $_POST['drinks'];
        $food = $_POST['food'];
//echo "MY AS USUAL WORK DAY : ".$POST_CONTENT2."<br/>";
        $my_project = $_POST['projectdone'];
//echo "PROJECT I HAVE DONE : ".$POST_CONTENT3."<br/>";
        $my_place = $_POST['placeiseen'];
//echo "PLACES I HAVE SEEN : ".$POST_CONTENT4."<br/>";
        $mypersonal = $_POST['mypersonal'];
//echo "MY PERSONAL LIFE : ".$POST_CONTENT5."<br/>";

        /*
          $POST_CONTENT = "#Benepik#about###".$about."<br>
          #Benepik#designation###".$designation."<br>
          #Benepik#doj###".$doj."<br>
          #Benepik#location###".$location."<br>
          #Benepik#drinks### ".$drinks."<br>
          #Benepik#food###".$food."<br>
          #Benepik#achievements###".$my_project."<br>
          #Benepik#placeseen###".$my_place."<br>
          #Benepik#interests###".$mypersonal;
         */


        $POST_CONTENT .=!empty($about) ? "#Benepik#about###" . $about . "<br>" : "#Benepik#about###";

        $POST_CONTENT .=!empty($designation) ? "#Benepik#designation###" . $designation . "<br>" : "#Benepik#designation###";

        $POST_CONTENT .=!empty($doj) ? "#Benepik#doj###" . $doj . "<br>" : "#Benepik#doj###";

        $POST_CONTENT .=!empty($location) ? "#Benepik#location###" . $location . "<br>" : "#Benepik#location###";

        $POST_CONTENT .=!empty($drinks) ? "#Benepik#drinks###" . $drinks . "<br>" : "#Benepik#drinks###";

        $POST_CONTENT .=!empty($food) ? "#Benepik#food###" . $food . "<br>" : "#Benepik#food###";

        $POST_CONTENT .=!empty($my_project) ? "#Benepik#achievements###" . $my_project . "<br>" : "#Benepik#achievements###";

        $POST_CONTENT .=!empty($my_place) ? "#Benepik#placeseen###" . $my_place . "<br>" : "#Benepik#placeseen###";

        $POST_CONTENT .=!empty($mypersonal) ? "#Benepik#interests###" . $mypersonal : "#Benepik#interests###";


//echo $POST_CONTENT;die;
        $DATE = $post_date;
        $FLAG = $flag_value;
        $User_Type = $_POST['user3'];

        if ($User_Type == 'Selected') {
            $user1 = $_POST['selected_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
            /*   echo "selected user"."<br/>";
              echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>"; */
        } else {
            // echo "all user"."<br/>";
            $User_Type = "Selected";
            //  echo "user type:-".$User_Type;
            $user1 = $_POST['all_user'];
            $user2 = rtrim($user1, ',');
            $myArray = explode(',', $user2);
            /* echo "<pre>";
              print_r($myArray)."<br/>";
              echo "</pre>"; */
        }


        /*         * *****************************************call pem file and google api keys***************************************** */
        $getpush_keys = $push->getKeysPem($clientid);
        $googleapikeys = $getpush_keys['googleApiKey'];
        $iospemfile = $getpush_keys['iosPemfile'];
        /*         * ********************************************** */

        /*         * ********************* insert into database *********************************************** */
$thumb_img = "";
$device = 1;
        $result = $obj->create_Post($clientid, $POST_ID, $POST_TITLE, $POST_IMG, $thumb_img, $about, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $like, $comment,$device);

        $type = 'Onboard';
        $result1 = $obj->createWelcomeData($clientid, $POST_ID, $type, $POST_TITLE, $POST_IMG, $DATE, $USERID, $FLAG);

        $groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
            $result1 = $read->postSentToGroup($clientid, $maxid, $myArray[$k], $FLAG);
//echo $result1;
        }

        /*         * ****************  fetch all user employee id from user detail start **************************** */
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $clientid);
        $token = json_decode($gcm_value, true);
        /* echo "hello user  id";
          echo "<pre>";
          print_r($token);
          echo "</pre>"; */


        /*         * *************************get group admin uuid  form group admin table if user type not= all *************************** */
        if ($User_Type != 'All') {
//echo "within not all user type".$User_Type."<br/>";
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
            $adminuuid = json_decode($groupadminuuid, true);
            /* echo "hello groupm admin id";
              echo "<pre>";
              print_r($adminuuid)."<br/>";
              echo "</pre>";
              echo "--------------all employee id---------"; */

            $allempid = array_merge($token, $adminuuid);
            /* echo "<pre>";
              print_r($allempid);
              echo "<pre>";

              echo "--------------all unique employee id---------"; */

            $allempid1 = array_values(array_unique($allempid));

            /* echo "user unique id";
              echo "<pre>";
              print_r($allempid1);
              echo "<pre>"; */
        } else {
//echo "within all user type".$User_Type."<br/>";
            $allempid1 = $token;
        }

        /*         * ******* insert into post sent to table for analytic sstart************ */

        $total = count($allempid1);
        for ($i = 0; $i < $total; $i++) {
            $uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
            if (!empty($uuid)) {
                $read->postSentTo($clientid, $maxid, $uuid, $FLAG);
            } else {
                continue;
            }
        }
        /*         * ******* insert into post sent to table for analytic sstart************ */

        /*         * *** get all registration token  for sending push **************** */
        $reg_token = $push->getGCMDetails($allempid1, $clientid);
        $token1 = json_decode($reg_token, true);
        /* echo "----regtoken------";
          echo "<pre>";
          print_r($token1);
          echo "<pre>"; */
        /*         * *******************Create file of user which this post send  start******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = fopen("../send_push_datafile/" . $maxid . ".csv", "w");

        foreach ($val as $line) {
            fputcsv($file, explode(',', $line));
        }
        fclose($file);

        /*         * *******************Create file of user which this post send End******************** */



        /*         * *******************check push notificaticon enabale or disable******************** */
        if ($PUSH_NOTIFICATION == 'PUSH_YES') {

            /*             * ******************* send push by  push notification******************** */

            $hrimg = SITE_URL . $_SESSION['image_name'];
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();

            foreach ($token1 as $row) {
                if ($row['deviceName'] == 3) {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
//array_push($ids,$row["registrationToken"]);
            }



            $data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $about, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);

            //echo '<pre>';print_r($ids);die;
            $device = "Panel";
            $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $getpush_keys['iosPemfile'],$device);
            $revert = $push->sendGoogleCloudMessage($data, $ids, $getpush_keys['googleApiKey']);
            $rt = json_decode($revert, true);

            if ($rt) {
                if ($dev == 'd1') {
                    echo "<script>alert('Post Successfully Send');</script>";
                    echo $rt;
                } else {
                    echo "<script>alert('Post Successfully Send');</script>";
//print_r($rt);
                    echo "<script>window.location='../create_onboard.php'</script>";
echo $revert;
                }
            }
        } else {
            echo "<script>alert('Post Successfully Send');</script>";
          //  echo "<script>window.location='../create_onboard.php'</script>";
        }


        /*         * **************************if condition 2 end**************************************************************** */
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="device" value="d1">
        <p> flag 1: fill all </p>
        <p> flag 2: fill only post content </p>
        <p> flag 3: fill only image and post content </p>
        <br/>
        <p>flag Value:
            <label for="textfield"></label>
            <select name="flag" id="textfield">
                <option selected>--select flag--</option>
                <option value='1'>1</option>

            </select>

        </p>
        <p>Post Title:
            <label for="textfield"></label>
            <input type="text" name="title" id="textfield">
        </p>
        <p>CLIENT
            <label for="textfield"></label>
            <input type="text" name="CLIENTID" id="textfield">
        </p>
        <p>Post image:
            <label for="textfield"></label>
            <input type="file" name="uploadimage" id="textfield">
        </p>
        <p>Post teaser:
            <label for="textfield"></label>
            <input type="text" name="teasertext" id="textfield">
        </p>
        <p>Post content:
            <label for="textfield"></label>
            <textarea name="content" id="textfield"></textarea>
        </p>
        <p> Author(Valid system generated  UU Id)<p>
            <label for="textfield"></label>
            <input type="Email" name="author" id="textfield">
        <p>
        <p>Client Id<p>
            <label for="textfield"></label>
            <input type="Email" name="client" id="textfield">
        <p>
        <p> Author name<p>
            <label for="textfield"></label>
            <input type="text" name="auth" id="textfield">
        <p>

            <input type="hidden" name="user3" id="textfield" value="All">

            <input type="submit" name="news_post" id="button" value="Submit">
        </p>
    </form>

    <?php
}
?>