<?php

//$hostname = "localhost";
//$username = "root";
//$password = "";
//$dbname = "benepik";
//$dns = "mysql:host=$hostname;dbname=$dbname;charset=utf8";
//$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
?>
<?php

define('base_path', $_SERVER['DOCUMENT_ROOT'] . dirname(dirname(dirname($_SERVER['PHP_SELF']))) );
define('site_url', 'http://' . $_SERVER['SERVER_NAME'] . dirname(dirname(dirname($_SERVER['PHP_SELF']))) . '/');

class Connection_Communication {

    protected $db;

    public function Connection_Communication() {

        $conn = NULL;
        date_default_timezone_set('Asia/Kolkata');

        try {
       
 $conn = new PDO("mysql:host=localhost;dbname=Test_vikasgroup;charset=utf8", "root", "veeru@123 ");
     //       $conn = new PDO("mysql:host=localhost;dbname=employee_DB_Benepik_demo;charset=utf8mb4_unicode_ci", "root", "benepik123");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        $this->db = $conn;
    }

    public function getConnection_Communication() {
        return $this->db;
    }

	/********************************************************************	
	
	| Connection for discounting api
	
    **********************************************************************/
	
    public function discountingCurl($jsonArr, $file) {
        $url = "http://thomasinternational.benepik.com/webservices/ionicDISCOUNTINGapis/" . $file;

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

        return $result;
    }

}

?>
