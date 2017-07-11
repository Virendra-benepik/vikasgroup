<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

class LoginAnalytic {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    /*     * ************************************************************************************************** */

    function userAppInstalltion($clientid, $startdate, $enddate, $device) {
        /* echo $clientid; */
        //echo $startdate;
        //echo $enddate;
        /* echo $device;  */
        // $contractDateBegin = date('Y-m-d', strtotime($startdate));
        //$contractDateEnd = date('Y-m-d', strtotime($enddate));
        // echo $contractDateBegin;
        //echo $contractDateEnd;
        try {
            if ($device == "All") {
                $query = "SELECT edm.employeeCode,edm.firstName, edm.lastName, edm.department, edm.location, gcm.deviceName,DATE_FORMAT(gcm.date_entry_time,'%d %b %Y') as date_entry_time, gcm.appVersion FROM Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeeGCMDetails as gcm ON edm.employeeId = gcm.userUniqueId where (DATE(gcm.date_entry_time) BETWEEN :fromdte AND :enddte)  AND edm.clientId=:client order by edm.firstName,gcm.date_entry_time desc";
            } else {
                $query = "SELECT edm.employeeCode,edm.firstName,edm.lastName, edm.department, edm.location, gcm.deviceName,DATE_FORMAT(gcm.date_entry_time,'%d %b %Y') as date_entry_time, gcm.appVersion FROM Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeeGCMDetails as gcm ON edm.employeeId = gcm.userUniqueId where (DATE(gcm.date_entry_time) BETWEEN :fromdte AND :enddte)  AND gcm.deviceName = :device and edm.clientId=:client order by edm.firstName,gcm.date_entry_time desc";
            }
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $startdate, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddate, PDO::PARAM_STR);
            if ($device != "All") {
                $stmt->bindParam(':device', $device, PDO::PARAM_STR);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ***************************************************************************************************** */

    /*     * ********************************************* add shared post **************************************** */

    function addSharePost($clientid, $createdBy, $platform, $moduleId, $flag, $device) {

        date_default_timezone_set('Asia/Calcutta');
        $createdDate = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_ShareData(clientId,createdBy,platform,moduleId,flagCheck,	createdDate,device)
            values(:cid,:cb,:platform,:id,:flag,:cd,:device)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $createdBy, PDO::PARAM_STR);
            $stmt->bindParam(':platform', $platform, PDO::PARAM_STR);
            $stmt->bindParam(':id', $moduleId, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_INT);
            $stmt->bindParam(':cd', $createdDate, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully Shared Data";
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "Not Shared ";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ****************************************** end add shared post ***************************************** */

    /*     * ***************************************** invite user ************************************************** */

    function inviteUser($clientid, $createdBy, $inviteType, $usermobile, $device) {

        date_default_timezone_set('Asia/Calcutta');
        $createdDate = date("Y-m-d H:i:s");

        try {
            $query = "insert into Tbl_Analytic_InviteUser(clientId, userMobile, inviteType, deviceName, createdBy, createdDate)
            values(:cid,:mobile,:invitetype,:device,:cb,:cd)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $createdBy, PDO::PARAM_STR);
            $stmt->bindParam(':invitetype', $inviteType, PDO::PARAM_STR);
            $stmt->bindParam(':mobile', $usermobile, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $createdDate, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "user Invited";
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "Not Invited";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ***************************************** end invite user ********************************************** */

    /*     * ***************************************** view shared post *********************************************** */

    function ViewSharedPost($clientid, $startdate, $enddate, $module) {
        $path = SITE_URL;
        try {
            if ($module == 0) {
                $query = "select tsd.id	as sharedId, tsd.platform, tsd.device, tsd.moduleId, tsd.flagCheck, DATE_FORMAT(tsd.createdDate,'%d %b %Y') as createdDate, twd.title, if(twd.image ='','images/u.png', twd.image) as image,CONCAT(edm.firstName,' ',edm.lastName) as name from Tbl_Analytic_ShareData as tsd JOIN `Tbl_C_WelcomeDetails` as twd ON tsd.moduleId = twd.id AND tsd.flagCheck = twd.flagType JOIN Tbl_EmployeeDetails_Master as edm ON tsd.createdBy = edm.employeeId where (DATE(tsd.createdDate) BETWEEN :fromdte AND :enddte)  AND tsd.clientId=:client order by tsd.createdDate desc";
            } else {

                $query = "select tsd.id	as sharedId, tsd.platform, tsd.device, tsd.moduleId, tsd.flagCheck, DATE_FORMAT(tsd.createdDate,'%d %b %Y') as createdDate, twd.title, if(twd.image ='','images/u.png', twd.image) as image,CONCAT(edm.firstName,' ',edm.lastName) as name from Tbl_Analytic_ShareData as tsd JOIN `Tbl_C_WelcomeDetails` as twd ON tsd.moduleId = twd.id AND tsd.flagCheck = twd.flagType JOIN Tbl_EmployeeDetails_Master as edm ON tsd.createdBy = edm.employeeId where (DATE(tsd.createdDate) BETWEEN :fromdte AND :enddte) AND tsd.clientId=:client AND tsd.flagCheck = :module order by tsd.createdDate desc";
            }
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $startdate, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddate, PDO::PARAM_STR);
            if ($module != 0) {
                $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ***************************************** end view shared post ******************************************* */

    /*     * ********************************************** view job detail ********************************************* */

    function ViewJobDetail($clientid, $startdate, $enddate) {

        try {

            $query = "select tjp.jobTitle, DATE_FORMAT(tjp.createdDate,'%d %b %Y') as createdDate , CONCAT(edm.firstName,' ',edm.lastName) as name, tjp.jobLocation, tjp.device , tjp.companyName from Tbl_C_JobPost as tjp JOIN Tbl_EmployeeDetails_Master as edm ON tjp.createdBy = edm.employeeId where(DATE(tjp.createdDate) BETWEEN :fromdte AND :enddte)  AND tjp.clientId=:client order by tjp.createdDate desc";

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $startdate, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddate, PDO::PARAM_STR);


            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * *************************************************** end view job detail ************************************ */

    /*     * *************************************************** view invite user ****************************************** */

    function ViewInviteUser($clientid, $startdate, $enddate, $invitetype) {

        try {
            if ($invitetype == 'all') {
                $query = "select tiu.inviteType, DATE_FORMAT(tiu.createdDate,'%d %b %Y') as createdDate , CONCAT(edm.firstName,' ',edm.lastName) as name, tiu.deviceName from Tbl_Analytic_InviteUser as tiu JOIN Tbl_EmployeeDetails_Master as edm ON tiu.createdBy = edm.employeeId where(DATE(tiu.createdDate) BETWEEN :fromdte AND :enddte)  AND tiu.clientId=:client order by tiu.createdDate desc";
            } else {
                $query = "select tiu.inviteType, DATE_FORMAT(tiu.createdDate,'%d %b %Y') as createdDate , CONCAT(edm.firstName,' ',edm.lastName) as name, tiu.deviceName from Tbl_Analytic_InviteUser as tiu JOIN Tbl_EmployeeDetails_Master as edm ON tiu.createdBy = edm.employeeId where(DATE(tiu.createdDate) BETWEEN :fromdte AND :enddte) AND tiu.clientId=:client AND inviteType = :invitetype order by tiu.createdDate desc";
            }

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $startdate, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddate, PDO::PARAM_STR);
            if ($invitetype != 'all') {
                $stmt->bindParam(':invitetype', $invitetype, PDO::PARAM_STR);
            }


            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ************************************************* end view invite user **************************************** */

    /*     * ******************************************* analytic login graph ********************************************** */

    function userAnalyticLoginGraph($client, $fromdt, $enddte, $searchby) {
        try {
            if ($searchby == 1) {

                $query = "SELECT distinct deviceName as label, count(deviceName) as value FROM Tbl_EmployeeGCMDetails where (DATE(date_entry_time) BETWEEN :fromdte AND :enddte) AND clientId = :client group by deviceName";
            }
            if ($searchby == 2) {

                $query = "SELECT distinct department as label, count(department) as value FROM Tbl_EmployeeDetails_Master where (DATE(createdDate) BETWEEN :fromdte AND :enddte) AND clientId = :client group by department";
            }
            if ($searchby == 3) {
                $query = "SELECT distinct location as label, count(location) as value FROM Tbl_EmployeeDetails_Master where (DATE(createdDate) BETWEEN :fromdte AND :enddte) AND clientId = :client group by location";
            }

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ******************************************** end analytic login graph ***************************************** */
	
	/*     * ******************************************* analytic login graph ********************************************** */

    function AnalyticLoginGraphUser($client, $fromdt, $enddte, $searchby) {
        try {
            if ($searchby == "All") {

                $query = "SELECT distinct deviceName as label, count(deviceName) as value FROM Tbl_EmployeeGCMDetails where (DATE(date_entry_time) BETWEEN :fromdte AND :enddte) AND clientId = :client group by deviceName";
            }
            else 
			{
                $query = "SELECT distinct deviceName as label, count(deviceName) as value FROM Tbl_EmployeeGCMDetails where (DATE(date_entry_time) BETWEEN :fromdte AND :enddte) AND clientId = :client AND deviceName = :searchby";
            }
            

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
			if($searchby != "All"){$stmt->bindParam(':searchby', $searchby, PDO::PARAM_STR);}
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ******************************************** end analytic login graph ***************************************** */
	
	
	/*********************** analytic graph user invite ********************************/
	
	function GraphUserInvite($client, $fromdt, $enddte, $searchby) {
        try {
            if ($searchby == "all") {

                $query = "SELECT distinct inviteType as label, count(inviteType) as value FROM Tbl_Analytic_InviteUser where (DATE(createdDate) BETWEEN :fromdte AND :enddte) AND clientId = :client group by inviteType";
            }
            else 
			{
                $query = "SELECT distinct inviteType as label, count(inviteType) as value FROM Tbl_Analytic_InviteUser where (DATE(createdDate) BETWEEN :fromdte AND :enddte) AND clientId = :client AND inviteType = :searchby";
            }
            

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
			if($searchby != "all"){$stmt->bindParam(':searchby', $searchby, PDO::PARAM_STR);}
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }
	
	/************************ end analytic graph user invite ***************************/
	
/*********************** analytic graph shared post ********************************/
	
	function GraphSharePost($client, $fromdt, $enddte, $searchby) {
        try {
            if ($searchby == 0) {

               /* $query = "SELECT distinct flagCheck as label, count(flagCheck) as value FROM Tbl_Analytic_ShareData where (DATE(createdDate) BETWEEN :fromdte AND :enddte) AND clientId = :client group by flagCheck";*/
			   
			   $query = "SELECT FlagMaster.moduleName as label, count(Tbl_Analytic_ShareData.flagCheck) as value FROM Tbl_Analytic_ShareData JOIN FlagMaster ON Tbl_Analytic_ShareData.flagCheck = FlagMaster.flagId where (DATE(Tbl_Analytic_ShareData.createdDate) BETWEEN :fromdte AND :enddte) AND Tbl_Analytic_ShareData.clientId = :client group by Tbl_Analytic_ShareData.flagCheck";
			   
            }
            else 
			{
                $query = "SELECT FlagMaster.moduleName as label, count(Tbl_Analytic_ShareData.flagCheck) as value FROM Tbl_Analytic_ShareData JOIN FlagMaster ON Tbl_Analytic_ShareData.flagCheck = FlagMaster.flagId where (DATE(Tbl_Analytic_ShareData.createdDate) BETWEEN :fromdte AND :enddte) AND Tbl_Analytic_ShareData.clientId = :client AND Tbl_Analytic_ShareData.flagCheck = :searchby";
            }
            

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
			if($searchby != 0){$stmt->bindParam(':searchby', $searchby, PDO::PARAM_STR);}
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }
	
	/************************ end analytic graph shared post ***************************/
	
/*********************** analytic get active user Details ********************************/
	
	function graphGetActiveUser($client, $fromdt, $enddte,$company) {
        try {
           
	$query =  " SELECT count(track.userUniqueId) as totalview,count(distinct(track.userUniqueId)) as uniqueview,DATE_FORMAT(track.date_of_entry,'%d/%m/%Y') as date_of_entry FROM Tbl_Analytic_TrackUser as track JOIN Tbl_EmployeeDetails_Master as edm ON track.userUniqueId = edm.employeeId where (DATE(track.date_of_entry) BETWEEN :fromdte AND :enddte) AND track.clientId = :client";
	
          if ($company == 'All'){
                $query .= "";}
				
          if ($company != 'All'){
           $query .= " AND edm.companyUniqueId = :comp";}
						
         $query .= " group by DATE_FORMAT(track.date_of_entry,'%Y-%m-%d')";
         
         
      $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            if($company != 'All'){$stmt->bindParam(':comp', $company, PDO::PARAM_STR);}
			$stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result,JSON_NUMERIC_CHECK);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }
	
	/************************ end analytic graph Job Details ***************************/
    
    function graphGetActiveUserCompany($client, $fromdt, $enddte) {
        try {
           
	$query =  "SELECT count(track.userUniqueId) as totalview,count(distinct(track.userUniqueId)) as uniqueview,edm.companyName FROM Tbl_Analytic_TrackUser as track JOIN Tbl_EmployeeDetails_Master as edm ON track.userUniqueId = edm.employeeId where (DATE(track.date_of_entry) BETWEEN :fromdte AND :enddte) AND track.clientId = :client group by edm.companyUniqueId";
	
      $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
          
	$stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result,JSON_NUMERIC_CHECK);
            /* $response = array();
              if($result)
              {

              $response["Data"] = $result;
              return json_encode($response);
              }
             */
        } catch (PDOException $ex) {
            echo $ex;
        }
    }
    
}

?>