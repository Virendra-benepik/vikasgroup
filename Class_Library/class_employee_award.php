<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('class_connect_db_Communication.php');
if (!class_exists('FindGroup')) {
    require_once('Api_Class/class_find_groupid.php');     // this class for get group id on the base of unique id
}

class AwardDisplay
{

 public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
  }

function AwardDisplays($clientid,$uid,$val,$module = '')
  {

    $this->idclient = $clientid;
     $this->value = $val;
     
      
     $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt->bindParam(':empid',$uid, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetch();

               if(count($rows)>0)
                  {
	$uuids = $rows["employeeId"];
  $group_object = new FindGroup();    // this is object to find group id of given unique id 
     
     $getgroup = $group_object->groupBaseofUid($clientid,$uuids);
        $value = json_decode($getgroup,true);
        if(count($value['groups'])>0)
        {
        $in = implode("', '", array_values(array_unique($value['groups'])));
 //echo "group ".$in."<br/>";
          try{
             $query1 = "select distinct(awardId) from Tbl_Analytic_AwardSentToGroup where clientId=:cli and groupId IN ('".$in."') order by autoId desc limit ".$this->value.",5";
             $stmt1 = $this->DB->prepare($query1);
             $stmt1->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
           //  $stmt1->bindParam(':uid',$uuids, PDO::PARAM_STR);
             $stmt1->execute();
             $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
           
             $response["success"]=1;
             $response["message"]="Employee Award data available for you";

    $query2 = "select count(distinct(awardId)) as total_empaward from Tbl_Analytic_AwardSentToGroup where clientId=:cli and groupId IN ('".$in."')";
             $stmt2 = $this->DB->prepare($query2);
             $stmt2->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
            // $stmt2->bindParam(':uid',$uuids, PDO::PARAM_STR);
             $stmt2->execute();
             $rows21 = $stmt2->fetch(PDO::FETCH_ASSOC);
             $response["total_award"]=$rows21["total_empaward"];

//$ert = array_values(array_unique($rows1));
             $response["posts"]=array();
        //  print_r($rows1);
if(count($rows1)>0)
{
$status = 1;
foreach($rows1 as $row)
{
$post["awardId"]=$row["awardId"];
$empawardid = $row["awardId"];

//echo "post id-".$empawardid."<br>";

$query2 = "SELECT empaw.clientId, empaw.employeeAwardId,empaw.employeeId,empaw.commentDesc, DATE_FORMAT(empaw.awardDate,'%d %b %Y %h:%i %p') as awardDate, AM.awardName, AM.awardDescription, UD.firstName, UD.middleName, UD.lastName, UD.designation, UD.location, UD.department, UPD.userImage
FROM Tbl_C_EmployeeAward AS empaw
JOIN Tbl_Client_AwardMaster AS AM ON empaw.awardId = AM.awardId
JOIN Tbl_EmployeeDetails_Master AS UD ON UD.autoId = empaw.employeeId
JOIN Tbl_EmployeePersonalDetails AS UPD ON UPD.employeeId = UD.employeeID
WHERE empaw.employeeAwardId =:awid and empaw.clientId =:cli and empaw.status = :sta";

             $stmt2 = $this->DB->prepare($query2);
             $stmt2->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt2->bindParam(':awid',$empawardid, PDO::PARAM_STR);
             $stmt2->bindParam(':sta',$status, PDO::PARAM_STR);
             $stmt2->execute();
             $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
/*echo "this is award details-----";
echo "<pre>";
print_r($rows2);
echo "</pre>";*/
if(count($rows2)>0)
{
//echo "hello";
$post["clientId"] = $rows2[0]["clientId"];
$post["employeeAwardId"]=$rows2[0]["employeeAwardId"];
$post["employeeId"]=$rows2[0]["employeeId"];
$post["commentDesc"]=$rows2[0]["commentDesc"];
$post["awardcreatedDate"]=$rows2[0]["awardDate"];
$post["awardName"]=$rows2[0]["awardName"];
$post["awardDescription"]=$rows2[0]["awardDescription"];
$post["firstName"]=$rows2[0]["firstName"];
$post["middleName"]=$rows2[0]["middleName"];
$post["lastName"]=$rows2[0]["lastName"];
$post["designation"]=$rows2[0]["designation"];
$post["location"]=$rows2[0]["location"];
$post["department"]=$rows2[0]["department"];
$post["userImage"]=$rows2[0]["userImage"];

$post['awards'] = array();
$query3 = "SELECT EW.awardId, EW.employeeId, count(EW.awardId) as awardcount, AM.awardName, AM.imageName FROM Tbl_C_EmployeeAward AS EW join Tbl_Client_AwardMaster as AM ON AM.awardId = EW.awardId WHERE EW.employeeId =:eid GROUP BY EW.awardId";
 $stmt3 = $this->DB->prepare($query3);
             $stmt3->bindParam(':eid',$rows2[0]["employeeId"], PDO::PARAM_STR);
             $stmt3->execute();
               $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
           
             
 if(count($rows3)>0)
 {      for($k=0; $k<count($rows3); $k++)  
 {    
  $award["awardId"] = $rows3[$k]["awardId"];
  $award["employeeId"] = $rows3[$k]["employeeId"];
$award["awardcount"]=$rows3[$k]["awardcount"];
$award["awardName"]=$rows3[$k]["awardName"];
$award["imageName"]=$rows3[$k]["imageName"];
array_push($post["awards"],$award);
}
}
array_push($response["posts"],$post);
}


}
  return $response;

}
else
{

                  $response["success"]=0;
                  $response["message"]="No Data available for you";
                  return $response;
}
                  }
                  catch(PDOException $e)
    			 {
    			 echo $e;
    			 }
    		 }
                 else
                  {
                  $response["success"]=0;
                  $response["message"]="You are not selected in any group";
                  return $response;
                 }
                  }
                   else
                  {
                  $response["success"]=0;
                  $response["message"]="Sorry ! You are not Authorized person";
                  return $response;
                 }
}
}
?>