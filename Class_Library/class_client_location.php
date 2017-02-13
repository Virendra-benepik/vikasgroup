<?php 
include_once('class_connect_db_Communication.php');

class ContactLocation
{
	 public $db_connect;
	 public function __construct()
    {   
	$dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();

    }
/*************************** Create Module and insert data into database  **************************************/ 	
	public $clientid;
	public $location;
	function createLocation($cid, $loc)
	{
		$this->clientid = $cid;
		$this->location = $loc;
		
		try{
			$max = "select max(autoId) from Tbl_ContactDirectoryLocation";
			$stmt = $this->db_connect->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$l_id = $tr[0];
				$l_id1 = $l_id+1;
				$lid = "L-".$l_id1;
				//echo $mid;
				}
			}
			catch(PDOException $e)
			{
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);}
		
		
		try 
		{
		$query = "insert into Tbl_ContactDirectoryLocation(locationId,clientId,locationName)values(:id,:cid,:loc)";
		$stmt = $this->db_connect->prepare($query);
                                              
        $stmt->bindParam(':id', $lid, PDO::PARAM_STR); 
		 $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);       
        $stmt->bindParam(':loc', $this->location, PDO::PARAM_STR); 
        if($stmt->execute())
	     {
	     $response['success'] = 1;
	     $response['msg'] = "New Location Successfully Added";
		
		 }
               
		}      //--------------------------------------------- end of try block
		catch(PDOException $e) {
			 $response['success'] = 0;
	               $response['msg'] = $e;
	                 // echo "Error occured while trying to insert into the DB:". $e->getMessage();
                }  //---------------------------------------------end of catch blok
            return json_encode($response);
	}      //------------------------end of create module function

/*************************** View location data from database  **************************************/ 	

	public $clientids;

	function viewLocation($cid)
	{
		$this->clientids = $cid;
		
		try
		{
		$query = "select * from Tbl_ContactDirectoryLocation where clientId =:id1 ";
		$stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR); 
	        $stmt->execute();
                $rows = $stmt->fetchAll();

            if($rows)   
	     {
	     $response['success'] = 1;
	     $response['msg'] = "Successfully Display data";
	     $response['posts'] = array();
	     
             foreach($rows as $row)
               {
                   $post["locationId"] = $row["locationID"];
                   $post["locationName"] = $row["locationName"];
                   
                   array_push($response['posts'],$post);
               } 	
	     }
               
        	}      //--------------------------------------------- end of try block
		catch(PDOException $e) {
			 $response['success'] = 0;
	               $response['msg'] = $e;
	               echo $e;
	                 // echo "Error occured while trying to insert into the DB:". $e->getMessage();
                }  //---------------------------------------------end of catch blok
            return json_encode($response);
	}
	
	
	
/*************************** Delete location from database  **************************************/ 	

	function deleteLocation($locid)
	{
		$this->location_id = $locid;
		
		try
		{
		$query = "delete from Tbl_ContactDirectoryPerson where locationId =:id1 ";
		$stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':id1',$this->location_id, PDO::PARAM_STR); 
            
         if($stmt->execute())   
	     {
			    $query1 = "delete from Tbl_ContactDirectoryDepartment where locationId =:id1 ";
		        $stmt1 = $this->db_connect->prepare($query1);
                $stmt1->bindParam(':id1',$this->location_id, PDO::PARAM_STR); 
            
               if($stmt1->execute())   
	           {
                 		$query2 = "delete from Tbl_ContactDirectoryLocation where locationId =:id1 ";
		                $stmt2 = $this->db_connect->prepare($query2);
                        $stmt2->bindParam(':id1',$this->location_id, PDO::PARAM_STR); 
            
                        if($stmt2->execute())   
	                    {
	                    $response['success'] = 1;
	                    $response['msg'] = "Successfully Delete record";
						}
	           }
		 }
               
        }      //--------------------------------------------- end of try block
		catch(PDOException $e) 
		{
			 $response['success'] = 0;
	         $response['msg'] = $e;
	         echo $e;
	        // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
            return json_encode($response);
	}
	
	/*************************** delete location data database  **************************************/ 	
	
	
/***************************Update location data from database  **************************************/ 	

	function updateLocation($cid,$lid,$lname)
	{
		$this->clientid = $cid;
		$this->locid = $lid;
		$this->locname = $lname;
		
		try
		{
		$query = "update Tbl_ContactDirectoryLocation set locationName=:lnam where clientId =:id1 and locationID=:lid";
		$stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':lnam', $this->locname, PDO::PARAM_STR);
                $stmt->bindParam(':id1', $this->clientid, PDO::PARAM_STR);
                $stmt->bindParam(':lid', $this->locid, PDO::PARAM_STR);

            if($stmt->execute())   
	     {
	     $response['success'] = 1;
	     $response['msg'] = "Successfully Display data";	
	     }
               
        	}      //--------------------------------------------- end of try block
		catch(PDOException $e) {
			 $response['success'] = 0;
	               $response['msg'] = $e;
	               echo $e;
	                 // echo "Error occured while trying to insert into the DB:". $e->getMessage();
                }  //---------------------------------------------end of catch blok
            return json_encode($response);
	}
	
	/***************************Update location data from database  **************************************/ 	
	
}       // end of class module

?>