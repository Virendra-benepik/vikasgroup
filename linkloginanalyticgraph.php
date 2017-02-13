<?php

require_once('Class_Library/class_login_analytic.php');
$obj = new LoginAnalytic();

if (!empty($_POST["mydata"])) {

    $jsonArr = $_POST["mydata"];
    // echo "this is link analytic graph page";
//    echo $jsonArr;
//    print_r($jsonArr);
//     die;
    $data = json_decode($jsonArr, true);
    //print_r($data);

    if (!empty($data)) {
        $client = $data['client'];
        $fromdt = $data['start_date'];
        $enddte = $data['end_date'];
        $searchby = $data['searchby'];

        $result = $obj->AnalyticLoginGraphUser($client, $fromdt, $enddte, $searchby);
        $res = json_decode($result, true);
//        echo "<pre>";
        // print_r($res);die;

        for ($i = 0; $i < count($res); $i++) {
            $device = $res[$i]['label'];
            if ($device == 2) {
                $label = 'android';
            } else {
                $label = 'ios';
            }
            $res[$i]['label'] = $label;
        }

        echo $jsonres = json_encode($res);


        // echo $result;
    }
}
?>