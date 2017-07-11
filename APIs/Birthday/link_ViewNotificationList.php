<?php

/*
  Description :- link files contain all fields from HTML file and create object of class files . call functions help of object and pass parameter into function .
 */

/* * ******************************** included class file and create object of class ****************************** */
require_once('../../Class_Library/Api_Class/class_wish.php');
$obj = new wish();
/* * ******************************** end included class file and create object of class ****************************** */

/* * ******************************START HERE************************************************ */

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

/* * ********************************************************************************************** */

$indata = file_get_contents("php://input", true);

/* echo "i am not here";
  $data['clientid'] = "CO-22";
  $data['eid'] = 408;
  $data['startlimit'] = 0;
  $indata = json_encode($data); */

if (!empty($indata)) {
    $val = json_decode($indata, true);
    $clientid = $val['clientid'];
    $empid = $val['eid'];
    $startlimit = $val['startlimit'];

    $notilistdetails = $obj->workAndBirthNotiListDetails($clientid, $empid, $startlimit);
    $Data = json_decode($notilistdetails, true);
     echo "<pre>";
    print_r($Data);

    $site_url = site_url;
    
    if ($Data['success'] == 1) {
        $Count = count($Data['Data']);
        for ($intRow = 0; $intRow < $Count; $intRow++) {

            $Data['Data'][$intRow]['userImage'] = (!empty($Data['Data'][$intRow]['userImage'])) ? $site_url . $Data['Data'][$intRow]['userImage'] : "";
            $wishFlag = $Data['Data'][$intRow]['wishFlag'];

            if ($wishFlag == "0") {
                $Data['Data'][$intRow]['message'] = $Data['Data'][$intRow]['username'];
            } else {
                $WishDate = @date_create($Data['Data'][$intRow]['WishDate']);
                $username = $Data['Data'][$intRow]['username'];

                $Data['Data'][$intRow]['message'] = $obj->workAndBirthMessage($WishDate, $username, $wishFlag,$Data['Data'][$intRow]['eventId'], $Data['Data'][$intRow]['Title']);
            }
        }
    } 
} else {
    $Data['response'] = 0;
    $Data['message'] = "Invalid json";
}
header("Content-Type:application/json");
echo json_encode($Data);
?>
