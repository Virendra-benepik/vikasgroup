 <?php
include_once('../Class_Library/class_connect_db_admin.php');
    $db = new Connection();
      $connect = $db->getConnection();
 

//initial query
if (!empty($_REQUEST['groupid']) && !empty($_REQUEST['clientid'])) 
{
$accessibleGroups =  "";
try 
{
   $query5 = "select distinct(columnName) from ClientGroupDemoParam where groupId=:gid";
    
    $stmt5   = $connect->prepare($query5);
    $stmt5->bindParam(':gid',$_REQUEST['groupid'],PDO::PARAM_STR);
   if($stmt5->execute())
   {
   
   $rows = $stmt5->fetchAll(PDO::FETCH_ASSOC);
   
    $count = count($rows);
     $response = array();
    for($i=0;$i<$count;$i++)
    { 
   echo $rows[$i]['columnName'];
    $query = "select ColumnValue from ClientGroupDemoParam where columnName=:cid and groupId=:gid1";
         
    $stmt  = $connect->prepare($query);
    $stmt->bindParam(':gid1',$_REQUEST['groupid'],PDO::PARAM_STR);
      $stmt->bindParam(':cid',$rows[$i]['columnName'],PDO::PARAM_STR);
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

for($j=0;$j<$countrow;$j++)
{
  $columnname = $response[$j]['columnName'];
  //echo "column name  : - ".$columnname."<br/>";
  $columnvalue = count($response[$j]['distictValuesWithinColumn']);
 // echo "no of value in column  : - ".$columnvalue."<br/>";
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
  $string = str_replace(' ', '', $su);
  $su1 = rtrim($string,',');
 //echo "series of column value  : - ".$su1."<br/>";
    $substring .= " ud.".$columnname." IN(".$su1.")"." and ";
   // echo $substring;
   }
   else
   {
   $substring .= "";
   }
 
}
$finalstring = $substring. " ud.clientid = 'CO-9'";

echo "final string : - ".$finalstring."<br/>";

try
 {
 $qq =  "select gcm.*,ud.firstName from GCMDetails as gcm  join UserDetails as ud on ud.emailId = gcm.email where".$finalstring;
  $qq1 = "select firstName,emailId from UserDetails where ".$finalstring;
  echo $qq."<br/>";
   $stmt2  = $connect->prepare($qq);
 // $stmt2->bindParam(':cid','',PDO::PARAM_STR);
     if($stmt2->execute())
     {
     echo "hello";
      $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      echo "<pre>";
      print_r($rows2);
      echo "</pre>";
      }
      }
      catch(PDOException $e)
      {
      echo $e;
      }
     echo "--------------------------------------<br/>";

  
   }
catch (PDOException $ex)
 {
  //  echo $ex->getTraceAsString();
    $response["success"] = 0;
    $response["message"] = $ex;
    die(json_encode($response));
}



}

else {
?>
    <h1>Login</h1> 
		<form action="link_group_email.php" method="post"> 
		    Group Id:<br /> 
		    <input type="text" name="groupid" placeholder="username" /> <br/>
		    
		    client Id:<br /> 
		    <input type="text" name="clientid" placeholder="username" /> 
		    
		    <input type="hidden" name="device" placeholder="username" value="" /> 
		    <br /><br /> 
		    <input type="submit" value="Login" /> 
		    
		</form> 
		<a href="register.php">Register</a>
	<?php
}


?>