<?php 
require_once('class_connect_db_admin.php');
require_once('class_get_useruniqueid.php');
/**-----       $db_connect     is object of connection page ---------------------------------**/

class RedeemPoint
{
	 public $db_connect;
	
	 public function __construct()
        {
                $dbh = new Connection(/*...*/);
		$this->db_connect =  $dbh->getConnection();
		
         }
    
    public $clientid;
    public $uuid;
    public $voucherid;
    public $noofvoucher;
    public $voucheramount;
    public $balance;
                             
    function createRedeemPoint($clientid,$uuid,$vid,$vname,$vno,$vamount,$balance)
    {
    $this->clientid = $clientid;
    $this->uuid = $uuid;
    $this->voucherid = $vid;
    $this->noofvoucher = $vno;
    $this->voucheramount = $vamount;
    $this->balance = $balance;
    $remainamount = $this->balance - $this->voucheramount;
    date_default_timezone_set('Asia/Calcutta');
    $cdate = date("Y-m-d H:i:s");
    try
    {
  $query = "insert into RecognizeRedeemDetails(clientId,uid,voucherId,totalVoucher,voucherAmount,totalAmount,balance,entryDate)
  values(:cid,:uid,:vid,:tvoucher,:voucheramount,:totalamount,:balance,:rdate)";
   
     $stmt1 = $this->db_connect->prepare($query);
     $stmt1->bindParam(':cid',$this->clientid,PDO::PARAM_STR);
     $stmt1->bindParam(':uid',$this->uuid,PDO::PARAM_STR);
      $stmt1->bindParam(':vid',$this->voucherid,PDO::PARAM_STR);
       $stmt1->bindParam(':tvoucher',$this->noofvoucher,PDO::PARAM_STR);
        $stmt1->bindParam(':voucheramount',$this->voucheramount,PDO::PARAM_STR);
         $stmt1->bindParam(':totalamount',$this->balance,PDO::PARAM_STR);
          $stmt1->bindParam(':balance',$remainamount,PDO::PARAM_STR);
           $stmt1->bindParam(':rdate',$cdate,PDO::PARAM_STR);
         if ($stmt1->execute());
    {
    
    $getname = new UserUniqueId(); 
    $userdetails = $getname->getUserData($this->clientid,$this->uuid);
   // echo $userdetails;
    $det = json_decode($userdetails,true);
  /*  echo "<pre>";
    print_r($det1);
    echo "</pre>";*/
    $name = $det[0]['firstName']." ".$det[0]['lastName']; 
    $email = $det[0]['emailId']; 
  /*********************************** mail to hr ***********************************/   
$to = 'virendra@benepik.com';
$subject = 'Request for Voucher';
$from = 'mahlecare@benepik.com';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$headers .= 'From:'.$email. "\r\n";
//Multiple CC can be added, if we need (comma separated);
$headers .= 'Cc: saurabh.jain@benepik.com,' . "\r\n";
//Multiple BCC, same as CC above;
/*$headers .= 'Bcc: myboss3@example.com, myboss4@example.com' . "\r\n";*/

// Compose a simple HTML email messag
$message = '<html><body>';
$message .= '<h3>Dear Sir,</h3>';
$message .= '<p><b>'.$name.'('.$email.')</b> has placed order for voucher. The voucher Details are as follows</p>';
$message .= '<p><b>Brochure Name</b> : '.$vname.'</p>';
$message .= '<p><b>No. of Brochure</b> : '.$vno.'</p>';
$message .= '<p><b>Total Amount </b> : '.$vamount.'</p><br><br>';

$message .= '<p>Thanks</p>';
$message .= '<p>Benepik Team</p>';

$message .= '</body></html>';

if(mail($to, $subject, $message, $headers)){

   // echo 'Your mail has been sent successfully.';

} else{

   // echo 'Unable to send email. Please try again.';

}
  
 /************************************************************************/ 
    
    $result["success"] = 1;
    $result["msg"] = "Data successfully inserted";
     return json_encode($result);
     }
     }
     catch(PDOException $es)
     {
     echo $es;
      $result["success"] = 0;
    $result["msg"] = "Data not inserted";
     return json_encode($result);
     }
    
    }
 }
    ?>