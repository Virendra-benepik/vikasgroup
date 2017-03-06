<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('../../Class_Library/class_get_onboard.php');
$dev = !empty($_GET['dev']) ? $_GET['dev'] : '';
$obj = new GetWelcomeOnboard();

if ($dev == 'd2') {
   // include '../navigationbar.php';
   // include '../leftSideSlide.php';

    $clientid = $_SESSION['client_id'];
    $value = $_GET['idonboard'];

    $result = $obj->getSingleOnboard($value, $clientid);
    $value = json_decode($result, true);
} 
else {
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

    $val = $jsonArr['val'];
    $clientid = $jsonArr['comp'];
	

    /*{
      $val = 0;
      $clientid = 'CO-16';
     }*/

    $result = $obj->getAllOnboardFORandroid($clientid, $val);
    $value = json_decode($result, true);
}
?>

<?php
$postid = !empty($_GET['idonboard']) ? $_GET['idonboard'] : '';
$string = "post_id=$postid";

$sub_req_url = "http://admin.benepik.com/employee/virendra/benepik_admin/lib/android_like_display.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);
curl_close($ch);
$getcat = json_decode($resp, true);

//$like = count($getcat['posts']);
$total_like = $getcat['total_like'];
//echo $val;
?>

<?php
$postid = !empty($_GET['idonboard']) ? $_GET['idonboard'] : '';
$string = "post=$postid";

$sub_req_url = "http://admin.benepik.com/employee/virendra/benepik_admin/lib/android_comment_display.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);
curl_close($ch);
$get = json_decode($resp, true);

$resul = count($get['posts']);

if ($dev == 'd2') {

    echo $resul;
    ?>


    <div class="row" style="width:100%;height:auto;margin-top: 80px;margin-left:0%;">
        <div class=" col-sm-4 col-md-4 col-lg-4"></div>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="border: 1px solid #f1f1f0;">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo "<h4>" . $value[0]['post_title'] . "</h4>"; ?>
                    <?php echo "<div style='font-size: 11px; font-weight: bold;color: gray; margin-bottom: 1%;'>" . $value[0]['created_date'] . "</div>"; ?>
                    <img src="<?php echo $value[0]['post_img']; ?>"class="img img-responsive" style="box-shadow: gray 0px -1px 10px 1px;max-height: 250px; width: 100%"/>

                    <?php
                    $post_content_keys = explode("#Benepik#", $value[0]['post_content']);
                    unset($post_content_keys[0]);
                    $post_content_keys = array_values($post_content_keys);
                    //echo'<pre>';print_r($post_content_keys);die;
                    $final_data_keys = array();
                    $final_data_value = array();
                    foreach ($post_content_keys as $keys => $val) {

                        $key_data = explode("###", $val);

                        array_push($final_data_keys, trim($key_data[0], " "));
                        array_push($final_data_value, strip_tags(trim($key_data[1], " "), ""));
                        ?>
                        <div style="font-size: 16px;font-family: calibri, sans-serif; text-align: justify;"><?php echo "<b>" . $final_data_keys[$keys] . "</b> <p>" . $final_data_value[$keys] . "</p>"; ?></div>
                        <?php
                    }
                } else {
	            if ($value['success'] == 1) {
                    foreach ($value['posts'] as $values) {
                        //echo '<pre>';print_r($values);die;
                        $post_content_keys = explode("#Benepik#", $values['post_content']);

                        //echo '<pre>';print_r($post_content_keys);die;

                        unset($post_content_keys[0]);
                        $post_content_keys = array_values($post_content_keys);
                        //echo'<pre>';print_r($post_content_keys);die;
                        $final_data_keys = array();
                        $final_data_value = array();
                        foreach ($post_content_keys as $keys => $val) {

                            $key_data = explode("###", $val);

                            array_push($final_data_keys, trim($key_data[0], " "));
                            array_push($final_data_value, strip_tags(trim($key_data[1], " \n\t\t "), ""));
                        }

                        array_push($final_data_keys, 'user_image', 'user_name', 'postid', 'flagCheck');
                        array_push($final_data_value, $values['post_img'], $values['post_title'], $values['post_id'], "12");
                        $final_data_value[2] = date('d M Y', strtotime($final_data_value[2]));

                        $response_data[] = array_combine($final_data_keys, $final_data_value);
                    }
                    //echo'<pre>';print_r($response_data);die;
                    
                        $response['success'] = 1;
                        $response['message'] = "Post Available";
                        $response['total_post'] = $value['totals'];
                        $response['post'] = $response_data;
                    } else {
                        $response['success'] = 0;
                        $response['message'] = "No more post available";
                    }
                    header("Content-type: application/json");
                    echo json_encode($response);
                    die;
                }
                ?>


            </div>
        </div>

        <!--<div class="row">
          
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" class="btn  btn-sm likeBTN" data-toggle="modal" data-target="#myModalLikepop">
                                <span class="glyphicon glyphicon-thumbs-up"></span>  Likes : <?php echo $total_like; ?>
                        </button>
                        
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" class="btn CommentBTN  btn-sm">
                                <span class="glyphicon glyphicon-comment"></span> Comments : <?php echo $resul; ?>
                        </button>
                        
                </div>
        </div>
        ---->

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <div id="RecentComment">
                    <p class="LatestActivitiesHeading"> Comment </p>
                    <hr>
                    <?php
                    for ($i = 0; $i < $resul; $i++) {
                        echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
                        echo "<img src=" . $get['posts'][0]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important'/>";
                        echo "</button></div>";
                        echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
                        echo "<p class='LatestActivitiesSub-Heading'>" . $get['posts'][$i]['firstname'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $get['posts'][$i]['cdate'] . "</p><hr/>";
                        echo "<p class='LatestActivitiesDate'>" . $get['posts'][$i]['content'] . "</p></div></div><hr>";
                    }
                    ?>
                </div>
            </div>	
        </div>





    </div>
    <div class=" col-sm-4 col-md-4 col-lg-4"></div>
</div>



<!--**********pop up for like (start)***********-->


<div class="modal fade" id="myModalLikepop" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content"style="width:80%;">
            <div class="modal-header"style="background:#808080;color:#ffffff;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><p class="LatestActivitiesHeading">Likes</p></h6>
            </div>
            <div class="modal-body"style="max-height:550px;overflow-y:auto;">


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="latest_activity">


                            <?php
                            for ($k = 0; $k < $total_like; $k++) {
                                echo "<div class='row'>
<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 col-sm-offset-1'>";
                                echo "<img src=" . $getcat['posts'][$k]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important;margin-top: -11px;margin-left: -19px;'/>";
                                echo "</div>";
                                echo "<div class='col-xs-7 col-sm-7 col-md-7 col-lg-7'> ";
                                echo "<p class='LatestActivitiesSub-Heading'>" . $getcat['posts'][$k]['firstname'] . " " . $getcat['posts'][$k]['lastname'] . "</p>";
                                echo "<p style='font-size:12px;color:gray;margin:0px;'>" . $getcat['posts'][$k]['cdate'] . "</p>";
                                echo "</div>";
                                echo "</div>";
                            }
                            ?>


                        </div>



                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
<!--**********pop up for like (end)***********-->

<?php include '../footer.php'; ?>
