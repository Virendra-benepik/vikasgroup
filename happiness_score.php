<?php
session_start();

/* Database connection changed
include_once('Class_Library/class_connect_db.php');
include_once('Class_Library/class_connect_db_admin.php');
*/
include_once('Class_Library/class_connect_db_mahle.php');

/* Database connection changed
       $dbh = new Connection_Client();
       $connect =  $dbh->getConnection_Client();
       
       $dbh1 = new Connection();
       $connect_admin =  $dbh1->getConnection();
*/       
	$dbh = new Connection_Mahle();
        $connect =  $dbh->getConnection_Mahle();

      $location = "";
      $department = "";
      $age = "";
      $year = "";
  $Year = $_REQUEST['year'];
  $month = $_REQUEST['month'];
 $cid = $_SESSION['client_id'];
 $location = $_REQUEST['location'];
 $department = $_REQUEST['department'];
 $age = $_REQUEST['age'];
 //echo $cid;
 
 /**************************************************************/
 
 $location_array = array(); 
 if($location == "All" or $location == "")
 {
 $query  = "select employeeId,location,clientId from Tbl_EmployeeDetails_Master where clientId =:cli";
 }
 else
 {
 $query  = "select employeeId,location,clientId from Tbl_EmployeeDetails_Master where location In ('$location') and clientId =:cli";
 }
 $stmt = $connect->prepare($query);
 $stmt->bindParam(':cli',$cid,PDO::PARAM_STR);
 $stmt->execute();
 $ty = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 foreach($ty as $empid)
 {
 array_push($location_array,$empid['employeeId']);
 }
 /***************************************************************************/
$dept_array = array();

 if($department == "All" or $department == "")
 {
 $query  = "select employeeId,department,clientId from Tbl_EmployeeDetails_Master where clientId =:clientid";
 }
 else
 {
 $query  = "select employeeId,department,clientId from Tbl_EmployeeDetails_Master where department In ('$department') and clientId =:clientid";
 }
 $stmt = $connect->prepare($query);
 $stmt->bindParam(':clientid',$cid,PDO::PARAM_STR);
 $stmt->execute();
 $ty = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
foreach($ty as $empid)
{
array_push($dept_array,$empid['employeeId']);
}

 /************************************************************/
 
$all_array = array_intersect($location_array,$dept_array); 
 
 /*********************************************************************/
 
$feedback_array = array();
$q = "select userUniqueId from Tbl_Analytic_EmployeeHappiness where clientId =:cid and YEAR(date_of_feedback) =:year and MONTH(date_of_feedback)=:month";
 $stmt = $connect->prepare($q);
   $stmt->bindParam(':year',$Year,PDO::PARAM_STR);
  $stmt->bindParam(':month',$month,PDO::PARAM_STR);
  $stmt->bindParam(':cid',$cid,PDO::PARAM_STR);
 
  $stmt->execute();
$row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($row2 as $fd)
{
array_push($feedback_array,$fd['userUniqueId']);
}

$all_array1 = array_intersect($feedback_array,$all_array);
 
 $in = implode("', '", array_unique($all_array1));
 /*********************************************************************************************/
  try
  {
    
   $avg =  "SELECT date(date_of_feedback) as date, AVG(value) as avg, count(date_of_feedback) as TOTALfeedback
     FROM Tbl_Analytic_EmployeeHappiness where clientId =:cid and YEAR(date_of_feedback) =:year and MONTH(date_of_feedback)=:month and userUniqueId IN ('".$in."') GROUP BY date(date_of_feedback)";
   $stmt = $connect->prepare($avg);
   $stmt->bindParam(':year',$Year,PDO::PARAM_STR);
  $stmt->bindParam(':month',$month,PDO::PARAM_STR);
  $stmt->bindParam(':cid',$cid,PDO::PARAM_STR);
  $stmt->execute();
   $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $count =  count($row1);
  $result = array();
 if($count>0)
 {
 $Mavg = "select avg(value) as monthlyaverage from Tbl_Analytic_EmployeeHappiness where clientId =:cid and YEAR(date_of_feedback) =:year and MONTH(date_of_feedback)=:month";
 
 $stmt1 = $connect->prepare($Mavg);
   $stmt1->bindParam(':year',$Year,PDO::PARAM_STR);
  $stmt1->bindParam(':month',$month,PDO::PARAM_STR);
  $stmt1->bindParam(':cid',$cid,PDO::PARAM_STR);
  $stmt1->execute();
   $row2 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
   $rt = json_encode($row2);
  
$monthly_average = $row2[0]['monthlyaverage'];

   $sesult['success']= 1;
   $result['message'] = 'Data Found ';
   $result['maverage'] = $monthly_average;
    $result['value'] = $row1;     
  
   }  
   else
   {
    $sesult['success']= 0;
   $result['message'] = 'No Data Found ';
    $result['maverage'] = '';
    $result['value'] = '';
   }
   echo json_encode($result);
 
   }
   catch(PDOException $ex)
   {
      echo $ex;
   }

?>