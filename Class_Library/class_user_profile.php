<?php

if (!class_exists("Connection_Communication"))
                {
    include_once("class_connect_db_Communication.php");
}
       

class Profile
{
  public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
        $this->db_connect = $db->getConnection_Communication();
  }

  public $idclient;
  public $iduser;

  function getuserprofile($client_id,$userid)
  {
$this->idclient = $client_id;
$this->iduser = $userid;

      try{
     $query = "SELECT UserDetails . * , UserPersonalDetails . * ,clientdetail.*
FROM Tbl_EmployeeDetails_Master as UserDetails
JOIN Tbl_EmployeePersonalDetails as UserPersonalDetails ON UserDetails.employeeId = UserPersonalDetails.employeeId join Tbl_ClientDetails_Master as cm on cm.client_id = UserDetails.clientId where UserDetails.employeeId =:uid and UserDetails.clientId=:cid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':uid',$this->iduser, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll();
            if(count($row)>0)
             {
                $response['success'] = 1;
                        $response['data']=$row;
                  return json_encode($response);
             } 
             else
             {
                 $response['success'] = 0;
                        $response['data']= "";
             }
                  
     }
     catch(PDOException $e)
     {
      $response['success'] = 0;
                        $response['data']= "";
     }
     return json_encode($response);
  }
  
}
?>