<?php

require_once('class_connect_db_deal.php');
require_once('class_connect_db_Communication.php');

class Deal {

    public $db_connect;
    public $db_analysis;

    public function __construct() {

        $dbh = new Connection_Deal();
        $this->db_connect = $dbh->getConnection_Deal();

        $dbh1 = new Connection_Communication();
        $this->db_mahle = $dbh1->getConnection_Communication();
    }

    function dealDisplay($store_id) {
        try {
            $query = "SELECT * FROM online_deals where dealtype = 'On' AND store_id=:id And offertype='Coupen' order by priority ASC";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id', $store_id, PDO::PARAM_STR);
            if($stmt->execute()){
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            $response["success"] = 0;
            $response["message"] = "Database Error!";

        }
//            echo json_encode($response);
            return $response;
    }

}

?>