<?php
include_once('class_connect_db_Communication.php');

class Group
{
  public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
	$this->DB = $db->getConnection_Communication();	
  
  }
  
  function getMaxId() {
    		  try{
			$max = "select max(autoId) from Tbl_ClientGroupDetails";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$channelid = "Group".$m_id1;
                              //  $channel = "Channel".$m_id1."User"; 
				return $channelid;
				}
				
			}
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
  
  }
   function getAdminMaxId()
  {
    		  try{
			$max = "select max(autoId) from Tbl_ClientAdminDetails";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$adminid = "AD".$m_id1;
                              //  $channel = "Channel".$m_id1."User"; 
				return $adminid;
				}
				
			}
			catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
  
  }
  public $clientid;
  public $groupid;
  public $groupname;
  public $gd;
  public $cd;
  public $cb;
  public $status;
  
  function createGroup($clientid,$groupid,$groupname,$groupdescription,$createdby,$createddate,$status)
  {
     $this->clientid = $clientid;
     $this->groupid  = $groupid;
     $this->groupname = $groupname;
     $this->gd = $groupdescription;
     $this->cd = $createddate;
     $this->cb = $createdby;
     $this->status = $status;
     
     try{
     $query = "insert into Tbl_ClientGroupDetails(clientId,groupId,groupName,groupDescription,createdBy,createdDate,status)
            values(:cid,:gid,:gname,:gd,:cb,:cd,:st)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid',$this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':gname',$this->groupname, PDO::PARAM_STR);
            $stmt->bindParam(':gd',$this->gd, PDO::PARAM_STR);
            $stmt->bindParam(':cb',$this->cb, PDO::PARAM_STR);
            $stmt->bindParam(':cd',$this->cd, PDO::PARAM_STR);
             $stmt->bindParam(':st',$this->status, PDO::PARAM_STR);
           if($stmt->execute())
           {
           $result['success'] = 1;
           $result['msg'] = "data send";
           return $result;
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}

public $adminuniqueid;
     function createGroupAdmin($clientid,$groupid,$uuid,$cb)
  {
     $this->clientid = $clientid;
     $this->groupid  = $groupid;
     $this->adminuniqueid = $uuid;
      $this->cb = $cb;
     
     try{
     $query = "insert into Tbl_ClientGroupAdmin(clientId,groupId,userUniqueId,createdBy,createdDate)
            values(:cid,:gid,:aid,:cb,:cdate)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid',$this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':aid',$this->adminuniqueid, PDO::PARAM_STR);
            $stmt->bindParam(':cb',$this->cb, PDO::PARAM_STR);
            $stmt->bindParam(':cdate',date('Y-m-d H:i:s'), PDO::PARAM_STR);
             
           if($stmt->execute())
           {
           $result['success'] = 1;
           $result['msg'] = "data send";
           return $result;
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}
public $columnname;
public $columnvalue;
function createGroupDemoGraphy($clientid,$groupid,$cname,$cvalue,$createdby)
  {
     $this->clientid = $clientid;
     $this->groupid  = $groupid;
     $this->columnname = trim($cname);
     $this->columnvalue = trim($cvalue);
     $this->createdby   = trim($createdby);
     
     
     try{
     $query = "insert into Tbl_ClientGroupDemoParam(clientId,groupId,columnName,columnValue,createdDate,createdby)
            values(:cid,:gid,:cname,:cval,:cdate,:cBy)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid',$this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':cname',$this->columnname, PDO::PARAM_STR);
            $stmt->bindParam(':cval',$this->columnvalue, PDO::PARAM_STR);
            $stmt->bindParam(':cBy',$this->createdby, PDO::PARAM_STR);
            $stmt->bindParam(':cdate',date('Y-m-d H:i:s'), PDO::PARAM_STR);
           
           $stmt->execute();
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}

public $adminmaxid;

function createSubAdmin($adminid,$clientid,$uuid,$createdDate,$createdby)
    {
       $this->adminmaxid = $adminid;
     $this->clientid = $clientid;
      $this->adminuniqueid = $uuid;
     $this->cd  = $createdDate; 
     $this->cb = $createdby;
     $status = "Active";
     $access = "SubAdmin";
    // $this->AdminEmail = $adminemail;
     
     try{
     $query = "insert into Tbl_ClientAdminDetails(adminId,clientId,userUniqueId,accessibility,createdDate,createdBy,status)
            values(:aid,:cid,:uid,:access,:cd,:cb,:sta) ON DUPLICATE KEY UPDATE clientId =:cid,accessibility=:access,createdBy=:cb, createdDate=:cd ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':aid', $this->adminmaxid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':uid',$this->adminuniqueid, PDO::PARAM_STR);
             $stmt->bindParam(':access',$access, PDO::PARAM_STR);
            $stmt->bindParam(':cd',$this->cd, PDO::PARAM_STR);
            $stmt->bindParam(':cb',$this->cb, PDO::PARAM_STR);
             $stmt->bindParam(':sta',$status, PDO::PARAM_STR);
           if($stmt->execute())
           {
            $query1 = "update Tbl_EmployeeDetails_Master SET accessibility = :access where employeeId = :uuid and clientId =:cid";
           
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':access', $access, PDO::PARAM_STR);
            $stmt1->bindParam(':uuid',$this->adminuniqueid, PDO::PARAM_STR);
             $stmt1->bindParam(':cid',$this->clientid, PDO::PARAM_STR);
              $stmt1->execute();
           $result['success'] = 1;
           $result['msg'] = "sub admin successfully created";
           return $result;
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
        $result['success'] = 0;
           $result['msg'] = "sub admin successfully not created";
           return $result;
       }
}


}
?>