<?php
include_once('class_connect_db_Communication.php');

class GetGroup
{
    
    public $DB;
  public function __construct()
  {
  	$db = new Connection_Communication();
      	$this->DB = $db->getConnection_Communication();
  }
  
  public $id;
  function getSingleGroup($k)
  {
  $this->id = $k;
  $count = count($this->id);
 // echo $count;
  $val = array();
  
 for($i=0;$i<$count;$i++)
 {
     $gid =  $this->id[$i];
   try{  $query = "select * from ChannelDetails where channelId =:cid";
       $stmt = $this->DB->prepare($query);
       $stmt->bindParam(':cid',$gid,PDO::PARAM_STR);
       if($stmt->execute())
       {
      $rows = $stmt->fetchAll();
       $val[] = $rows;
      //print_r($rows);
      echo "<br/>";
       
       }
       }
       catch(PDOException $e)
       {
       echo $e;
       }
      
 }
 return $val;
 
  }
}
?>