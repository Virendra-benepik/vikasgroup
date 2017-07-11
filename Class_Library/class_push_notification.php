<?php

if(!class_exists("Connection_Communication")){
    include_once('class_connect_db_Communication.php');
}
class PushNotification {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    /*     * ****************************************GET GCM DETAILS FROM DATABASE ******************************************************* */

    public $userde;
    public $value;
    public $client;

    function get_Employee_details($usertype, $ur, $client) {
        $this->userde = $usertype;
        $this->client = $client;
        $this->value = $ur;   // this is an array when group usertype is Selected 
        $uuid = array();
        if ($this->userde == 'All') {
            try {
                $select = "select employeeId from Tbl_EmployeeDetails_Master where clientId =:cid1";
                $stmt = $this->DB->prepare($select);
                $stmt->bindParam('cid1', $this->client, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $row = $stmt->fetchAll();
                }
                foreach ($row as $row1) {
                    array_push($uuid, $row1['employeeId']);
                }
                $value = json_encode($uuid);
            } catch (PDOException $ex) {
                $value = $ex;
            }
            return $value;
        }
        /*         * ***************************** now start complex logic from here ********************************* */ else {
            $count1 = count($this->value);

            $allrows = array();
            //echo "count value of group ".$count."<br>";
            for ($t = 0; $t < $count1; $t++) {

                $groupid = $this->value[$t];
                // echo "group id:-".$groupid." value of loop ".$t."<br/>";
                /*                 * **************************************************************** */
                try {
                    $query5 = "select distinct(columnName) from Tbl_ClientGroupDemoParam where groupId=:gid and clientId=:cid1";

                    $stmt5 = $this->DB->prepare($query5);
                    $stmt5->bindParam(':gid', $groupid, PDO::PARAM_STR);
                    $stmt5->bindParam(':cid1', $this->client, PDO::PARAM_STR);
                    if ($stmt5->execute()) {

                        $rows = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                        $count = count($rows);
                        $response = array();
                        for ($i = 0; $i < $count; $i++) {

                            // echo $rows[$i]['columnName'];
                            $query = "select ColumnValue from Tbl_ClientGroupDemoParam where columnName=:cname and groupId=:gid1";

                            $stmt = $this->DB->prepare($query);
                            $stmt->bindParam(':gid1', $groupid, PDO::PARAM_STR);
                            $stmt->bindParam(':cname', $rows[$i]['columnName'], PDO::PARAM_STR);
                            $stmt->execute();

                            $rows1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
                            $posts["columnName"] = $rows[$i]['columnName'];
                            $posts["distictValuesWithinColumn"] = $rows1;

                            array_push($response, $posts);
                        }
                    }
                    /*   echo "<pre>";
                      print_r($response);
                      echo "</pre>"; */
                    $countrow = count($response);
//echo "total count of group parameter : - ".$countrow."</br>";
                    $substring = "";
                    for ($j = 0; $j < $countrow; $j++) {

                        $columnname = $response[$j]['columnName'];
                        // echo "column name  : - ".$columnname."<br/>";
                        $columnvalue = count($response[$j]['distictValuesWithinColumn']);
                        // echo "no of value in column  : - ".$columnvalue."<br/>";
                        $su = "";
                        for ($k = 0; $k < $columnvalue; $k++) {
                            if ($response[$j]['distictValuesWithinColumn'][$k] != 'All') {
                                $su .= "'" . $response[$j]['distictValuesWithinColumn'][$k] . "'" . ",";
                            } else {
                                $su .= "";
                            }
                        }
                        if ($su != "") {
                            // $string = str_replace(' ', '', $su);
                            $su1 = rtrim($su, ',');
                            //echo "series of column value  : - ".$su1."<br/>";
                            $substring .= $columnname . " IN(" . $su1 . ")" . " and ";
                            // echo $substring;
                        } else {
                            $substring .= "";
                        }
                    }
                    $finalstring = $substring . " clientid = '" . $this->client . "'";

//echo "final string : - ".$finalstring."<br/>";

                    try {
                        $qq = "select firstName,employeeId,clientId from Tbl_EmployeeDetails_Master where " . $finalstring;
                        $qq1 = "select firstName,emailId from Tbl_EmployeeDetails_Master where " . $finalstring;
                        // echo $qq."<br/>";
                        $stmt2 = $this->DB->prepare($qq);
                       
                        if ($stmt2->execute()) {

                            $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            /* echo "<pre>";
                              print_r($rows2);
                              echo "</pre>"; */

                            foreach ($rows2 as $row5) {
                                array_push($allrows, $row5['employeeId']);
                            }
                        }
                    } catch (PDOException $e) {
                        echo $e;
                    }
                    // echo "--------------------------------------<br/>";
                }

                /*                 * ***************************************** */ catch (PDOException $ex) {
                    $value = $ex;
                    echo $value;
                }
            }
            /* echo "<pre>";
              print_r($allrows);
              echo "</pre>"; */
            $value = json_encode($allrows);

            return $value;
        }
        /*         * ********************************** complex logic end from here ************************************ */
    }

    /*     * ***************************************** get pem file & google api key ********************************************** */

    function getKeysPem($clientid) {
        $query = "SELECT client_id,googleApiKey,iosPemfile FROM Tbl_ClientDetails_Master WHERE client_id = :cli";
        $keys = $this->DB->prepare($query);
        $keys->bindParam(':cli', $clientid, PDO::PARAM_STR);
        $keys->execute();
        $keyValues = $keys->fetch(PDO::FETCH_ASSOC);
       // print_r($keyValues);
        return $keyValues;
    }

    /*     * ****************************************************************************************************************** */

    /*     * *************************** get group email id for send a push ************************** */

    function getGroupAdminUUId($grouparray, $clientid) {
        $this->client = $clientid;

        $this->value = $grouparray;   // this is an array 
        //print_r($this->value);
        $count1 = count($this->value);
//  echo "group count: - ".$count1;
        $groupemail = array();

        for ($t1 = 0; $t1 < $count1; $t1++) {
            //   echo "Loop counting:- ".$t1."<br>";
            $groupid = $this->value[$t1];

//echo "GROUP id:-".$groupid."<br/>";

            $query = "select userUniqueId from Tbl_ClientGroupAdmin where groupId = :gid and clientId=:cid";
            $gemail = $this->DB->prepare($query);
            $gemail->bindParam(':gid', $groupid, PDO::PARAM_STR);
            $gemail->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $gemail->execute();
            $rows = $gemail->fetchAll(PDO::FETCH_ASSOC);
            $emailcount = count($rows);
            for ($k = 0; $k < $emailcount; $k++) {

                array_push($groupemail, $rows[$k]['userUniqueId']);
            }
        }
        return json_encode($groupemail);
    }

    /*     * **************************** get registration token details on the base of user uniqueid ******************* */

    function getGCMDetails($userarray, $clientid) {
        $this->value = $userarray;
        $this->client = $clientid;
        $kn = count($this->value);
        $regtoken = array();
        for ($t = 0; $t < $kn; $t++) {
            $val = $this->value[$t];
            $quer = "select * from Tbl_EmployeeGCMDetails where clientId =:cid and userUniqueId=:uid ORDER BY date_entry_time DESC";
            $st = $this->DB->prepare($quer);
            $st->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $st->bindParam(':uid', $val, PDO::PARAM_STR);
            if ($st->execute()) {
                $REG_TOKEN = $st->fetchAll(PDO::FETCH_ASSOC);
            }

            foreach ($REG_TOKEN as $reg) {
                array_push($regtoken, $reg);
            }
        }

        return json_encode($regtoken);
    }

    /*     * ******************************** get image ******************************************** */

    public $useruniqueid;

    function getImage($uid) {
        $this->useruniqueid = $uid;
        try {
            $query = "SELECT userImage FROM Tbl_EmployeePersonalDetails WHERE employeeId = :uid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':uid', $this->useruniqueid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                return $rows;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ****************************************GET SEND PUSH NOTIFICATION ******************************************************* */

    public $googleapi;

    function sendGoogleCloudMessage($data, $ids, $gpk) {
        // Insert real GCM API key from Google APIs Console
        // https://code.google.com/apis/console/     
        $this->googleapi = $gpk;
        $apiKey = $this->googleapi;
        // Define URL to GCM endpoint
        //        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $url = "https://fcm.googleapis.com/fcm/send";
        $message = "test message";
        $tag = "test";
        
        // Set GCM post variables (device IDs and push payload)     
        $post = array(
            'registration_ids' => $ids,
            'priority' => "high",
            // 'notification' => array( "title" => "Android Learning", "body" => $message, "tag" => $tag ),
            'data' => $data,
        );
        //   echo json_encode($post);
        // Set CURL request headers (authentication and type)       
        $headers = array(
            $url,
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        // Initialize curl handle       
        $ch = curl_init();

        // Set URL to GCM endpoint      
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request method to POST       
        curl_setopt($ch, CURLOPT_POST, true);

        // Set our custom headers       
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Get the response back as string instead of printing it       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set JSON post data
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

        // Actually send the push  

        $result = curl_exec($ch);

        // Error handling
        if (curl_errno($ch) || $result === FALSE) {
            die('FCM error: ' . curl_error($ch));
        }

        // Close curl handle
        curl_close($ch);

        // Debug GCM response   
       $response['result'] = $result;
        $response['postdata'] = $post;
        $response['success'] = 1;
        $response['msg'] = 'post send';


        return json_encode($response);
    }

     /************ Function for cron wish push **********************************************/
     function sendGoogleCloudMessageCron($data, $gpk) {
     	$ids = array($data['device_token']);
     	unset($data['device_token']);
        // Insert real GCM API key from Google APIs Console
        // https://code.google.com/apis/console/     
        $this->googleapi = $gpk;
        $apiKey = $this->googleapi;
        // Define URL to GCM endpoint
        //        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $url = "https://fcm.googleapis.com/fcm/send";
        $message = "test message";
        $tag = "test";
        
        // Set GCM post variables (device IDs and push payload)     
        $post = array(
            'registration_ids' => $ids,
            'priority' => "high",
            // 'notification' => array( "title" => "Android Learning", "body" => $message, "tag" => $tag ),
            'data' => $data,
        );

        //   echo json_encode($post);
        // Set CURL request headers (authentication and type)       
        $headers = array(
            $url,
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        // Initialize curl handle       
        $ch = curl_init();

        // Set URL to GCM endpoint      
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request method to POST       
        curl_setopt($ch, CURLOPT_POST, true);

        // Set our custom headers       
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Get the response back as string instead of printing it       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set JSON post data
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

        // Actually send the push  

        $result = curl_exec($ch);

        // Error handling
        if (curl_errno($ch) || $result === FALSE) {
            die('FCM error: ' . curl_error($ch));
        }

        // Close curl handle
        curl_close($ch);

        // Debug GCM response   
       $response['result'] = $result;
        $response['postdata'] = $post;
        $response['success'] = 1;
        $response['msg'] = 'post send';


        return ($response);
    }

    /*******************************************************************************/
    
    /*     * ******************************************** Function to send APNS push ************************************ */

    function sendAPNSPush_OLD_NOV($post, $deviceToken, $pemFile) {
        foreach ($deviceToken as $token) {
            if (!empty($token)) {
                $alert = "";
                $flagdata = $post['flag'];
                $flagvalue = $post['flagValue'];
                if ($flagdata == 3 || $flagdata == 4) {      //flag 2- for message  , flag 3- for picture
                    $content = $post['Content'];
                    $fulltitle = $flagvalue . $content;
                    $alert = $fulltitle;
                } else {
                    $title = $post['Title'];
                    $fulltitle = $flagvalue . $title;
                    $alert = $fulltitle;
                }

                $push_array = array(
                    'alert' => $alert,
                    'picture' => $post['Id'],
                    'sound' => 'default',
                    'flag' => $flagdata,
                    'title' => $post['Title'],
                    'content' => $post['Content'],
                    'date' => $post['Date']
                );

                $pemfile = BASE_PATH . '/' . $pemFile;
//            $pemfile = SITE_URL.$pemFile;
//            echo $pemfile;die;
                $device_token = str_replace(' ', '', trim($token));

                $payload = array();
                $payload['aps'] = $push_array;
                $payload = json_encode($payload);
                $apnsHost = 'ssl://gateway.push.apple.com:2195'; // prod
//                $apnsHost = 'ssl://gateway.sandbox.push.apple.com:2195'; // dev
                $apnsPort = 2195;

                $apnsCert = $pemfile;
                $passphrase = 'benepik123';

                $streamContext = stream_context_create();
                stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
//            stream_context_set_option($streamContext, 'ssl', 'passphrase', $passphrase);
                $apns = "";
                $apns = stream_socket_client($apnsHost, $error, $errorString, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $streamContext);

                if (!$apns) {
                    echo "Iphone Notification : Failed to connect: " . $error . ' ' . $errorString;
                } else {
                    $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', $device_token) . chr(0) . chr(strlen($payload)) . $payload;
                    $result = fwrite($apns, $apnsMessage);
//                    $post = $device_token;
                    if (!$result)
                        echo "Iphone Notification : Message not delivered";

//                    $mailMsg = 'token=' . $device_token . ' --Apns=>' . $apns . '<br>apnsMessage=>' . $apnsMessage;
                    fclose($apns);
                }
            }
        }
        $response['success'] = 1;
        $response['msg'] = 'post send';
        $response['Posts'] = $post;

        return json_encode($response);
    }

    function sendAPNSPush_old($post, $device_token, $pemFile) {
        foreach ($device_token as $token) {
            $data = array();
            $data = $post;
            $postData = '';

            $data['device_token'] = $token;
            $data['pemFile'] = $pemFile;

            //$post['device_token'] = $device_token; 
            //create name value pairs seperated by &
            foreach ($data as $k => $v) {
                $postData .= $k . '=' . $v . '&';
            }

            $postData = rtrim($postData, '&');

            $url = "http://" . $_SERVER['SERVER_NAME'] . "/push_code_test.php";

            // create a new cURL resource
            $ch = curl_init();
            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, count($postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

            // grab URL and pass it to the browser
            $output = curl_exec($ch);

            // close cURL resource, and free up system resources
            curl_close($ch);
            //echo $output;
        }
        $response['success'] = 1;
        $response['msg'] = 'post send';
        $response['Posts'] = $post;

        return json_encode($response);
    }

    function sendAPNSPush($post, $deviceToken, $pemFile, $device = '') {
        $apnsHost = 'gateway.sandbox.push.apple.com';       //dev
 //      $apnsHost = 'gateway.push.apple.com';            //production
        $apnsPort = '2195';
        $apnsCert = (empty($device) || $device = '') ? BASE_PATH . '/' . $pemFile : dirname(BASE_PATH) . '/' . $pemFile; //dev
       // echo $apnsCert;die;
        $passPhrase = 'benepik123';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apnsConnection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $streamContext);

        if ($apnsConnection == false) {
            echo "Failed to connect {$error} {$errorString}\n";
            return;
        } else {
//            echo "Connection successful<br>";
            $alert = "";
            $flagdata = $post['flag'];
            $flagvalue = $post['flagValue'];
            if ($flagdata == 3 || $flagdata == 4) {      //flag 2- for message  , flag 3- for picture
                $content = $post['Content'];
                $fulltitle = $flagvalue . $content;
                $alert = $fulltitle;
            } else {
                $title = $post['Title'];
                $fulltitle = $flagvalue . $title;
                $alert = $fulltitle;
            }
            $contentsring = strip_tags($post['Content']);
            //echo "post content-".$contentsring;
            $push_array = array(
                'alert' => $alert,
                'picture' => $post['Id'],
                'sound' => 'default',
                'flag' => $flagdata,
                'title' => $post['Title'],
                'content' => $contentsring,
                'date' => $post['Date']
            );
        }
        $payload['aps'] = $push_array;
        $payload = json_encode($payload);

        try {
            if ($alert != "") {
                $count = 0;
                foreach ($deviceToken as $token) {
                    $apnsMessage = chr(0) . @pack("n", 32) . @pack('H*', str_replace(' ', '', $token)) . @pack("n", strlen($payload)) . $payload;
//                $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', $deviceToken) . chr(0) . chr(strlen($payload)) . $payload;
//                $apnsMessage = chr(1) . pack("N", $msg_id) . pack("N", $expiry) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                    $fwrite = fwrite($apnsConnection, $apnsMessage);
//                    echo $token . '<br>';
                    if ($fwrite) {
//                        echo "true<br>";
//                        $count++;
                    } else {
//                        echo "false";
                    }
                }
//                echo $count;
            }
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        @fclose($apns);

        $response['success'] = 1;
        $response['msg'] = 'post send';
        $response['Posts'] = $post;

        return json_encode($response);
    }
    
    
    /*****************************    *********************/
    function sendAPNSPushCron($post, $pemFile, $device = '') {
	$deviceToken[] = $post['device_token'];
	unset($post['device_token']);
	
      $apnsHost = 'gateway.sandbox.push.apple.com';       //dev
//	$apnsHost = 'gateway.push.apple.com';            //production
        $apnsPort = '2195';
        $apnsCert = (empty($device) || $device = '') ? BASE_PATH . '/' . $pemFile : dirname(BASE_PATH) . '/' . $pemFile; //dev
       // echo $apnsCert;die;
        $passPhrase = 'benepik123';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apnsConnection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $streamContext);

        if ($apnsConnection == false) {
            echo "Failed to connect {$error} {$errorString}\n";
            return;
        } else {
//            echo "Connection successful<br>";
            $alert = "";
            $flagdata = $post['flag'];
            $flagvalue = $post['flagValue'];
            if ($flagdata == 3 || $flagdata == 4) {      //flag 2- for message  , flag 3- for picture
                $content = $post['Content'];
                $fulltitle = $flagvalue . $content;
                $alert = $fulltitle;
            } else {
                $title = $post['Title'];
                $fulltitle = $flagvalue . $title;
                $alert = $fulltitle;
            }
            $contentsring = strip_tags($post['Content']);
            //echo "post content-".$contentsring;
            $push_array = array(
                'alert' => $alert,
                'picture' => $post['Id'],
                'sound' => 'default',
                'flag' => $flagdata,
                'title' => $post['Title'],
                'content' => $contentsring,
                'date' => $post['Date']
            );
        }
        $payload['aps'] = $push_array;
        $payload = json_encode($payload);

        try {
            if ($alert != "") {
                $count = 0;
                foreach ($deviceToken as $token) {
                    $apnsMessage = chr(0) . @pack("n", 32) . @pack('H*', str_replace(' ', '', $token)) . @pack("n", strlen($payload)) . $payload;
//                $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', $deviceToken) . chr(0) . chr(strlen($payload)) . $payload;
//                $apnsMessage = chr(1) . pack("N", $msg_id) . pack("N", $expiry) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                    $fwrite = fwrite($apnsConnection, $apnsMessage);
//                    echo $token . '<br>';
                    if ($fwrite) {
//                        echo "true<br>";
//                        $count++;
                    } else {
//                        echo "false";
                    }
                }
//                echo $count;
            }
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        @fclose($apns);

        $response['success'] = 1;
        $response['msg'] = 'post send';
        $response['Posts'] = $post;

        return ($response);
    }
    
    /*****************************************************/
    

    /*     * ****************************** */

    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 40) {
            $info = getimagesize($source_url);

            if ($info['mime'] == 'image/jpeg')
                $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif')
                $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png')
                $image = imagecreatefrompng($source_url);

            //save it
            imagejpeg($image, $destination_url, $quality);

            //return destination file url
            return $destination_url;
        }
        else {
            move_uploaded_file($source_url, $destination_url);
        }
    }

    function makeThumbnails($updir, $img, $id) {
        $thumbnail_width = 400;
        $thumbnail_height = 400;
        $thumb_beforeword = "thumb";
        $arr_image_details = getimagesize("$updir" . "$img"); // pass id to thumb name

        $original_width = $arr_image_details[0];
        $original_height = $arr_image_details[1];
        if ($original_width > $original_height) {
            $new_width = $thumbnail_width;
//            $new_height = intval($original_height * $new_width / 2);
//            $new_height = ($original_height > $thumbnail_height) ? $thumbnail_height : $original_height;
            $new_height = $thumbnail_height;
        } else {
            $new_height = $thumbnail_height;
//            $new_width = intval($original_width * $new_height / 2);
//            $new_width = ($original_width > $thumbnail_width) ? $thumbnail_width : $original_width;
            $new_width  = $thumbnail_width;
        }
        $dest_x = intval(($thumbnail_width - $new_width) / 1);
        $dest_y = intval(($thumbnail_height - $new_height) / 1);

        if ($arr_image_details[2] == IMAGETYPE_GIF) {
            $imgt = "ImageGIF";
            $imgcreatefrom = "ImageCreateFromGIF";
        }
        if ($arr_image_details[2] == IMAGETYPE_JPEG) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "ImageCreateFromJPEG";
        }
        if ($arr_image_details[2] == IMAGETYPE_PNG) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "ImageCreateFromPNG";
        }
        if ($imgt) {
            $old_image = $imgcreatefrom("$updir" . "$img");
            $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
            imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $thumb_image = $imgt($new_image, "$updir" . "thumb/" . $thumb_beforeword . "_" . "$img");
            return "$updir" . "thumb/" . $thumb_beforeword . "_" . "$img";
        }
    }

    /*     * ****************************************************************** */

    function createPopup($POST_ID, $clientid, $POST_IMG, $FLAG, $DATE, $USERID) {
        try {
            $query = "insert into Tbl_C_WelcomePopUp(id,clientId,imageName,flagType,createdDate,createdBy)
			values(:pid,:cid,:img,:flag,:dte,:uid)";
            $astmt = $this->DB->prepare($query);
            $astmt->bindParam(':pid', $POST_ID, PDO::PARAM_STR);
            $astmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $astmt->bindParam(':img', $POST_IMG, PDO::PARAM_STR);
            $astmt->bindParam(':flag', $FLAG, PDO::PARAM_STR);
            $astmt->bindParam(':dte', $DATE, PDO::PARAM_STR);
            $astmt->bindParam(':uid', $USERID, PDO::PARAM_STR);
            if ($astmt->execute()) {
                $res['success'] = 1;
                $res['message'] = "data add in popup";
            } else {
                $res['success'] = 0;
                $res['message'] = "data not add in popup";
            }
        } catch (PDOException $es) {
            $res['success'] = 0;
            $res['message'] = "data not add in popup" . $es;
        }
        return $res;
    }

}

?>
