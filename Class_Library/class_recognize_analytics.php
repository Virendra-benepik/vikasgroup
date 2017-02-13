<?php
include_once('class_connect_db_Communication.php');

class RecognizeAnalytic
{
  public $DB;
  public function __construct()
  {
       $db = new Connection_Communication();
       $this->DB = $db->getConnection_Communication();
  
  }

  public $idclient;
 
  function getRecognizeClientIncome($client_id)
  {
$this->idclient = $client_id;
$status = "Approve";
      try{
     $query = "SELECT SUM( points ) AS totalpoints, DATE_FORMAT(dateOfEntry,'%d %b %Y') as dateOfEntry FROM Tbl_RecognizedEmployeeDetails WHERE clientId =:cid AND status =:app GROUP BY date(dateOfEntry)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':app',$status, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
            return json_encode($row);      
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }
  
  public $id_recog;

  function getRecognizeClientTopic($client_id)
  {
    $this->idclient = $client_id;
$status = "Approve";
      try{
      
      $query1 = "select recognizeTitle,points from Tbl_RecognizeTopicDetails where clientId =:cid";
      $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
            $stmt1->execute();
            $row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            $countclitopic = count($row1);
                   
      
     $query = "SELECT *, DATE_FORMAT(dateOfEntry,'%d %b %Y') as dateOfEntry FROM RecognizedEmployeeDetails WHERE clientId =:cid AND status =:app";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':app',$status, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $count = count($row);
            $totaltopic = array(); 
            for($i=0;$i<$count;$i++)
            {
            $topic = $row[$i]['topic'];
            $val = explode("&",$topic);
            $counttopic = count($val);
         for($k=0;$k<$counttopic;$k++)
         {
        // echo $val[$k];
         array_push($totaltopic,trim($val[$k]));
         }           
         }
          $uniquetopic = array_count_values($totaltopic);
     //  print_r($uniquetopic);
        $vrt = array();
        $topicarray = array();
         for($k=0;$k<$countclitopic;$k++)
         {
         $topicpoints = $row1[$k]['points'];
          $topic1 = $row1[$k]['recognizeTitle']." (".$topicpoints.")";
          $topic = $row1[$k]['recognizeTitle'];
          $no = $uniquetopic[$topic];
       //  echo "these are topic ".$topic."-".$no."<br>";
         $vrt['title'] = $topic;
         $vrt['no'] = $no;
         $vrt['topicvalue'] = $topic1;
         $vrt['amount'] = $no * $topicpoints ;
         array_push($topicarray,$vrt);
        // array_push($vrt['no'],$no);
         }
      /*  echo "<pre>";
     print_r($totaltopic);
     echo "</pre>";
     
      echo "<pre>";
     print_r($topicarray);
     echo "</pre>";*/
    
   
    $val = count($uniquetopic);
   // echo "value count ".$val;
    
  /*******************************************************************************************/  
     $countregtopic = count($totaltopic);
     $recogtopic = array();
     $recgtopic['title'] = array();
     for($t=0;$t<$countclitopic;$t++)
     {
     $clienttopic = $row1[$t]['recognizeTitle'];
  $amount = $row1[$t]['points'];
   
     }
         
          return json_encode($topicarray);      
     }
     catch(PDOException $e)
     {
     echo $e;
     }
          }
          
 
 public $status;
 public $regid; 
 public $topic;
 public $uid;
 public $point;
 public $recozby;
                        
                        
       //  updaterecognizestatus($rzid,$status,$cid,$topic,$userid,$point);          
function getVoucherDetails($regid,$status,$cid,$topic,$uid,$recozby,$point)
 {

$this->regid = $regid;
$this->status = $status;
$this->idclient = $cid;
$this->topic = $topic;
$this->uid = $uid;
$this->recozby = $recozby;
$this->point = $point;

//echo "points -".$this->point;

$this->recozby = $recozby;
date_default_timezone_set('Asia/Kolkata');
$date = date("Y-m-d H:i:s A");
if($this->status == "Reject")
{
try{
     $query = "update RecognizedEmployeeDetails SET status =:sta where recognitionId =:rid and clientId =:cid";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':rid',$this->regid, PDO::PARAM_STR);
             $stmt->bindParam(':sta',$this->status, PDO::PARAM_STR);
              $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
             $response = array();
                 if($stmt->execute())
                 {
                  $response["success"] = 1;
                     $response["message"] = "Recognition status has changed successfully";
                     return json_encode($response);
                 }
        }
        catch(PDOException $t)
        {
        echo $t;
        }         
}


if($this->status == "Approve")
{
$account_status = "Credited";
//echo $uid;
$totalpointsdata = self::getMaxtotalPoints($cid,$uid);
$ert = json_decode($totalpointsdata,true);
/*echo "<pre>";
print_r($ert);
echo "</pre>";*/
//echo "total point ".$ert['data'][0]['totalPoints'];
//echo $ert['success'];
if($ert['success'] == 1)
{
               // $ert['data'][0]['totalPoints']
$totlpoint =  $ert['data'][0]['totalPoints']+$this->point;
}
else
{
$totlpoint = $this->point;
}
echo "total_point ".$totlpoint."<br>";
     try{
     $query = "update Tbl_RecognizedEmployeeDetails SET status =:sta where recognitionId =:rid and clientId =:cid";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':rid',$this->regid, PDO::PARAM_STR);
             $stmt->bindParam(':sta',$this->status, PDO::PARAM_STR);
              $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
             $response = array();
                 if($stmt->execute())
                  {
                  
               $query1 = "insert into Tbl_RecognizeApprovDetails(clientId,recognizeId,userId,recognizeBy,quality,points,totalPoints,entryDate,stmtStatus,regStatus)
               values(:cid,:rid,:uid,:uid1,:qul,:pts,:tpts,:edate,:regstatus,:ststatus)";   
                  
                   $stmt = $this->DB->prepare($query1);
             $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
             $stmt->bindParam(':rid',$this->regid, PDO::PARAM_STR);
              $stmt->bindParam(':uid',$this->uid, PDO::PARAM_STR);
               $stmt->bindParam(':uid1',$this->recozby, PDO::PARAM_STR);
              $stmt->bindParam(':qul',$this->topic, PDO::PARAM_STR);
               $stmt->bindParam(':pts',$this->point, PDO::PARAM_STR);
                $stmt->bindParam(':tpts',$totlpoint, PDO::PARAM_STR);
                 $stmt->bindParam(':edate',$date, PDO::PARAM_STR);
                  $stmt->bindParam(':ststatus',$this->status, PDO::PARAM_STR);
                   $stmt->bindParam(':regstatus',$account_status, PDO::PARAM_STR);
             $response = array();
                 if($stmt->execute())
                  
                     $response["success"] = 1;
                     $response["message"] = "Recognition status has changed successfully";
                     return json_encode($response);
                  }
         }
     catch(PDOException $e)
     {
     echo $e;
     } 
 }
		
	}	
	
	function getMaxtotalPoints($cid,$uid)
	{
	$this->idclient = $cid;
	$this->uid = $uid;
	//echo "userid:-".$this->uid."<br/>";
	//echo $this->idclient;
	try
	{
	$query = "select totalPoints from Tbl_RecognizeApprovDetails where autoId =(select max(autoId) from Tbl_RecognizeApprovDetails where clientId=:cid and userId =:uid)";
	 $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
             $stmt->bindParam(':uid',$this->uid, PDO::PARAM_STR);
	     $stmt->execute();
	     $totalpoints = $stmt->fetchAll(PDO::FETCH_ASSOC);
	     //print_r($totalpoints);
	    if(count($totalpoints)>0)
	     {
	     $response1["success"] = 1;
	     $response1['msg'] = 'data found';
             $response1["data"] = $totalpoints; 
                     return json_encode($response1);
	     }
	     else
	     {
	      $response1["success"] = 0;
	      $response1["msg"] = 'data not found';
            
                     return json_encode($response1);
	     }
	    }
	    catch(PDoException $k)
	    {
	    echo $k;
	    }
	}


function getUseVoucherDetails($clientid)
{
$this->idclient = $clientid;

    try{
    $query = "SELECT mvd.*, rrd.* , SUM(totalVoucher) as totalvoucher,SUM(voucherAmount) as totalamount
FROM MerchantVoucherDetails AS mvd Left JOIN Tbl_RecognizeRedeemDetails AS rrd ON mvd.voucherId = rrd.voucherId
GROUP BY mvd.voucherId HAVING rrd.clientId =:cid";
   
   $stmt = $this->DB->prepare($query);
   $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
    $stmt->execute();
  
    $val = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if(count($val)>0)
	     {
	     $response1["success"] = 1;
	     $response1['msg'] = 'data found';
             $response1["data"] = $val; 
                     return json_encode($response1);
	     }
	     else
	     {
	      $response1["success"] = 0;
	      $response1["msg"] = 'data not found';
            
                     return json_encode($response1);
	     }
    
    }
    catch(PDOException $e)
    {
    echo $e; 
    }

}
		  
  } 
  

?>