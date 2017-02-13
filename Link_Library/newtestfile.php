<?php

 //http://stackoverflow.com/questions/18382740/cors-not-working-php
/* if (isset($_SERVER['HTTP_ORIGIN'])) {
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
 
 
 
 /*************************************************************************************************/
 $postdata = file_get_contents("php://input");
  
 include_once("../Class_Library/class_connect_db_test.php"); 
  $object = new connect();
 $con = $object->db_connect_test();  
 
 if (!empty($postdata)) 
 {
 $request = json_decode($postdata);
 
 $username = $request->username;
//$username = $_POST['img'];
 if ($username != "") {
 $res = array();
  $number = $object->randomNumber(12);
$imgname = $object->convertintoimage($username,$number);
 //echo $imgname;
 try
 {
 $query = "insert into BarGraph(optionName)values(:cid)";
             $stmt = $con->prepare($query);
             $stmt->bindParam(':cid', $imgname, PDO::PARAM_STR);
            if ($stmt->execute())
            {
            $res['success'] = 1;
            $res['msg'] = 'img upload';
            $res['imganme'] = $imgname;
            }
            else
            {
             $res['success'] = 0;
            $res['msg'] = 'img not upload';
            }
           //  json_encode($res);
 }
 catch(PDOException $e)
 {
 echo $e;
  }
echo json_encode($res);
  }
 else {
 echo "Empty username parameter!";
 }
 }
 else {
 
 ?>
 <form method="post" action="">
 <input type="text" name="username" placeholder="enter base64 img string">
 <input type ="submit" name="submit">
 </form>
 <?php
//echo "Not called properly with username parameter!";
 }
 ?>