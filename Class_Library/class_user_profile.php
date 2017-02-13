<?php
include_once('class_connect_db_admin.php');
class Profile
{
  public $DB;
  public function __construct()
  {
    $db = new Connection();
      $this->DB = $db->getConnection();
  }

  public $idclient;
  public $iduser;

  function getuserprofile($client_id,$userid)
  {
$this->idclient = $client_id;
$this->iduser = $userid;

      try{
     $query = "SELECT UserDetails . * , UserPersonalDetails . * 
FROM UserDetails
JOIN UserPersonalDetails ON UserDetails.userId = UserPersonalDetails.userid where UserDetails.userId =:uid and UserDetails.clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':uid',$this->iduser, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll();
            if($row)
             {
                  $response = array();
                  foreach($row as $r)
                  {
                    $post["firstName"] = $r["firstName"];
                    $post["middleName"] = $r["middleName"];
                    $post["lastName"] = $r["lastName"];
                    $post["password"] = $r["password"];
                    $post["contact"] = $r["contact"];
                    $post["department"] = $r["department"];
                    $post["designation"] = $r["designation"];
                    $post["userImage"] = $r["userImage"];

                    array_push($response,$post);
                  }
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