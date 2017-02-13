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


/*
  $data['clientid'] = "CO-16";
  $data['eid'] = 49;
  $data['startlimit'] = 0;

  $indata = json_encode($data);
 */


if (!empty($indata)) {
    $val = json_decode($indata, true);
    $clientid = $val['clientid'];
    $empid = $val['eid'];
    $startlimit = $val['startlimit'];
    $notificationdetails = $obj->workAndBirthNotificationDetails($clientid, $empid, $startlimit);
    echo $notificationdetails;
} else {
    echo "No data found";
}
?>
