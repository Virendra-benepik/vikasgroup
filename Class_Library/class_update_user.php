<?php
include_once('class_connect_db_Communication.php');

class UserUpdate
{
    
  public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
    $this->DB = $db->getConnection_Communication();
  }

public $iduser;
public $statususer;

function userAccess($com,$coms)
 {

$this->iduser = $com;
$this->statususer = $coms;

$status = "";
     try{
     $query = "update UserDetails set accessibility = :sta where userId = :comm ";
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