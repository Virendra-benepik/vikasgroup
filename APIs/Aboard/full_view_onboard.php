<?php

//error_reporting(E_ALL);ini_set('display_errors', 1);

require_once('../../Class_Library/class_get_onboard.php');
require_once('../../Class_Library/Api_Class/class_AppAnalytic.php');

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
      "val": "0",
      "comp":"CO-27",
      "uid":"1NtwiCYbQ7IxpjQb30cfzTzenjKCmC",
       "device":2,
       "deviceId":"ertret"
     }*/

if (!empty($jsonArr['comp']) && !empty($jsonArr['uid'])) {
    $obj = new GetWelcomeOnboard();
    $analytic_obj = new AppAnalytic();
    $val = $jsonArr['val'];
    $clientid = $jsonArr['comp'];
    $uid = $jsonArr['uid'];
    $device = $jsonArr['device'];
    $deviceId = $jsonArr['deviceId'];
    
    $flagtype = 12;
    
    $analytic_obj->listAppview($clientid, $uid, $device, $deviceId,$flagtype);
    
    $result = $obj->getAllOnboardFORandroid($clientid, $val, $uid);
    $value = json_decode($result, true);

    if ($value['success'] == 1) {
        foreach ($value['posts'] as $values) {
            //echo '<pre>';print_r($values);die;
            $post_content_keys = explode("#Benepik#", $values['post_content']);

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
} else {
    $response['success'] = 0;
    $response['message'] = "Invalid json";
}
header("Content-type: application/json");
echo json_encode($response);
?>

