<?php

include_once('class_connect_db_Communication.php');

class WelcomePage {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $client;
    public $id;
    public $type;
    public $title;
    public $imgpath;
    public $createddate;
    public $by;

    function createWelcomeData($cid, $id, $type, $ptitle, $pimg, $pdate, $by, $FLAG, $status = '') {
        $this->client = $cid;
        $this->id = $id;
        $this->type = $type;
        //echo "status--".$status;
        $status1 = ($status ==='')?1:$status; 
        //echo "status1--".$status1;
        $this->title = $ptitle;
        $this->imgpath = $pimg;
        $this->createddate = $pdate;
        $this->by = $by;
        $this->flag = $FLAG;
        try {
            $query = "insert into Tbl_C_WelcomeDetails(clientId,id,type,title,image,createdDate,createdBy,status,flagType)
            values(:cid,:id,:type,:title,:img,:cd,:cb,:sts,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->imgpath, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->createddate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->by, PDO::PARAM_STR);
            $stmt->bindParam(':sts', $status1, PDO::PARAM_STR);
             $stmt->bindParam(':flag', $this->flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>