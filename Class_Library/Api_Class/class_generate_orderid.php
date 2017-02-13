<?php 
require_once('class_connect_db_mahle.php');
require_once('class_connect_db_admin.php');
class AddOrderId
{
    public $db_connect;
    public function __construct()
    {
        $dbh = new Connection_Mahle();
	$this->db_mahle =  $dbh->getConnection_Mahle();
	
	 $dbh = new Connection();
	$this->db_admin =  $dbh->getConnection();
    }
 function addOrderId($clientId,$emailid,$orderid)
 {
 
       date_default_timezone_set("Asia/Kolkata");
          $curdatesus = date("Y/m/d h:i:sa");

try {
 $query = "select * from Tbl_EmployeeDetails_Master where emailId=:email and clientId = :cid";
 $query_params = array(':email' => $emailid,':cid' => $clientId);

    $stmt   = $this->db_mahle->prepare($query);
    $result = $stmt->execute($query_params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
     if(count($rows)>0)
     {
     $query1 = "insert into cashbackorder(email,orderid,orderdate) VALUES(:mail,:order,:cur)";
       $query_params1 = array(':mail' => $emailid, ':order' => $orderid, ':cur' => $curdatesus);
        $stmt1   = $this->db_admin->prepare($query1);
        $result1 = $stmt1->execute($query_params1);
       $response['success'] = 1;
       $response['message'] = 'orderid generated';
     }
     else
     {
     $response['success'] = 0;
     $response['message'] = 'email id not found';
     }

}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error !";
  
}

return  $response;

}
}
?>		