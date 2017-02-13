<?php
include_once('class_connect_db_admin.php');
class ClientData
{
    
  public $DB;
  public function __construct()
  {
    $db = new Connection();
      $this->DB = $db->getConnection();
  }

public $client_id;
public $user_id;
public $name;
public $mobile;
public $department;
public $designation;
public $path;

  function updateClient($clientid,$userid,$nam,$mob,$depart,$desig)
  {

$this->client_id = $clientid;
$this->user_id = $userid;
$this->name = $nam;
$this->mobile = $mob;
$this->department = $depart;
$this->designation = $desig;
//$this->path = $imgpath;


date_default_timezone_set('Asia/Calcutta');
$cd = date('d M Y, h:i A');     


     try{
              
    $query = "UPDATE UserDetails a JOIN UserPersonalDetails b ON a.userId = b.userid
    SET a.firstName =:nam,a.contact =:mob,a.department =:depart,a.designation =:desig, a.createdDate =:dat where a.clientId =:cid and a.userId =:uid;";
              $stmt = $this->DB->prepare($query);
              $stmt->bindParam(':cid',$this->client_id, PDO::PARAM_STR);
              $stmt->bindParam(':uid',$this->user_id, PDO::PARAM_STR);
              $stmt->bindParam(':nam',$this->name, PDO::PARAM_STR);
              $stmt->bindParam(':mob',$this->mobile, PDO::PARAM_STR);
              $stmt->bindParam(':depart',$this->department, PDO::PARAM_STR);
              $stmt->bindParam(':desig',$this->designation, PDO::PARAM_STR);
              $stmt->bindParam(':dat',$cd, PDO::PARAM_STR);
              //$stmt->bindParam(':pth',$this->path, PDO::PARAM_STR);
              if($stmt->execute())
              {
                     $response["success"] = 1;
                     $response["message"] = "User successfully updated";
                     return json_encode($response);
               }
       }

     catch(PDOException $e)
       {
     echo $e;
       }         
   }

public $iduser;
public $statususer;

function status_User($com,$coms)
 {

$this->iduser = $com;
$this->statususer = $coms;

$status = "";
     try{
     $query = "update B_Client_Data set status = :sta where client_id = :comm ";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':comm',$this->iduser, PDO::PARAM_STR);
             $stmt->bindParam(':sta',$this->statususer, PDO::PARAM_STR);
             $stmt->execute();
             $response = array();

                  if($stmt->execute())
                  {
                     $response["success"] = 1;
                     $response["message"] = "User status has changed";
                     return json_encode($response);
                  }
         }
     catch(PDOException $e)
     {
     echo $e;
     } 
 }

}
?>