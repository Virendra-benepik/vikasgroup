<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists("Connection_Communication")) {
    require_once('class_connect_db_Communication.php');
}

class subadmin {

    public $DB;

    public function __construct() {

        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }
/**************************** find max id ****************************/
    function getMaxadminid() {
        try {
            $max = "select max(autoId) from  Tbl_ClientAdminDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $eid = "AD-" . $m_id1;

                return $eid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }
/********************************* end find max id ****************************/
   
    /******************************** add admin ******************************** */

    function create_Subadmin($companyname,$empcode,$uuid,$subadminid,$clientid,$createdby) {
		
		date_default_timezone_set('Asia/Calcutta');
        $date = date('Y-m-d H:i:s A');
       
        try {
			
			$query = "select edm.employeeCode, edm.employeeId, edm.status, edm.accessibility, CONCAT(edm.firstName,' ',edm.lastName) as userName, epd.userCompanyname,comdet.companyName from Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeCode = epd.employeeCode AND edm.employeeId = epd.employeeId JOIN Tbl_ClientDetails_Master as cdm ON edm.clientId = cdm.client_id JOIN Tbl_Client_CompanyDetails as comdet ON epd.userCompanyname = comdet.companyId where edm.clientId = :clientid AND edm.employeeCode = :empcode and comdet.companyName = :comname And (edm.accessibility = 'User' Or edm.accessibility = 'subadmin') and edm.status = 'Active'";
								 
            $stmt = $this->DB->prepare($query);
            $stmt->bindparam(':empcode', $empcode, PDO::PARAM_STR);
            $stmt->bindparam(':clientid', $clientid, PDO::PARAM_STR);
			$stmt->bindparam(':comname', $companyname, PDO::PARAM_STR);
            $stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//echo "<pre>";
			//print_r($rows);
			$rowcount = count($rows);
			
			if($rowcount > 0)
			{
				$currentaccessbility = $rows[0]['accessibility'];
				$subadminempcode = $rows[0]['employeeCode'];
			    $subadminempid = $rows[0]['employeeId'];
			    $subadmincomid = $rows[0]['userCompanyname'];
				$subadminaccess = 'subadmin';
				$subadminstatus = 1;
					
				if($currentaccessbility == 'subadmin')
				{
				$query1 = "update Tbl_ClientAdminDetails set clientId = :clientid , accessibility = :accessibility , updatedDate = :createddate, updatedBy = :createdby, status = :status, companyId = :comid where userUniqueId = :empid";
				}
				else
				{
				$query1 = "insert into Tbl_ClientAdminDetails(adminId, clientId, userUniqueId, accessibility, createdDate, 	createdBy, status, companyId)values(:adminid, :clientid, :empid, :accessibility, :createddate, :createdby, :status , :comid )";
				}				 
				$stmt1 = $this->DB->prepare($query1);
				$stmt1->bindparam(':empid', $subadminempid, PDO::PARAM_STR);
				$stmt1->bindparam(':clientid', $clientid, PDO::PARAM_STR);
				$stmt1->bindparam(':comid', $subadmincomid, PDO::PARAM_STR);
				if($currentaccessbility != 'subadmin')
				{
					$stmt1->bindparam(':adminid', $subadminid, PDO::PARAM_STR);
				}
				$stmt1->bindparam(':accessibility', $subadminaccess, PDO::PARAM_STR);
				$stmt1->bindparam(':status', $subadminstatus, PDO::PARAM_STR);
				$stmt1->bindparam(':createddate', $date, PDO::PARAM_STR);
				$stmt1->bindparam(':createdby', $createdby, PDO::PARAM_STR);
				$stmt1->execute();
			
				
				$query2 = "update Tbl_EmployeeDetails_Master set accessibility = :accessibility where clientId =:clientid AND employeeCode = :subadminempcode And employeeId = :subadminempid ";
								 
				$stmt2 = $this->DB->prepare($query2);
				$stmt2->bindparam(':accessibility', $subadminaccess, PDO::PARAM_STR);
				$stmt2->bindparam(':subadminempcode', $subadminempcode, PDO::PARAM_STR);
				$stmt2->bindparam(':subadminempid', $subadminempid, PDO::PARAM_STR);
				$stmt2->bindparam(':clientid', $clientid, PDO::PARAM_STR);
				
				
				if($stmt2->execute())
				{
				$response["success"] = 1;
                $response["message"] = "Subadmin Created Successfully";
				return json_encode($response);
				}
				else
				{
				$response["success"] = 0;
                $response["message"] = "Subadmin not Created";
				return json_encode($response);
				}	
				
			}
			else
			{
				$response["success"] = 0;
                $response["message"] = "Please enter correct Employee Code and Company Name";
				return json_encode($response);
			}
			
		}
         catch (PDOException $ex) {
           $response["success"] = 0;
           $response["message"] = "Error".$ex;
		   return json_encode($response);
        }
    }
/******************************** end add admin **********************************/


}

?>