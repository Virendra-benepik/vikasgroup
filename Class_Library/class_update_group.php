<?php
include_once('class_connect_db_admin.php');
class Group
{
  public $DB;
  public function __construct()
  {
    $db = new Connection();
      $this->DB = $db->getConnection();
  }
  
  function deleteAllData($idclient,$idgroup)
  {

$this->clientid = $idclient;
$this->groupid = $idgroup;

    		  try{
			$query = "delete from ClientGroupDetails where clientId=:cli and groupId=:gri";
			$stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                        $stmt->bindParam(':gri',$this->groupid, PDO::PARAM_STR);

			if($stmt->execute())
			{
                        echo "<script>alert('delete from clientgroupdetails')</script>";
			$query = "delete from ClientGroupAdmin where clientId=:cli and groupId=:gri";
			$stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                        $stmt->bindParam(':gri',$this->groupid, PDO::PARAM_STR);

			if($stmt->execute())
			{
                        echo "<script>alert('delete from ClientGroupAdmin ')</script>";
                        $query = "delete from ClientGroupDemoParam where clientId=:cli and groupId=:gri";
			$stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                        $stmt->bindParam(':gri',$this->groupid, PDO::PARAM_STR);

			if($stmt->execute())
			{
                        echo "<script>alert('delete from ClientGroupDemoParam ')</script>";
                        }
                        }
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
     $query = "insert into ClientGroupDetails(clientId,groupId,groupName,groupDescription,createdBy,createdDate,status)
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

public $adminemail;
     function createGroupAdmin($clientid,$groupid,$adminEmail)
  {
     $this->clientid = $clientid;
     $this->groupid  = $groupid;
     $this->adminemail = $adminEmail;
     
     try{
     $query = "insert into ClientGroupAdmin(clientId,groupId,adminEmail)
            values(:cid,:gid,:aemail)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid',$this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':aemail',$this->adminemail, PDO::PARAM_STR);
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
function createGroupDemoGraphy($clientid,$groupid,$cname,$cvalue)
  {
     $this->clientid = $clientid;
     $this->groupid  = $groupid;
     $this->columnname = trim($cname);
     $this->columnvalue = trim($cvalue);
     
     try{
     $query = "insert into ClientGroupDemoParam(clientId,groupId,columnName,columnValue)
            values(:cid,:gid,:cname,:cval)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid',$this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':cname',$this->columnname, PDO::PARAM_STR);
             $stmt->bindParam(':cval',$this->columnvalue, PDO::PARAM_STR);
           
           $stmt->execute();
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}


}
?>