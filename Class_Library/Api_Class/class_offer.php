<?php

require_once('class_connect_db_deal.php');
require_once('class_connect_db_Communication.php');

class Offer {

    public $db_connect;
    public $db_analysis;

    public function __construct() {

        $dbh = new Connection_Deal();
        $this->db_connect = $dbh->getConnection_Deal();

        $dbh1 = new Connection_Communication();
        $this->db_mahle = $dbh1->getConnection_Communication();
    }

    public function offerDetails($dealid, $branchid) {
        //initial query
//    $query = "Select * FROM deal where deal_id = :id order by priority DESC";

        $query = "Select deal.*, d_category.options, d_category.OptionsHeading, d_category.AppointText FROM deal, d_category where deal.category = d_category.dc_category and  deal_id =:id order by priority DESC";

        $query_params = array(':id' => $dealid);
//execute query
        try {
            $stmt = $this->db_connect->prepare($query);
            $result = $stmt->execute($query_params);
        } catch (PDOException $ex) {
            $response["success"] = 0;
            $response["message"] = "Database Error!";
            die(json_encode($response));
        }

        $rows = $stmt->fetchAll();
        /*         * **************************************************************** Start *********************** */
        $qry = "select * from merchant_branch where deal_id=:did and branch_id=:bid";
        $query_params12 = array(':did' => $dealid, ':bid' => $branchid);
        try {
            $stmt12 = $this->db_connect->prepare($qry);
            $result12 = $stmt12->execute($query_params12);
            $value = $stmt12->fetchAll(PDO::FETCH_ASSOC);


            $branchname = $value[0]["branch_name"];
            $dealid = $value[0]['deal_id'];
            if ($branchname == "Buy Online") {
                $cop = "select autoId,dealId,dealText,couponCode,status,coupon_type from DealCouponCode_demo where dealId = :dilid  and  status ='Show'";
                $param = array(':dilid' => $dealid);
                $cstmt = $this->db_connect->prepare($cop);
                $cresult = $cstmt->execute($param);
                //$value1 =  $cstmt->fetch(PDO::FETCH_ASSOC);

                if ($rows[0]['coupon_type'] == '1') {
                    $value1 = $cstmt->fetch(PDO::FETCH_ASSOC);
                    //$value1['couponCode'] = $value1['couponCode'];
                } else {
                    $value1 = $cstmt->fetchAll(PDO::FETCH_ASSOC);
                    //$value1['couponCode'] = $value1[0]['couponCode'];
                }
                //echo'<pre>';print_r($value1);die;

                if (!empty($value1)) {
                    $couponCode = $value1['couponCode'];
                } else {
                    $couponCode = "No coupon code required. Please click on Visit Store";
                }
            } else {
                $couponCode = "No Coupon";
            }
        } catch (PDOException $err) {
            echo $err;
        }
        /*         * ****************************************************  End  **************************** */

// Finally, we can retrieve all of the found rows into an array using fetchAll 
        $imagebasepath = "http://ap.benepik.com/";

        if ($rows) {
            $response["success"] = 1;
            $response["message"] = "Post Available!";
            $response["posts"] = array();

            foreach ($rows as $row) {

                $offerdesc = "";
                $post = array();


                $post['deal_id'] = $row['deal_id'];
                $post['dealName'] = $row['merchant_name'];
                $post["image"] = $imagebasepath . $row["img_cover"];
                $post["dealurl"] = $row["website"];
                //$post["deal_type"]  = 'C';

                if ($branchname == "Buy Online") {
                    $post["deal_type"] = "C";
                } else {
                    $post["deal_type"] = "BA";
                }

                //Added options and OptionsHeadingon 23-Sep-2016 
                $post["options"] = $row["options"];
                $post["services"] = $row["OptionsHeading"];
                $post["catName"] = $row["category"];

                $post["doShowBookAppointmentButton"] = $row["doShowBookAppointmentButton"];
                $post["companyinfo"] = $row["about_merchant"];

                $post["coupon_type"] = "";
                //echo'<pre>';print_r($value1);die;
                if ($post["deal_type"] == 'C') {
                    $post["button_text"] = "Buy Now";

                    if ($rows[0]['coupon_type'] == '1') {
                        $post["coupon_type"] = $value1["coupon_type"];
                        //$coupon_code_data = explode(',',$value1['couponCode']);

                        $post["coupon_detail"] = $value1;

                        $coup["id"] = $value1["autoId"];
                        $coup["code"] = trim($value1['couponCode']);
                        $coup["desc"] = trim($value1['dealText']);
                        $coupon[] = $coup;
                    } else {
                        $post["coupon_type"] = $rows[0]['coupon_type'];
                        $post["coupon_detail"] = $value1;

                        foreach ($value1 as $code) {
                            //$coupon_data = explode(':',$code);

                            $coup["id"] = $code["autoId"];
                            $coup["code"] = trim($code['couponCode']);
                            $coup["desc"] = trim($code['dealText']);
                            $coupon[] = $coup;
                        }
                    }


                    $post["coupon_detail"] = !empty($coupon) ? $coupon : array();
                    $post["no_coupon_text"] = empty($coupon) ? "No coupon code required. Please click on Visit Store" : "";

                    //echo'<pre>';print_r($code);die;
                } else if ($post["deal_type"] == 'BA') {
                    $post["button_text"] = $row['AppointText'];
                } else {
                    $post["button_text"] = "Online Booking";
                }

                //$post["button_text"]   = $row['AppointText'];

                $post["action_url"] = "";
                $query8 = "SELECT * FROM branch_contact_person right join merchant_branch on merchant_branch.branch_id=branch_contact_person.branch_id WHERE merchant_branch.branch_id=:id and merchant_branch.deal_id=:dId";
                $query_params8 = array(
                    ':id' => $branchid,
                    ':dId' => $dealid
                );

//execute query
                try {
                    $stmt8 = $this->db_connect->prepare($query8);
                    $result8 = $stmt8->execute($query_params8);
                } catch (PDOException $ex) {
                    $response["success"] = 0;
                    $response["message"] = "Database Error!";
                    die(json_encode($response));
                }

                $rows8 = $stmt8->fetchAll();

                //echo '<pre>';print_r($rows8);die;
                $post["branch_id"] = $rows8[0]["branch_id"];
                $post["location"] = $rows8[0]["city"];

                $post["contact"] = array();

                foreach ($rows8 as $row8) {
                    if (!empty($row8["contact_id"])) {
                        $contact["contact_id"] = $row8["contact_id"];
                        $contact["name"] = $row8["person_name"];
                        $contact["designation"] = $row8["designation"];
                        if ($row8["contact_no"] == "+91")
                            $contact["mobile"] = "";
                        else
                            $contact["mobile"] = $row8["contact_no"];
                        $contact["email"] = $row8["email_id"];
                        array_push($post["contact"], $contact);
                    }
                }
            }

            $query9 = "SELECT *  FROM lead_contact WHERE deal_id=:id";
            $query_params9 = array(
                ':id' => $row["deal_id"]
            );

            try {
                $stmt9 = $this->db_connect->prepare($query9);
                $result9 = $stmt9->execute($query_params9);
            } catch (PDOException $ex) {
                $response["success"] = 0;
                $response["message"] = "Database Error!";
                die(json_encode($response));
            }

            $rows9 = $stmt9->fetchAll();

            $post["leadContact"] = array();
            foreach ($rows9 as $row9) {
                $leadContact['lead_id'] = $row9['ld_id'];
                $leadContact["name"] = $row9["name"];
                $leadContact["email"] = $row9["email_id"];
                if ($row9["contact_no"] == "+91")
                    $leadContact["mobile"] = "";
                else
                    $leadContact["mobile"] = $row9["contact_no"];

                $leadContact["designation"] = $row9["designation"];
                array_push($post["leadContact"], $leadContact);
            }

            $query10 = "SELECT *  FROM term_condition WHERE deal_id=:id";
            $query_params10 = array(
                ':id' => $row["deal_id"]
            );

//execute query
            try {
                $stmt10 = $this->db_connect->prepare($query10);
                $result10 = $stmt10->execute($query_params10);
            } catch (PDOException $ex) {
                $response["success"] = 0;
                $response["message"] = "Database Error!";
                die(json_encode($response));
            }

            $rows10 = $stmt10->fetchAll();


            $post["TermAndCondition"] = array();

            $termsAndCondition = array();
            for ($i = 0; $i < count($rows10); $i++) {

                $termsAndCondition['t_c_Id'] = $rows10[$i]["co_id"];
                $termsAndCondition['detail'] = $rows10[$i]["t_c"];

                $post["TermAndCondition"][] = $termsAndCondition;
            }




            $query12 = "SELECT *  FROM offer_head WHERE deal_id=:id";
            $query_params12 = array(
                ':id' => $row["deal_id"]
            );

//execute query
            try {
                $stmt12 = $this->db_connect->prepare($query12);
                $result12 = $stmt12->execute($query_params12);
            } catch (PDOException $ex) {
                $response["success"] = 0;
                $response["message"] = "Database Error!";
                die(json_encode($response));
            }
            $post["offers"] = array();

            $rows12 = $stmt12->fetchAll();

            foreach ($rows12 as $row12) {
                $offers["offer_head_id"] = $row12["offer_id"];
                $offers["heading"] = $row12["offer_head"];

                $query15 = "SELECT off_desc_id,offer_description FROM offer_desc WHERE off_head_id=:id";
                $query_params15 = array(':id' => $row12["offer_id"]);
//execute query
                try {
                    $stmt15 = $this->db_connect->prepare($query15);
                    $result15 = $stmt15->execute($query_params15);
                } catch (PDOException $ex) {
                    $response["success"] = 0;
                    $response["message"] = "Database Error!";
                    die(json_encode($response));
                }

                $rows15 = $stmt15->fetchAll();
                $offers["values"] = array();

                for ($i = 0; $i < count($rows15); $i++) {
                    $offer_description["off_desc_id"] = $rows15[$i]["off_desc_id"];
                    $offer_description["offer_description"] = $rows15[$i]["offer_description"];
                    array_push($offers["values"], $offer_description);
                }

                array_push($post["offers"], $offers);
            }

            //update our repsonse JSON data
            array_push($response["posts"], $post);
        } else {
            $response["success"] = 0;
            $response["message"] = "No Post Available!";
        }

        return $response;
    }

}

?>