<?php
class Connection_Deal{

    protected $db;

//    public function Connection_Deal(){
//
//    $conn = NULL;
//
//        try{
//            $conn = new PDO("mysql:host=localhost;dbname=employee_benepik;charset=utf8","root","benepik123p");
//            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            } catch(PDOException $e){
//                echo 'ERROR: ' . $e->getMessage();
//                }   
//            $this->db = $conn;
//    }
   
    public function getConnection_Deal(){
        return $this->db;
    }
    
    public function discountingCurl($jsonArr, $file) {
        $url = "http://thomasinternational.benepik.com/webservices/discounting_Api_New/" . $file;

        // Set CURL request headers (authentication and type)       
        $headers = array(
            'Content-Type: application/json'
        );

        // Initialize curl handle       
        $ch = curl_init();

        // Set URL to GCM endpoint      
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request method to POST       
        curl_setopt($ch, CURLOPT_POST, true);

        // Set our custom headers       
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Get the response back as string instead of printing it       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set JSON post data
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonArr));

        // Actually send the push  

        $result = curl_exec($ch);

        // Error handling
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        // Close curl handle
        curl_close($ch);

//        print_r($result);die;
        return $result;
    }
}

?>