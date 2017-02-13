<?php

include("../../Class_Library/class_push_notification.php");

//$jsonArr = json_decode(file_get_contents("php://input"), true);
//extract($jsonArr);

$data = array("Title" => "Apollo Mario", "Content" => "All Manav Rachna Testing Content for Push Notification for IOS 12:14 AM", "flag" => "3", "flagValue" => "Message : ", "Picture" => "", "Date" => "");

//$data = array('Id' => '', 'Title' => "Apollo Mario", 'Content' => "Testing Content for Push Notification", 'SendBy' => '', 'Picture' => '', 'Date' => '', 'flag' => '3', 'flagValue' => "Message", 'success' => '', 'like' => '', 'comment' => '');
//$ids = "e9H7mLK1PgI:APA91bGW908_5OZgAIGQpqVY379htUZcFPPthNXuH7dsYCN87ZeoVbaLp1NqjyOnPaeCCxWF_y91gua_VHqWy2N1T4bjwWkbGu4b-Ufi29idn69r4KGToiQu8-ZxsKSTvemYhRMIy30F";

//$idsIOS = array("068ac3f436079761978367fa92a41390b13901031115ae50e93490d023c9421e"); //prod
$idsIOS = array("c229cef0c65312478fea9f8c19cf5be6bf2c05019b3a4629b91157ebafe13329","86613e1eaf245049c836b277a5994604825ca82b52c9568bbaa830f1728b0cfd","7601a4053a6a8294f795f32670d22e2be938a8793e35599a61b657455f6680b3");//dev

//$gpk = "AIzaSyAJxALJGtfCqI4Sgakixdkc4rv1GEO20zc";
$pem_file = "Pem_files/manav.pem"; // Testing
//$pem_file = "Pem_files/ZoomConnect.pem"; // Production

$obj = new PushNotification;
$device = 'device';
//$response = $obj->sendGoogleCloudMessage($data, $ids, $gpk);
$response = $obj->sendAPNSPush($data, $idsIOS, $pem_file, $device);

echo $response;
