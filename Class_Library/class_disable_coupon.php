<?php

include_once('class_connect_db_deal.php');

class Coupon {

    public $DB;

    public function __construct() {
        $db = new Connection_Deal();
        $this->DB = $db->getConnection_Deal();
    }

    function disableCoupon($dealid, $coupon) {
        $this->dealid = $dealid;
        $this->coupon = $coupon;
        
        date_default_timezone_set('Asia/Calcutta');
        $post_date = date('Y-m-d H:i:s A');
        $status = "Hide";
        try {
            $query = "Update DealCouponCode_demo set status =:sts, createdDate =:dte  where dealId = :did and couponCode =:cod ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':did', $this->dealid, PDO::PARAM_STR);
            $stmt->bindParam(':cod', $this->coupon, PDO::PARAM_STR);
            $stmt->bindParam(':sts', $status, PDO::PARAM_STR);
            $stmt->bindParam(':dte', $post_date, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $res['success'] = 1;
                $res['msg'] = "coupon status updated hide";
            }
        } catch (PDOException $e) {

            $res['success'] = 0;
            $res['msg'] = "coupon status updated hide" . $e;
        }

        return json_encode($res);
    }

}

?>