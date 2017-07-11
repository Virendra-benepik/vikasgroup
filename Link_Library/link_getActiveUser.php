<?php
require_once('../Class_Library/class_login_analytic.php');
$obj = new LoginAnalytic();

if (!empty($_POST["mydata"])) {
    $jsonArr = $_POST["mydata"];
    
    $data1 = json_decode($jsonArr, true);
    
      
    $data = explode("-", $data1["date"]);
     $companyname = $data1["companyname"];

    if (!empty($data)) {
        $client = 'CO-27';

        $fromdt1 = $data[0];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
        $enddte1 = $data[1];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));

        $result = $obj->graphGetActiveUser($client, $fromdt, $enddte,$companyname);

        $res = json_decode($result, true);
     
        $postdate = array();
        $totalview = array();
        $uniqueview = array();
        for ($i = 0; $i < count($res); $i++) {
           
            $date = $res[$i]['date_of_entry'];
            $uniqueno = $res[$i]['uniqueview'];
            $totalno = $res[$i]['totalview'];
           
            array_push($postdate, $date);
            array_push($totalview, $totalno);
            array_push($uniqueview, $uniqueno);
        }
      
//        $response['success']=1;
        $response['categories'] = $postdate;
        $response['uniqueview'] = $uniqueview;
        $response['totalview'] = $totalview;
//print_r($response);
       
      echo   $jsonres = json_encode($response);
       // echo  "'".$jsonres."'";
    }
}
?>  