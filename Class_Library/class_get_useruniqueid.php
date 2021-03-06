<?php 
if ( !class_exists('Connection_Communication') ) { require_once('class_connect_db_Communication.php');}
class UserUniqueId
{
	 public $db_connect;
	 public function __construct()
    {	
		$dbh = new Connection_Communication();
        	$this->db_connect = $dbh->getConnection_Communication();
    }
    
    public $clientid;
    public $empid;
	
    /**************************** get user unique id generated by our system **************/
    function getUserUniqueId($clientid,$employeecode)
    {
    $this->clientid = $clientid;
    $this->empid = $employeecode;
    
    try
    {
    $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cid and employeeCode=:empid";

     $stmt1 = $this->db_connect->prepare($query);
     $stmt1->bindParam(':cid',$this->clientid,PDO::PARAM_STR);
     $stmt1->bindParam(':empid',$this->empid,PDO::PARAM_STR);
     if($stmt1->execute())
     {
     $uuid = $stmt1->fetchAll(PDO::FETCH_ASSOC);
     return json_encode($uuid);
     }
     }
     catch(PDOException $es)
     {
     echo $es;
     }
    
    }
    
    public $uuid;
    
    function getUserData($clientid,$uuid)
    {
    $this->clientid = $clientid;
    $this->uuid = $uuid;
    
    try
    {
    $query = "select ud.*,if(up.userImage IS NULL or up.userImage ='','', Concat('".SITE_URL."',up.userImage)) as userImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on ud.employeeId = up.employeeId where ud.clientId=:cid and ud.employeeId=:uid or ud.autoId=:uid";
     $stmt1 = $this->db_connect->prepare($query);
     $stmt1->bindParam(':cid',$this->clientid,PDO::PARAM_STR);
     $stmt1->bindParam(':uid',$this->uuid,PDO::PARAM_STR);
     if($stmt1->execute())
     {
     $udata= $stmt1->fetchAll(PDO::FETCH_ASSOC);
     return json_encode($udata);
     }
     }
     catch(PDOException $es)
     {
     echo $es;
     }
    
    }
 }
    ?>