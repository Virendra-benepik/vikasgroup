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
     $query = "select * from Tbl_ClientGroupDetails where clientId=:cli order by autoid desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
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

function GrgetGroupDetails($clientid,$groupid)
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

$idclient = $rows[0]["clientId"];
$idgroup = $rows[0]["groupId"];


     $query = "select adminEmail from Tbl_ClientGroupAdmin where clientId=:cli and groupId=:gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt->execute();
            $row1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$post["groupName"]=$rows[0]["groupName"];
$post["groupDescription"]=$rows[0]["groupDescription"];
$post["adminEmails"] =$row1; 
$post["demographics"] = array();

     $query1 = "select distinct(columnName) from Tbl_ClientGroupDemoParam where clientId=:cli and groupId=:gid";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt1->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt1->execute();
            $row2 = $stmt1->fetchAll();
          
if($row2)
{
/*$count = count($row2["columnName"]);
echo "Total no. records executed:- ".$count."<br>";
*/

foreach($row2 as $row)
{
$baseon = $row["columnName"];
     $query2 = "select columnValue from Tbl_ClientGroupDemoParam where clientId=:cli and groupId=:gid and columnName=:col";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt2->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt2->bindParam(':col', $baseon, PDO::PARAM_STR);
            $stmt2->execute();
            $row3 = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);

         if($row3)
            {
                 $postr["columnName"]=$baseon;
                 $postr["columnValue"]=$row3;
                 array_push($post["demographics"],$postr);
            }
   }

}
$result["posts"] = $post;

           return json_encode($result);
	    }
     }
       catch(PDOException $ex)
       {
       echo $ex;
       }
   }

}
?>