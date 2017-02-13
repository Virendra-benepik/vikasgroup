<?php
//$hostname = "localhost";
//$username = "root";
//$password = "";
//$dbname = "benepik";
//$dns = "mysql:host=$hostname;dbname=$dbname;charset=utf8";
//$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
?>
<?php
class Connection_Client{

    protected $db;

    public function Connection_Client(){

    $conn = NULL;

        try{
		    $conn = new PDO("mysql:host=localhost;dbname=employee_benepik_client;charset=utf8","employee_client","benepik@100%");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo 'ERROR: ' . $e->getMessage();
                }   
            $this->db = $conn;
    }
   
    public function getConnection_Client(){
        return $this->db;
    }
}

?>