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
  
  
  function getGroup($clientid)
  {
     $this->clientid = $clientid;
     
     try{
     $query = "select *,DATE_FORMAT(createdDate,'%d %b %Y') as createdDate from Tbl_ClientGroupDetails where clientId=:cli order by autoid desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
           if($rows)
           {
           $result=array();

           $result['success'] = 1;
           $result['message'] = "successfully fetch data";
           $result['posts']=$rows;

           return json_encode($result);
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}

  function getGroupDetails($clientid,$groupid)
  {
     $this->clientid = $clientid;
     $this->groupid = $groupid;
     
     try{
     $query = "select * from Tbl_ClientGroupDetails where clientId=:cli and groupId=:gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
           if($rows)
           {
           $result=array();

           $result['success'] = 1;
           $result['message'] = "successfully fetch data";
           $result['posts']=array();

foreach($rows as $row)
{
$post["clientId"]=$row["clientId"];
$post["groupId"]=$row["groupId"];
$post["groupName"]=$row["groupName"];
$post["groupDescription"]=$row["groupDescription"];

$idclient = $row["clientId"];
$idgroup = $row["groupId"];

$post["adminEmails"]=array();

     $query = "select ud.* from Tbl_EmployeeDetails_Master As ud join Tbl_ClientGroupAdmin as cga on cga.userUniqueId = ud.employeeId
      where cga.clientId=:cli and cga.groupId=:gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt->execute();
            $row1 = $stmt->fetchAll();
          
if($row1)
{
 foreach($row1 as $r)
 {
   $new["adminEmail"]= $r["firstName"]." ".$r["lastName"]." (".$r["emailId"].")";
   array_push($post["adminEmails"],$new);
 }
}

$post["companyName"]=array();
$post["location"]=array();
$post["department"]=array();
$post["grade"]=array();

     $query1 = "select * from Tbl_ClientGroupDemoParam where clientId=:cli and groupId=:gid";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt1->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt1->execute();
            $row2 = $stmt1->fetchAll();
          
if($row2)
{
 foreach($row2 as $row)
 {
   $baseone = $row["columnName"];

if($baseone=='companyName')
{   
$new1["columnValue"]=$row["columnValue"];
array_push($post["companyName"],$new1);
}
else if($baseone=='location')
{   
$new1["columnValue"]=$row["columnValue"];
array_push($post["location"],$new1);
}
else if($baseone=='department')
{   
$new1["columnValue"]=$row["columnValue"];
array_push($post["department"],$new1);
}
else
{
$new1["columnValue"]=$row["columnValue"];
array_push($post["grade"],$new1);
}

 }
}

array_push($result['posts'],$post);
}

           return json_encode($result);
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}

function getPostedGroupDetails($clientid,$postId,$flagType)
  {
     $this->clientid = $clientid;
     $this->postid = $postId;
     
     try{
     $query = "select groupId from Tbl_Analytic_AlbumSentToGroup where clientId=:cli and albumId=:pid and flagType=:ftype";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':ftype', $flagType, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
     }
       catch(PDOException $ex)
       {
       echo $ex;
       }
       return json_encode($rows);
   }
   /********************** get custom group details **********************/

function getCustomGroupDetails($groupid,$cid)
{           
   try{
       $query = "select groupId from Tbl_ClientGroupDetails where clientId = :cid and groupId = :gid and status = 'active' and groupType = 2" ;
      
	  $stmt2 = $this->DB->prepare($query);
            $stmt2->bindParam(':cid',$cid, PDO::PARAM_STR);
            $stmt2->bindParam(':gid',$groupid, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $result=array();
			if(count($rows2['groupId']) > 0)
			{
			$query1 = "select cgd.groupId, tcgd.groupName, tcgd.groupDescription , cgd.employeeId as empcode, edm.employeeId,CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as empname , edm.emailId, edm.contact , edm.department,edm.designation,edm.location,edm.status,edm.accessibility,edm.branch from Tbl_CustomGroupDetails as cgd JOIN Tbl_EmployeeDetails_Master as edm ON cgd.employeeId = edm.employeeCode JOIN Tbl_ClientGroupDetails as tcgd ON cgd.groupId = tcgd.groupId where cgd.clientId = :cid and cgd.groupId = :gid and cgd.status = 'Active' and edm.status = 'Active'";
      
	        $stmt3 = $this->DB->prepare($query1);
            $stmt3->bindParam(':cid',$cid, PDO::PARAM_STR);
            $stmt3->bindParam(':gid',$groupid, PDO::PARAM_STR);
            $stmt3->execute();
            $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
			
			   if($rows3)
			   {
			   $result['success'] = 1;
			   $result['message'] = "data fetch successfully";
			   $result['posts']=$rows3;    
			   } 
			   else
			   {
			   $result['success'] = 0;
			   $result['message'] = "data not fetch";
			   }	
			}
			else
			{
			$result['success'] = 0;
			$result['message'] = "No Group Available";
			}					
	  }  
	  catch (PDOException $es)
      {
		 $result['success'] = 0;
		 $result['message'] = "data not fetch ".$es;	
     }
          return json_encode($result);
}

/******************** / get custom group details **********************/
   
   
}
?>