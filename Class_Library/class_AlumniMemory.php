<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class AlumniMemory
{    
  public $DB;
  public function __construct()
  {
       $db = new Connection_Communication();
       $this->DB = $db->getConnection_Communication();
       
  }

function compress_image($source_url, $destination_url, $quality) 
{
        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue/1024;
        
        if($valueimage > 40)
        {  
	$info = getimagesize($source_url);
 
	if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
	elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
	elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
 
	//save it
	imagejpeg($image, $destination_url, $quality);
 
	//return destination file url
	return $destination_url;
        }
        else
        {
          move_uploaded_file($source_url,$destination_url);
        }
}
/******************************** generate three digit random number *****************************/
function randomNumber($length)
  {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
  }
/********************************end generate three digit random number *****************************/

 function convertIntoImage($encodedimage)
  {
 $num = self::randomNumber(6);
  $img = imagecreatefromstring(base64_decode($encodedimage));
  
  $imgpath = dirname(BASE_PATH).'/images/memories/'.$num.'.jpg';
  //echo "image path-".$imgpath;
  imagejpeg( $img , $imgpath );  
 //  $imgpath1 =$num.'.jpg';
    $imgpath1 = 'images/memories/'.$num.'.jpg';
   return $imgpath1;
  }


  function maxId()
  {
      try{
			$max = "select max(memoryId) from Tbl_C_AlumniMemory";
			$stmt = $this->DB->prepare($max);
			if($stmt->execute())
			{
				$tr  = $stmt->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$postid = $m_id1;
				 				 return $postid;
				 }
				}
		    	catch(PDOException $e)
			   {  
			     echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
		        }
		
      
  }

                      //$clientid,$POST_IMG,$memeorycontent,$employeeid,$device,$post_date,$device
  function createMemory($cid,$aimgpath,$title,$memeory,$device,$cby,$cdate,$flag,$selectedgroup)
  {    
     try{       
     $query = "insert into Tbl_C_AlumniMemory(clientId,imageName,memoryContent,title,device,createdBy,createdDate,flagType,selectedGroup)
            values(:cid,:img,:content,:title,:device,:cby,:cd,:flg,:grp)";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cid',$cid, PDO::PARAM_STR);
			 $stmt->bindParam(':img',$aimgpath, PDO::PARAM_STR);
             $stmt->bindParam(':content',$memeory, PDO::PARAM_STR);
			  $stmt->bindParam(':title',$title, PDO::PARAM_STR);
			  $stmt->bindParam(':device',$device, PDO::PARAM_STR); 
              $stmt->bindParam(':cby',$cby, PDO::PARAM_STR);
			 $stmt->bindParam(':cd',$cdate, PDO::PARAM_STR);			  
			  $stmt->bindParam(':flg',$flag, PDO::PARAM_STR);
			  $stmt->bindParam(':grp',$selectedgroup, PDO::PARAM_STR);
			  
                  if($stmt->execute())
                  {
					  $response['success'] = 1;
					  $response['message'] = "Memory Successfully added for review";
                 
                  }
     }
     catch(PDOException $e)
     {
		  $response['success'] = 0;
		  $response['message'] = "error".$e;
     
     }
	 return json_encode($response);
  }
  
  public function getMemories($clientid, $memoryId = '') {
        try {
            $query = "SELECT memory.*,user.firstName, user.lastName, user.emailId, user.contact FROM Tbl_C_AlumniMemory as memory join Tbl_EmployeeDetails_Master as user ON user.employeeId=memory.createdBy WHERE memory.clientId=:client";
            if (!empty($memoryId)) {
                $query .= " AND memory.memoryId=:memoryId";
            } else {
                $query .= " order by status, createdDate desc";
            }
            $stmt1 = $this->DB->prepare($query);
            $stmt1->bindParam(':client', $clientid, PDO::PARAM_STR);
            if (!empty($memoryId)) {
                $stmt1->bindParam(':memoryId', $memoryId, PDO::PARAM_STR);
            }
            $result = $stmt1->execute();
            $response = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo $ex;
            $response["success"] = 0;
            $response["msg"] = "Error" . $ex;
        }

        return json_encode($response);
    }

    function status_memory($com, $coms, $updatedby) {
		
	date_default_timezone_set('Asia/Calcutta');
	$updateddate = date('Y-m-d H:i:s A');

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 'Publish') {
            $welstatus = 1;
        } else {
            $welstatus = 0;
        }
        try {
            $query = "update Tbl_C_AlumniMemory set status = :sta, updatedBy = :ub, updatedDate = :udate where memoryId = :comm ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->idpost, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);
			$stmt->bindParam(':ub', $updatedby, PDO::PARAM_STR);
			$stmt->bindParam(':udate', $updateddate, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Memory status has changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }


  
}
?>