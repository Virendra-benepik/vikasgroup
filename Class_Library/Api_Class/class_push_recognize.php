<?php
include_once('class_connect_db_admin.php');
include_once('class_connect_db.php');
class PushRecognize
{
  public $DB;
  public function __construct()
  {
      $db = new Connection();
      $this->DB = $db->getConnection();
      
       $db1 = new Connection_Client();
      $this->DB_client = $db1->getConnection_Client();
  }

  public $idclient;
 

  function addRecognize($cid,$rzid,$type,$title,$user_image,$userid)
 {
$this->idclient = $cid;
$this->regid = $rzid;
//echo "recogid = ".$this->regid;
$this->type = $type;
$this->title = $title;
$this->userimg = $user_image;
$status  = 1;
$this->recozby = $userid;
//echo "recog by  = ".$this->recozby;
$date = date("Y-m-d,H:i:s");

      try{
     $query = "insert into WelcomeDetails(clientId,id,type,title,image,createdDate,createdBy,status)
     values(:cid,:rid,:type,:title,:img,:dte,:cby,:sts)";
            $stmt = $this->DB_client->prepare($query);
            $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
             $stmt->bindParam(':rid',$this->regid, PDO::PARAM_STR);
              $stmt->bindParam(':type',$this->type, PDO::PARAM_STR);
               $stmt->bindParam(':title',$this->title, PDO::PARAM_STR);
                $stmt->bindParam(':img',$this->userimg, PDO::PARAM_STR);
                 $stmt->bindParam(':dte',$date, PDO::PARAM_STR);
                  $stmt->bindParam(':cby',$this->recozby, PDO::PARAM_STR);
                   $stmt->bindParam(':sts',$status, PDO::PARAM_STR);
           if($stmt->execute())
           {
           $result['success'] = 1;
           $result['msg'] = "data save into welcome table";
           }
             
     }
     catch(PDOException $e)
     {
     echo $e;
      $result['success'] = 0;
           $result['msg'] = "data save not into welcome table -".$e;
     }
     
         
            return json_encode($result);    
  }
  }