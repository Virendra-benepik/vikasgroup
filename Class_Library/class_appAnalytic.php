<?php
if(!class_exists("Connection_Communication"))
{include_once('class_connect_db_Communication.php');}

class AppAnalytic 
{

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }


    function getActiveUser($datefrom,$dateto) 
                {
           
        $date_from = date("Y-m-d H:i:s", strtotime($datefrom));
        $date_to = date("Y-m-d H:i:s", strtotime($dateto));
        
        
        $query = "select distinct(userUniqueId) from Tbl_Analytic_TrackUser WHERE date_of_entry BETWEEN '$date_from' AND '$date_to' group by DATE_FORMAT(date_of_entry,'%Y-%m-%d') ";
        echo $query;   
        die;
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }
}
    ?>