<?php 
require_once('class_connect_db_Communication.php');

class RecognizeUserAccount
{
	 public $db_connect;
	 public function __construct()
        {
        $dbh = new Connection_Communication(/*...*/);
		$this->db_connect =  $dbh->getConnection_Communication();
         }
    
    public $clientid;
   
    public $uuid;
    
    function getRecognitionUserAccountData($clientid,$uuid)
    {
    $this->clientid = $clientid;
    $this->uuid = $uuid;
    
    try
    {
  
    $query  = "SELECT *
FROM (
(
SELECT DATE_FORMAT(rpd.entryDate,'%d %b %Y %h:%i %p') as entryDate, concat('Earn') as Type, rpd.userId, concat(ud.firstName,' ',ud.lastName) as RecognizeBy, rpd.points AS EarningPoint, concat( '0' ) AS redeempoint
FROM Tbl_RecognizeApprovDetails AS rpd join Tbl_EmployeeDetails_Master as ud on rpd.recognizeBy = ud.employeeId where rpd.clientId = :cid and rpd.userId = :uid
)
UNION ALL (
SELECT DATE_FORMAT(rrd.entryDate,'%d %b %Y %h:%i %p') as entryDate,concat('Redeem') as Type, rrd.uid, concat('Self') as RecognizeBy, concat( '0' ) AS EarningPoint, rrd.voucherAmount
FROM Tbl_RecognizeRedeemDetails AS rrd where rrd.clientId = :cid and rrd.uid = :uid
)
)results  ORDER BY entryDate ASC";


     $stmt1 = $this->db_connect->prepare($query);
     $stmt1->bindParam(':cid',$this->clientid,PDO::PARAM_STR);
     $stmt1->bindParam(':uid',$this->uuid,PDO::PARAM_STR);
     $stmt1->execute();
    
     $udata= $stmt1->fetchAll(PDO::FETCH_ASSOC);
  
     $countdetails = count($udata);
    // echo "count details ".$countdetails;
     if($countdetails>0)
     {
       $result["success"] = 1;
       $result["msg"] = "recognize data found";
       $result["data"] = $udata;    
        return json_encode($result);
     }
     else
     {
      $result["success"] = 0;
       $result["msg"] = "user account details not found";
       return json_encode($result);
     }
     }
     catch(PDOException $es)
     {
     echo $es;
     }
    
    }
    
    
    /********************************************************************************************************/
    
    function getUserAccountBalance($clientid1,$userid1)
    {
    $this->clientid = $clientid1;
    $this->uuid = $userid1;
 //   echo "this is user id:-".$this->uuid;
    try
    {

    $query = "select Tbl_EmployeePersonalDetails.userImage from Tbl_EmployeePersonalDetails join Tbl_EmployeeDetails_Master on Tbl_EmployeePersonalDetails.clientId = Tbl_EmployeeDetails_Master.clientId and Tbl_EmployeePersonalDetails.employeeId = Tbl_EmployeeDetails_Master.employeeId where Tbl_EmployeePersonalDetails.clientId =:cid and Tbl_EmployeeDetails_Master.employeeId =:uid";
     $stmt2 = $this->db_connect->prepare($query);
     $stmt2->bindParam(':cid',$this->clientid,PDO::PARAM_STR);
     $stmt2->bindParam(':uid',$this->uuid,PDO::PARAM_STR);
     $stmt2->execute();
     $UserImage = $stmt2->fetch(PDO::FETCH_ASSOC);


    $query = "select SUM(points) as TotalAmount from Tbl_RecognizeApprovDetails where clientId = :cid and userId = :uid";
     $stmt1 = $this->db_connect->prepare($query);
     $stmt1->bindParam(':cid',$this->clientid,PDO::PARAM_STR);
     $stmt1->bindParam(':uid',$this->uuid,PDO::PARAM_STR);
     $stmt1->execute();
     $account = $stmt1->fetch(PDO::FETCH_ASSOC);
  
    if($account['TotalAmount']<0 || $account['TotalAmount']==NULL)
    {
    $account['TotalAmount'] = 0;   
    }
     $query1 = "select SUM(voucherAmount) as TotalRedeemAmount from Tbl_RecognizeApprovDetails where clientId =:cid1 and uid =:uid1";
     $stmt2 = $this->db_connect->prepare($query1);
     $stmt2->bindParam(':cid1',$this->clientid,PDO::PARAM_STR);
     $stmt2->bindParam(':uid1',$this->uuid,PDO::PARAM_STR);
     $stmt2->execute();
     $account1 = $stmt2->fetch(PDO::FETCH_ASSOC);
      if($account1['TotalRedeemAmount']<0 || $account1['TotalRedeemAmount']==NULL)
    {
    $account1['TotalRedeemAmount'] = 0;   
    }
  
    $res['success'] = 1;
    $res['msg'] = 'data found';
    $res['userImage']= "http://admin.benepik.com/employee/virendra/benepik_admin/".$UserImage['userImage'];
    $res['Totalamount'] = $account['TotalAmount'];
    $res['TotalRedeem'] = $account1['TotalRedeemAmount'];
    $res['balance'] = $account['TotalAmount'] - $account1['TotalRedeemAmount'];
    }
    catch(PDOException $rt)
    {
    echo $rt;
    $res['success'] = 0;
    $res['msg'] = 'data not found';
    }
    return json_encode($res);
    }
 }
    ?>