<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');
class LoginAnalytic
{
     public $db_connect;
	 public function __construct()
    {
        $dbh = new Connection_Communication();
		$this->db_connect =  $dbh->getConnection_Communication();
    }
	
	function userAppInstalltion($clientid,$startdate,$enddate,$device)
	{
		/*echo $clientid; */
		//echo $startdate;
		//echo $enddate;
		/* echo $device;  */
		// $contractDateBegin = date('Y-m-d', strtotime($startdate));
         //$contractDateEnd = date('Y-m-d', strtotime($enddate));
		// echo $contractDateBegin;
		//echo $contractDateEnd;
		try 
		{
			if($device == "All")
			{
				$query = "SELECT edm.firstName, edm.department, edm.location, gcm.deviceName,DATE_FORMAT(gcm.date_entry_time,'%d %b %Y') as date_entry_time FROM Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeeGCMDetails as gcm ON edm.employeeId = gcm.userUniqueId where (gcm.date_entry_time BETWEEN :fromdte AND :enddte)  AND edm.clientId=:client order by edm.firstName,gcm.date_entry_time desc";
			}
			else
			{
				$query = "SELECT edm.firstName, edm.department, edm.location, gcm.deviceName,DATE_FORMAT(gcm.date_entry_time,'%d %b %Y') as date_entry_time FROM Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeeGCMDetails as gcm ON edm.employeeId = gcm.userUniqueId where (gcm.date_entry_time BETWEEN :fromdte AND :enddte)  AND gcm.deviceName = :device and edm.clientId=:client order by edm.firstName,gcm.date_entry_time desc";
			}
		   $stmt = $this->db_connect->prepare($query);
		   $stmt->bindParam(':client',$clientid, PDO::PARAM_STR); 
		   $stmt->bindParam(':fromdte',$startdate, PDO::PARAM_STR); 
		   $stmt->bindParam(':enddte',$enddate, PDO::PARAM_STR); 		 
		   if($device != "All"){ $stmt->bindParam(':device',$device , PDO::PARAM_STR); }
		   	   
		    $stmt->execute();
		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return json_encode($result);
			/*$response = array();
                  if($result)
                  {
                    
                     $response["Data"] = $result;
                     return json_encode($response);
                  }
				*/  

		}
		catch(PDOException $ex)
		{
			echo $ex;
		}
		   
	}	
}

?>