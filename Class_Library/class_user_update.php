<?php
session_start();
require_once('class_connect_db_Communication.php');

class User
{

  public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
      $this->DB = $db->getConnection_Communication();
  }
  
public $filename;
public $filetempname;
public $fullcsvpath;

function uploadUserCsv($file_name,$file_temp_name,$fullpath)
 {

$this->fullcsvpath = $fullpath;
  
date_default_timezone_set('Asia/Calcutta');
$c_date = date("Y-m-d H:i:s");
    $status = "Active";
    $access = "User";
    $clientid = $_SESSION['client_id'];
    $user_session = $_SESSION['user_unique_id'];

      $this->filename = $file_name;
      $this->filetempname = $file_temp_name;
      $target_file = basename($this->filename);
      
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

      if($imageFileType != "csv") 
      {
       echo "Sorry, only .csv files are allowed.";
    $uploadOk = 0;
      }
    else
    {
    $handle = fopen($this->filetempname, "r");
             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                  $userdata[] = $data;
            }
    
   /**************start insert into database **************************************************/
   
    // print_r($userdata);
      $countrows = count($userdata);
      if($countrows>200)
      {
      echo "<script>alert(Sorry! You can't upoad data more than 200 employee at a time) </script>";
      }
     // echo $countrows;
     /*****************************fetch existing admin details (emaild)**************************************/
                  try{
			$max = "select * from Tbl_EmployeeDetails_Master where clientId = '".$clientid."'";
			$query = $this->DB->prepare($max);
			if($query->execute())
			{
				$tr  = $query->fetch();
				$ADMINEMAIL = $tr['emailId'];   //fetch admin email id
				
				 }
				
	               }
		      catch(PDOException $e)
			{ echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
				}

try
     {
     $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
     $stmt7 = $this->DB->prepare($query_client);
               $stmt7->bindParam(':cid7',$clientid, PDO::PARAM_STR);
               if($stmt7->execute())
               {
               $row = $stmt7->fetch();
               $program_name = $row['program_name'];
               $dedicateemail = $row['dedicated_mail'];
               $clientid = $row['client_id'];
               $subdomain_link = $row['subDomainLink'];
               $package_name  = $row['packageName'];
               }
     }
		      catch(PDOException $e)
			{
                                echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}

          /******************************************/     

    /************************** fetching data from B_Client_Data*********************************/	

     
	  for($row=1; $row<$countrows; $row++)
	  {
	  
	  $user_name = $userdata[$row][0]." ".$userdata[$row][1]." ".$userdata[$row][2];
	  
	  $randomAlpha = self::randomalpha(6);
	  $randomDigit = self::randomdigit(2);
	  $randompassword = $randomAlpha.$randomDigit;
		 $md5password = md5($randompassword);

		 $randomAlpha1 = self::randomalpha(14);
	          $randomDigit1 = self::randomdigit(6);

		 $randomempid = $randomAlpha1.$randomDigit1;

		 $adminaccess = 'Admin';
		 $useremail = $userdata[$row][12];
	  
	  
	          try{
			$max = "select max(autoId) from Tbl_EmployeeDetails_Master";
			$query = $this->DB->prepare($max);
			if($query->execute())
			{
				$tr  = $query->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$usid = "User-".$m_id1;
				
				 }
				
	               }
		      catch(PDOException $e)
			{
				echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
	  
	try
		{
$qu = "insert into Tbl_EmployeeDetails_Master
	(userId,clientId,firstName,middleName,lastName,gender,emailId,employeeCode,department,designation,location,branch,grade,createdDate,createdBy) values(:uid,:cid,:fname,:mname,:lname,:gen,:email,:ecode,:dep,:des, :loc,:bra,:gra,:cred,:creb) ON DUPLICATE KEY UPDATE firstName =:fname,middleName=:mname, lastName=:lname,gender=:gen,department=:dep,designation=:des,location=:loc,branch=:bra,grade=:gra,updatedDate=:cred,updatedBy=:creb";
                $stmt = $this->DB->prepare($qu);

                $stmt->bindParam(':uid',$usid, PDO::PARAM_STR);
                $stmt->bindParam(':cid',$clientid, PDO::PARAM_STR);
                $stmt->bindParam(':fname',$userdata[$row][0], PDO::PARAM_STR);
                $stmt->bindParam(':mname',$userdata[$row][1], PDO::PARAM_STR);
                $stmt->bindParam(':lname',$userdata[$row][2], PDO::PARAM_STR);

                $stmt->bindParam(':gen',$userdata[$row][3], PDO::PARAM_STR);
                $stmt->bindParam(':email',$userdata[$row][12], PDO::PARAM_STR);
                $stmt->bindParam(':ecode',$userdata[$row][6], PDO::PARAM_STR);
                $stmt->bindParam(':dep',$userdata[$row][7], PDO::PARAM_STR);
                $stmt->bindParam(':des',$userdata[$row][8], PDO::PARAM_STR);
                $stmt->bindParam(':loc',$userdata[$row][10], PDO::PARAM_STR);
                $stmt->bindParam(':bra',$userdata[$row][11], PDO::PARAM_STR);
                $stmt->bindParam(':gra', $userdata[$row][9], PDO::PARAM_STR);
                $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
                $stmt->bindParam(':creb', $user_session, PDO::PARAM_STR);

                if($stmt->execute())
                { 


	     $query4 = "insert into Tbl_EmployeePersonalDetails(userid,clientId,employeeCode,emailId,userDOB,userDOJ)values(:uid1,:cid1,:ecode1,:emailid1,:dob,:doj) ON DUPLICATE KEY UPDATE userDOB=:dob,userDOJ=:doj";
		$stmt4 = $this->DB->prepare($query4);
                $stmt4->bindParam(':uid1',$usid, PDO::PARAM_STR);
                $stmt4->bindParam(':cid1',$clientid, PDO::PARAM_STR);
                 $stmt4->bindParam(':ecode1',$userdata[$row][6], PDO::PARAM_STR);
                $stmt4->bindParam(':emailid1',$userdata[$row][12], PDO::PARAM_STR);
                $stmt4->bindParam(':dob',$userdata[$row][4], PDO::PARAM_STR);
                $stmt4->bindParam(':doj',$userdata[$row][5], PDO::PARAM_STR);
	
        if($stmt4->execute())
        {
             $msg = "data successfully updated";
             $resp['msg'] = $msg;
             $resp['success'] = 1;
        }
    
               }

		}
		catch(PDOException $ex)
		{
		 echo $ex;
		}
      
   }
	return json_encode($resp);  
	
 }
	    
      /**********************************file csv start  end ***********************************/  
 
}	


function userForm($fname)
 {
 $this->first_name = "%".$fname."%";
 
 $clientid= $_SESSION['client_id'];
    
	try
		{
	$qu = "select * from Tbl_EmployeeDetails_Master where (firstName like '".$this->first_name."' or emailId like '".$this->first_name."' or employeeCode like '".$this->first_name."') and clientId=:cli";
                $stmt = $this->DB->prepare($qu);
                $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);	
		$stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows)
{
$response = array();
$response["success"]=1;
$response["message"]="successfully fetched data";
$response["posts"]=$rows;
return json_encode($response);
}
	
		}
		catch(PDOException $ex)
		{
		 echo $ex;
		}
      
  }

function userFormUpdate($emp_id,$emp_name,$emp_last,$temp_depar,$emp_desig,$emp_loc,$emp_bra,$emp_gra,$idclient,$user_unique_id)
{
$updateddate = date("Y-m-d h:i:s");

$this->empid = $emp_id;
$this->name = $emp_name;
$this->last = $emp_last;
$this->depart = $temp_depar;
$this->desig = $emp_desig;
$this->loc = $emp_loc;
$this->bra = $emp_bra;
$this->gra = $emp_gra;
$this->clientid = $idclient;
$this->updatedby = $user_unique_id;
$this->updateddate = $updateddate;


$query4 = "update Tbl_EmployeeDetails_Master set firstName=:nam, lastName=:nam2,department=:depart,designation=:desig,location=:loc,branch=:bra,grade=:gra,updatedBy=:updatedby,updatedDate=:updateddate where employeeId=:ema and clientId=:cli";
		$stmt4 = $this->DB->prepare($query4);
                $stmt4->bindParam(':nam',$this->name, PDO::PARAM_STR);
                $stmt4->bindParam(':nam2',$this->last, PDO::PARAM_STR);
                $stmt4->bindParam(':depart',$this->depart, PDO::PARAM_STR);
                $stmt4->bindParam(':desig',$this->desig, PDO::PARAM_STR);
                $stmt4->bindParam(':loc',$this->loc, PDO::PARAM_STR);
                $stmt4->bindParam(':bra',$this->bra, PDO::PARAM_STR);
                $stmt4->bindParam(':gra',$this->gra, PDO::PARAM_STR);
                $stmt4->bindParam(':ema',$this->empid, PDO::PARAM_STR);
                $stmt4->bindParam(':cli',$this->clientid, PDO::PARAM_STR);
				$stmt4->bindParam(':updatedby',$this->updatedby, PDO::PARAM_STR);
				$stmt4->bindParam(':updateddate',$this->updateddate, PDO::PARAM_STR);
	
        if($stmt4->execute())
          {
            $response = array();
            $response["success"]=1;
            $response["message"]="update data successfully";
            return json_encode($response);   
          }
else
         {
            $response = array();
            $response["success"]=0;
            $response["message"]="No data found";
            return json_encode($response);
         }

}
	  
     function randomalpha($length) 
	 {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
    }	
    function randomdigit($length) 
	{
    $alphabet = "0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
    }	  
}
      /**********************************random Password function ***********************************/  
?>