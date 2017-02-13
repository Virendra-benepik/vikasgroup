<?php
$program_name = 'virendra';
$dedicateemail = 'virendra@benepik.com'; 
$to1 = "virendra.ggis@gmail.com";
$subject1 = " this is cron job  ";

$message = '<html><body>';
$message .= '<h1>Hello, Sir!</h1>';
$message .='<p> hello benepik</p>';
$message .='<p>User CSV can download from here</p>';
$message .= '</body></html>';

$headers1 = "From: ".$program_name." <".$dedicateemail."> \r\n";
$headers1 .= "MIME-Version: 1.0\r\n";
$headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
       mail($to1,$subject1,$message,$headers1);
      // $date = date("H:i:s a");
      // echo "hi cron jos working ".$date;
?>