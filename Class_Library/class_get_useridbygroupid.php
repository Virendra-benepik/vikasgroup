<?php
include_once('class_connect_db_admin.php');

class PushNotification1
{
    
  public $DB;
  public function __construct()
  {
    $db = new Connection();
      $this->DB = $db->getConnection();
  }

  /******************************************GET GCM DETAILS FROM DATABASE ********************************************************/
  public $userde;
  public $value;
  public $client;
   function get_Employee_details($usertype,$ur,$client)
   {
   $this->userde = $usertype;
   $this->client = $client;  
    $this->value = $ur;   // this is an array 
     $uuid = array();
    if($this->userde == 'All')
    { 
    try{  
$select = "select employeeId from UserDetails where clientId =:cid1"; 
$stmt = $this->DB->prepare($select);
  $stmt->bindParam('cid1',$this->client,PDO::PARAM_STR);
          if($stmt->execute())
            {
              $row = $stmt->fetchAll();
        
            }
            foreach($row as $row1)
            {
             array_push($uuid,$row1['employeeId']);
            
            }
             $value = json_encode($uuid);
               
     }
     catch(PDOException $ex)
     {
       $value = $ex;
     }
      return $value;
    
    }
  /******************************* now start complex logic from here **********************************/  
    else
    {
   $count1 = count($this->value);

    $allrows = array();
    echo "count value of group ".$count."<br>";
    for($t=0; $t<$count1; $t++)
    {
    
    $groupid = $this->value[$t];
  echo "group id:-".$groupid." value of loop ".$t."<br/>";
   /*******************************************************************/
   try 
  {
   $query5 = "select distinct(columnName) from ClientGroupDemoParam where groupId=:gid and clientId=:cid1";
    
    $stmt5   = $this->DB->prepare($query5);
    $stmt5->bindParam(':gid',$groupid,PDO::PARAM_STR);
     $stmt5->bindParam(':cid1',$this->client,PDO::PARAM_STR);
   if($stmt5->execute())
   {
   
    $rows = $stmt5->fetchAll(PDO::FETCH_ASSOC);
   
    $count = count($rows);
     $response = array();
    for($i=0;$i<$count;$i++)
    { 
   
  echo $rows[$i]['columnName'];
    $query = "select ColumnValue from ClientGroupDemoParam where columnName=:cname and groupId=:gid1";
         
      $stmt  = $this->DB->prepare($query);
      $stmt->bindParam(':gid1',$groupid,PDO::PARAM_STR);
      $stmt->bindParam(':cname',$rows[$i]['columnName'],PDO::PARAM_STR);
      $stmt->execute();
     
       $rows1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    $posts["columnName"] = $rows[$i]['columnName'];
    $posts["distictValuesWithinColumn"] = $rows1;
     
    array_push($response,$posts);
   
    }
 
      }
       echo "<pre>";
       print_r($response);
       echo "</pre>";
$countrow = count($response);
echo "total count of group parameter : - ".$countrow."</br>";
$substring = "";
for($j=0;$j<$countrow;$j++)
{

  $columnname = $response[$j]['columnName'];
  echo "column name  : - ".$columnname."<br/>";
  $columnvalue = count($response[$j]['distictValuesWithinColumn']);
  echo "no of value in column  : - ".$columnvalue."<br/>";
  $su = "";
  for($k=0;$k<$columnvalue;$k++)
  {
  if($response[$j]['distictValuesWithinColumn'][$k] != 'All')
  {
  $su .= "'".$response[$j]['distictValuesWithinColumn'][$k]."'".",";
  }
  else
  {
  $su .= "";
  }
  }
  if($su != "")
  {
 // $string = str_replace(' ', '', $su);
  $su1 = rtrim($su,',');
 echo "series of column value  : - ".$su1."<br/>";
    $substring .= $columnname." IN(".$su1.")"." and ";
    echo $substring;
   }
   else
   {
   $substring .= "";
   }
 
}
$finalstring = $substring. " clientid = '".$this->client."'";

echo "final string : - ".$finalstring."<br/>";

try
 {
 $qq =  "select firstName,employeeId,clientId from UserDetails where ".$finalstring;
  $qq1 = "select firstName,emailId from UserDetails where ".$finalstring;
  echo $qq."<br/>";
   $stmt2  = $this->DB->prepare($qq);
 // $stmt2->bindParam(':cid','',PDO::PARAM_STR);
     if($stmt2->execute())
     {
    
      $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      echo "<pre>";
      print_r($rows2);
      echo "</pre>";
    
      foreach($rows2 as $row5)
      {
      array_push($allrows,$row5['employeeId']);
      } 
      
      }
      }
      catch(PDOException $e)
      {
      echo $e;
      }
     echo "--------------------------------------<br/>";
   }

     /********************************************/
     catch(PDOException $ex)
     {
       $value = $ex;
       echo $value;
     }
   }
    echo "<pre>";
     print_r($allrows);
     echo "</pre>";
    $value = json_encode($allrows);
   
       return $value;
   }
   /************************************ complex logic end from here *************************************/
}
}