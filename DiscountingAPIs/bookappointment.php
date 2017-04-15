<?php

error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("../Class_Library/Api_Class/class_bookappointment.php") && include("../Class_Library/Api_Class/class_bookappointment.php")) {

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
    
    if (!empty($jsonArr['clientid'])) {
        include("../Class_Library/Api_Class/class_messageSentTo.php");
        $mesg = new messageSent();
        $obj = new BookAppoint();
        extract($jsonArr);

        $result = $obj->BookAppointment($clientid, $employeeid, $dealid, $branchid, $dates, $times, $mobile, $service, $message);

        if ($result['success'] == 1) {

            $userName = $result['posts'][0]['userName'];
            $userMail = $result['posts'][0]['userMail'];
            $usercontact = $result['posts'][0]['contact'];
            $merchantMobile = $result['posts'][0]["merchantMobile"];
            $merchantEmail = $result['posts'][0]["merchantEmail"];
            $merchantBranchLocation = $result['posts'][0]["merchantBranchLocation"];
            $merchantName = $result['posts'][0]["merchantName"];
            $category = $result['posts'][0]['category'];
//echo "category -".$category;
            if ($category == "Food & Drink") {
                $headingmerchant = "Benepik Member has reserved a table as per the following details: ";
                $mobileUserMessage = "Thank you for booking a table at "
                        . $merchantName
                        . " "
                        . $merchantBranchLocation
                        . " on "
                        . $dates
                        . "  "
                        . $times
                        . " . "
                        . ".Your request has been forwarded.";

                $mobileMerchantMessage = "Benepik Member booking on "
                        . $dates
                        . " "
                        . $times
                        . " at "
                        . $merchantBranchLocation
                        . " . "
                        . "Name: "
                        . $userName
                        . " Mobile: "
                        . $usercontact
                        . ". Call the customer for confirmation.";
            } else if ($category == "Car Care") {
                $headingmerchant = "Benepik Member has booked a car service as per the following details: ";
                $mobileUserMessage = "Thank you for booking Car Service at "
                        . $merchantName
                        . " "
                        . $merchantBranchLocation
                        . " on "
                        . $dates
                        . " "
                        . $times
                        . " . "
                        . " Your request has been forwarded.";

                $mobileMerchantMessage = "Benepik Member Car Service Request on "
                        . $dates
                        . " "
                        . $times
                        . " at "
                        . $merchantBranchLocation
                        . " . "
                        . " Name: "
                        . $userName
                        . " Mobile: "
                        . $usercontact
                        . ". Call the customer for confirmation.";

                $msg = "Your Car Service Request has been forwaded to " . $merchantName;
            } else {
                $headingmerchant = "Benepik Member has booked an appointment as per the following details: ";
                $mobileUserMessage = " Thank you for your booking with "
                        . $merchantName
                        . " on "
                        . $dates
                        . " "
                        . $times
                        . " at "
                        . $merchantBranchLocation
                        . " . "
                        . " Your request has been forwarded .";

                $mobileUserMessage = "Benepik Member booking on "
                        . $dates
                        . " "
                        . $times
                        . " at "
                        . $merchantBranchLocation
                        . " . "
                        . " Name: "
                        . $userName
                        . " Mobile: "
                        . $usercontact
                        . ". Call the customer for confirmation.";


                $msg = "Your Appointment Request has been forwarded to " . $merchantName;
            }

            /*             * ******************************************************************** */
            /* $mobileUserMessage = "Thank you for booking a table at "
              . $merchantName
              . " "
              . $merchantBranchLocation
              . " on "
              . $dates
              ."  "
              .  $times
              . " . "

              .".Your request has been forwarded.";


              $mobileMerchantMessage = "Benepik Member booking on "
              . $dates
              ." "
              . $times
              . " at "
              . $merchantBranchLocation
              . " . "

              . "Name: "
              . $userName
              . " Mobile: "
              . $mobile
              . ". Call the customer for confirmation."; */
            /*             * **************************************************************************************************** */
//$headingmerchant="Benepik Member has booked a car service as per the following details: ";
            $merchantbookingheading = $merchantName . "  Details: ";

            $mailMerchantBody = stripslashes('Dear ' . $merchantName . ',<br/><br/>' . $headingmerchant . '<br />'
                    . " Name: " . $userName . '<br />'
                    . " Mobile: " . $mobile . '<br />'
                    . " Email: " . $userMail . '<br />'
                    . $merchantbookingheading . $jsonArr['dates'] . ", " . $jsonArr['times'] . '<br />'
                    . " Location: " . $merchantBranchLocation . '<br />'
                    . 'Please call the customer for confirmation' . '<br /><br/>'
                    . 'Regards,' . '<br />' . 'Team Vikas Live');

            $sub = "Benepik " . $merchantName . " Request";

            /*             * ************************************* mail body to sir ***************************************** */
//            $mailidsir="saurabh.jain@benepik.com";
            $mailidsir = "gagandeep@benepik.com";
		  // $mailidsir = "monikagupta05051994@gmail.com";

            $mailMessage = stripslashes("Dear Team benepik," . "<br/><br/>" . $headingmerchant . "<br />"
                    . " Name: " . $userName . '<br />'
                    . " Mobile: " . $mobile . '<br />'
                    . " Email: " . $userMail . '<br />'
                    . " Date: " . $jsonArr['dates'] . '<br />'
                    . " Time: " . $jsonArr['times'] . '<br />'
                    . " Merchant Name: " . $merchantName . '<br />'
                    . " Location: " . $merchantBranchLocation . '<br/><br/>'
                    . 'Regards,' . '<br />' . 'Team Vikas Live');

            $sub = "Vikas Live appointment Request";
            //$from1 = "From: <info@benepik.com>";
			$from1 = "From: Vikas Live<vikaslive@benepik.com>";
            /*             * ******************************************************* */

            

            if ($merchantEmail != "") {
                $mesg->forMailToAppointment($merchantEmail, $sub, $mailMerchantBody);
            }
            if ($mailidsir != "") {
                $mesg->forMailToSir($mailidsir, $sub, $mailMessage, $from1);
            }

            if ($mobile != "") {
                $mobiles = "+91" . $mobile;
                $mesg->forMobile($mobiles, $mobileUserMessage);
            }

            if ($merchantMobile != "") {
                $mesg->forMobile($merchantMobile, $mobileMerchantMessage);
            }
        }
        
        $response = $result;
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";

//        $response = $result;
    }

    header('Content-type: application/json');
    echo json_encode($response);
}
?>