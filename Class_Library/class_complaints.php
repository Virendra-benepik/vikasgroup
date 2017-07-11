<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('class_connect_db_Communication.php');

class Complaint
{
	 public $db_connect;
	 public function __construct()
    {
	$dbh = new Connection_Communication();
	$this->db_connect =  $dbh->getConnection_Communication();
    }

   
   /******************************************************** Get Complain ***********************************/
   public $client_id;
   function getComplain($cid)
   {
   $this->client_id = $cid;
   try
   {
   $query = "select Tbl_EmployeeComplaints.*,DATE_FORMAT(Tbl_EmployeeComplaints.date_of_complaint,'%d %b %Y %h:%i %p') as date_of_complaint,Tbl_EmployeePersonalDetails.*,Tbl_EmployeeDetails_Master.firstName,Tbl_EmployeeDetails_Master.lastName from Tbl_EmployeeComplaints join Tbl_EmployeePersonalDetails on Tbl_EmployeeComplaints.userUniqueId = Tbl_EmployeePersonalDetails.employeeId join Tbl_EmployeeDetails_Master on Tbl_EmployeeComplaints.userUniqueId = Tbl_EmployeeDetails_Master.employeeId where Tbl_EmployeeComplaints.clientId = :cid order by date_of_complaint desc";
   $stmt = $this->db_connect->prepare($query);
   $stmt->bindParam(':cid',$this->client_id,PDO::PARAM_STR);
   $stmt->execute();
   $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return json_encode($row);
   }
   catch(PDOException $e)
   {
   echo $e;
   }
   
   }
   
   /******************************************************** Get suggestion ***********************************/
   
   function getSuggestion($cid1)
   {
   $this->client_id = $cid1;
   try
   {
    $query = "select Tbl_EmployeeSuggestions.*, DATE_FORMAT(Tbl_EmployeeSuggestions.date_of_sugestion,'%d %b %Y %h:%i %p') as date_of_sugestion, Tbl_EmployeePersonalDetails.*,Tbl_EmployeeDetails_Master.firstName,Tbl_EmployeeDetails_Master.lastName from Tbl_EmployeeSuggestions join Tbl_EmployeePersonalDetails on Tbl_EmployeeSuggestions.userUniqueId = Tbl_EmployeePersonalDetails.employeeId join Tbl_EmployeeDetails_Master on Tbl_EmployeeSuggestions.userUniqueId = Tbl_EmployeeDetails_Master.employeeId where Tbl_EmployeeSuggestions.clientId = :cid order by date_of_sugestion desc";
   $stmt = $this->db_connect->prepare($query);
   $stmt->bindParam(':cid',$this->client_id,PDO::PARAM_STR);
   $stmt->execute();
   $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return json_encode($row1);
   
   }
   catch(PDOException $e)
   {
   echo $e;
   
   }    
   
   }
   
   
     function getonesuggestion($postid) {
        $this->id_posts = $postid;
		$path = SITE; 
        try {
            /*$query = "select * , DATE_FORMAT(date_of_sugestion,'%d %b %Y %h:%i %p') as date_of_sugestion from Tbl_EmployeeSuggestions where sugestionId =:comm";*/
			
			$query = "select Tbl_EmployeeSuggestions.* ,if(Tbl_EmployeeSuggestions.suggestionImage = '' or Tbl_EmployeeSuggestions.suggestionImage IS NULL ,'',CONCAT('".$path."' ,Tbl_EmployeeSuggestions.suggestionImage)) as suggestionImage , DATE_FORMAT(Tbl_EmployeeSuggestions.date_of_sugestion,'%d %b %Y %h:%i %p') as date_of_sugestion , CONCAT(Tbl_EmployeeDetails_Master.firstName , ' ',Tbl_EmployeeDetails_Master.lastName) as name ,Tbl_EmployeeDetails_Master.employeeCode , Tbl_EmployeePersonalDetails.Companyname from Tbl_EmployeeSuggestions JOIN Tbl_EmployeeDetails_Master ON Tbl_EmployeeSuggestions.userUniqueId =  Tbl_EmployeeDetails_Master.employeeId JOIN Tbl_EmployeePersonalDetails ON Tbl_EmployeeSuggestions.userUniqueId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeSuggestions.sugestionId =:comm";
			
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':comm', $this->id_posts, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = array();

        if ($rows) {
            for ($i = 0; $i < count($rows); $i++) {
                $post["sugestionId"] = $rows[$i]["sugestionId"];
                $post["clientId"] = $rows[$i]["clientId"];
                $post["suggestionArea"] = $rows[$i]["suggestionArea"];
                 $post["content"] = $rows[$i]["content"];
                  $post["date_of_sugestion"] = $rows[$i]["date_of_sugestion"];
				  $post["name"] = $rows[$i]["name"];
				  $post["Companyname"] = $rows[$i]["Companyname"];
				  $post["suggestionImage"] = $rows[$i]["suggestionImage"];
				  $post["employeeCode"] = $rows[$i]["employeeCode"];
                   
                array_push($response["posts"], $post);
            }
           
        }
         return json_encode($response);
    }
    
     function getonecomplain($postid) {
        $this->id_posts = $postid;

        try {
            /*$query = "select * , DATE_FORMAT(date_of_complaint,'%d %b %Y %h:%i %p') as date_of_complaint from Tbl_EmployeeComplaints where complaintId =:comm";*/
			
			$query = "select Tbl_EmployeeComplaints.* , DATE_FORMAT(Tbl_EmployeeComplaints.date_of_complaint,'%d %b %Y %h:%i %p') as date_of_complaint , Tbl_EmployeePersonalDetails.Companyname , Tbl_EmployeePersonalDetails.employeeCode from Tbl_EmployeeComplaints JOIN Tbl_EmployeePersonalDetails ON Tbl_EmployeeComplaints.userUniqueId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeComplaints.complaintId =:comm";
			
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':comm', $this->id_posts, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = array();

        if ($rows) {
            for ($i = 0; $i < count($rows); $i++) {
                $post["complaintId"] = $rows[$i]["complaintId"];
                $post["clientId"] = $rows[$i]["clientId"];
                $post["complaintBy"] = $rows[$i]["complaintBy"];
                 $post["content"] = $rows[$i]["content"];
                  $post["date_of_complaint"] = $rows[$i]["date_of_complaint"];
				   $post["Companyname"] = $rows[$i]["Companyname"];
				   $post["employeeCode"] = $rows[$i]["employeeCode"];
                   
                array_push($response["posts"], $post);
            }
           
        }
         return json_encode($response);
    }
}
?>