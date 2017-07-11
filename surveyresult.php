<?php

require_once('Class_Library/class_HappinesQuestion.php');
$obj = new HappinessQuestion();

if (!empty($_POST["mydata"])) {
    $jsonArr = $_POST["mydata"];

    $data = json_decode($jsonArr, true);
    // print_r($data);

    if (!empty($data)) {
        $clientid = $data['clientid'];
        $qid = $data['questionid'];
        $sid = $data['surveyid'];

        $result = $obj->getresultquestion($qid, $clientid, $sid);
        $res = json_decode($result, true);
//        echo "<pre>";        print_r($res['data']);
        for ($i = 0; $i < count($res['data']); $i++) {
            $user = $res['data'][$i]['label'];
            //  echo  $user;

            if ($user == 10) {
                $user = 'Overwhelming';
            } elseif ($user == 5) {
                $user = 'Happy';
            } elseif ($user == 0) {
                $user = 'Neutral';
            } elseif ($user == -5) {
                $user = 'Sad';
            }

            $res['data'][$i]['label'] = $user;
        }

        echo $jsonres = json_encode($res['data']);
        // echo $res;
        // echo $result;
    }
}
?>
