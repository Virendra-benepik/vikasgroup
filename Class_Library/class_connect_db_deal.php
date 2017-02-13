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
}

?>