<?php
error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("../../Class_Library/Api_Class/class_dispaly_post_data.php") && include("../../Class_Library/Api_Class/class_dispaly_post_data.php")) {
    require_once('../../Class_Library/class_get_onboard.php');

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

  /*  {
        "clientid" :"CO-25",
                "postid": "",
                "flag":1
    }*/
    if (!empty($jsonArr['clientid'])) {
        $obj = new PostDisplay();
        extract($jsonArr);

        if ($flag != 12) {
            $response = $obj->post_details($clientid, $postid, $flag);
        } else {
	    $imagepath = site_url;
            $onboard = new GetWelcomeOnboard();
            $result = $onboard->getSingleOnboard($postid, $clientid, $imagepath);
            $value = json_decode($result, true);

            if (!empty($value)) {

                foreach ($value as $values) {
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

                    array_push($final_data_keys, 'user_image', 'user_name', 'postid', 'flagCheck', 'userImage');
                    array_push($final_data_value, $values['post_img'], $values['post_title'], $values['post_id'], "12", $values['userImage']);
                    $final_data_value[2] = date('d M Y', strtotime($final_data_value[2]));

                    $response_data = array_combine($final_data_keys, $final_data_value);
                }
                $response['success'] = 1;
                $response['message'] = "Onboard Data Available";
                $response['post'] = array($response_data);
            } else {
                $response['success'] = 0;
                $response['message'] = "Onboard Data Unavailable";
            }
        }
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }

    header('Content-type: application/json');
    echo json_encode($response);
}
?>
