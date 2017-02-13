<?php
require_once('Class_Library/class_login_analytic.php');
$obj = new LoginAnalytic();
	//$json = json_decode(file_get_contents("php://input"));\
	/*print_r($json);
	   if(isset($_POST["mydata"])
	   {
		   $jsonArr = $_POST["mydata"];
		    echo "return data".$jsonArr;
	   }
	   else
	   {
		   echo "error";
	   }
	   */
	   if(!empty($_POST["mydata"]))
	   {
		   $jsonArr = $_POST["mydata"];
		   //echo $jsonArr;
		   //print_r($jsonArr);
		   $data = json_decode($jsonArr , true);
		   //print_r($data);
		   
			if (!empty($data)) 
			{
			 $client = $data['client'];
			 $fromdt = $data['start_date'];
			 $enddte = $data['end_date'];
			 $device = $data['device'];
			
			$result = $obj->userAppInstalltion($client,$fromdt,$enddte,$device);
			//$res = json_decode($result , true);
			//echo $result;
			//echo "<pre>";
			
			echo $result;
			//print_r($result);
		   }
		   
	   }
		
	 

?>