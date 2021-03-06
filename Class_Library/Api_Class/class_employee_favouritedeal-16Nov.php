<?php 
require_once('class_connect_db_deal.php');
require_once('class_connect_db_Communication.php');

class Favourite
{
	 public $db_connect;
	 public $db_mahle;

    public function __construct()
    {
        $dbh = new Connection_Deal(/*...*/);
	$this->db_connect =  $dbh->getConnection_Deal();

        $dbh1 = new Connection_Communication();
	$this->db_mahle =  $dbh1->getConnection_Communication();
    }
  function AddToFavourite($clientid,$employeeid,$dealid,$branchid)
 {
 date_default_timezone_set('Asia/Calcutta');
$fav_date = date('Y-m-d H:i:s');
 try{
		$query = "insert into BranchWish(clientId,branchId,dealId,employeeId,createdDate) values(:cli,:bri,:dli,:emi,:dte)";
	        $stmt = $this->db_connect->prepare($query);                              
                $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
                $stmt->bindParam(':bri',$branchid, PDO::PARAM_STR); 
                $stmt->bindParam(':dli',$dealid, PDO::PARAM_STR); 
                $stmt->bindParam(':emi',$employeeid, PDO::PARAM_STR);
                 $stmt->bindParam(':dte',$fav_date, PDO::PARAM_STR);
                
                   if($stmt->execute())
                   {
                   $response = array();
		   $response["success"] = 1;
		   $response["message"] = "Add to Favourite successfully";
		   }
		   else{
                   $response = array();
		   $response["success"] = 0;
		   $response["message"] = "No add to Favourite";
                  
		   }
		   
		   return $response; 
                
}
catch(PDOException $e)
{
                   $response = array();
		   $response["success"] = 0;
		   $response["message"] = "You already added to Favourite";
return $response;
}
}

function RemoveFromFavourite($clientid,$employeeid,$dealid,$branchid)
{

 try{
		$query = "delete from BranchWish where branchid=:bri and dealid=:dli and employeeId=:emi";
	        $stmt = $this->db_connect->prepare($query);                              
                $stmt->bindParam(':bri',$branchid, PDO::PARAM_STR); 
                $stmt->bindParam(':dli',$dealid, PDO::PARAM_STR); 
                $stmt->bindParam(':emi',$employeeid, PDO::PARAM_STR);
                
                   if($stmt->execute())
                   {
                   $response = array();
		   $response["success"] = 1;
		   $response["message"] = "Remove Deal from Favourite successfully";
                   $response["displayposts"]=self::GetFavourites($clientid,$employeeid);
		   }
		   else{
                   $response = array();
		   $response["success"] = 0;
		   $response["message"] = "No action perform";
                  
		   }
		   
		   return $response; 
                
  }
  catch(PDOException $e)
  {
  echo $e;
  }
}


function GetFavourites($clientid,$employeeid)
{

 try{
$query = "select  CONCAT( 'http://ap.benepik.com/', d.img_logo) as path,d.merchant_name,d.percentage_offer,d.category,m.* from BranchWish as bw join deal as d on d.deal_id = bw.dealid inner join merchant_branch as m on m.branch_id = bw.branchid where bw.employeeId =:emi and bw.clientId=:cli";

		/*$query = "select deal.* from BranchWish join where clientId=:cli and emailid=:emi";*/
	        $stmt = $this->db_connect->prepare($query);                              
                $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR); 
                $stmt->bindParam(':emi',$employeeid, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                $response = array();

                   if($count>0)
                   {
                   $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		   $response["success"] = 1;
		   $response["message"] = "Fetch Deals from Favourite successfully";
                   $response["posts"]=$result;
		   }
		   else{
		   $response["success"] = 0;
		   $response["message"] = "No favourite deal available";
		   }
		   
		   return $response; 
                
  }
  catch(PDOException $e)
  {
  echo $e;
  }
}



function entryFavourites($clientid,$employeeID,$device)
{

date_default_timezone_set('Asia/Calcutta');
$fav_date = date('Y-m-d H:i:s');

try{
		$query = "insert into Tbl_Analytic_FavouriteDeal(clientId,employeeId,device,dateEntry)values(:cli,:empid,:dev,:dat)";
	        $stmt = $this->db_mahle->prepare($query);
                $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);                             
                $stmt->bindParam(':empid',$employeeID, PDO::PARAM_STR); 
                $stmt->bindParam(':dev',$device, PDO::PARAM_STR);
                $stmt->bindParam(':dat',$fav_date, PDO::PARAM_STR);
                $stmt->execute();
}
catch(PDOException $e)
{
echo $e;
}

}

}
?>
