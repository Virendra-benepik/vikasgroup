<?php
include_once('class_connect_db_Communication.php');
include_once('class_connect_db_deal.php');

//error_reporting(E_ALL);
class BookAppoint {

    public $DB;
//    public $db_connect;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();

//        $dbh = new Connection_Deal();
//        $this->db_connect = $dbh->getConnection_Deal();
    }

    function BookAppointment($clientid, $employeeid, $dealid, $branchid, $dates, $times, $mobile, $service, $comment) {

        date_default_timezone_set('Asia/Calcutta');
        $bdate = date('Y-m-d H:i:s');

        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $dbh = new Connection_Deal();
                $json['val'] = array();
                $file = "bookappointment.php";
                $jsonArr = array("dealid"=>$dealid, "branchid"=>$branchid);
                $result1 = json_decode($dbh->discountingCurl($jsonArr, $file), true);

//                print_r($result1);die;
//                $query = "select sms_details.*,deal.merchant_name,deal.category from sms_details join deal where sms_details.branch_id=:bid and deal.deal_id=:did";
//                $stmt = $this->db_connect->prepare($query);
//                $stmt->bindParam(':did', $dealid, PDO::PARAM_STR);
//                $stmt->bindParam(':bid', $branchid, PDO::PARAM_STR);
//                $stmt->execute();
//                $result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                
                if (!empty($result1['result'])) {
                    $response = array();

                    foreach ($result1['result'] as $row) {
                        
                        $response["posts"] = array();

                        $post["userName"] = $result['firstName'] . " " . $result['lastName'];
                        $post["userMail"] = $result['emailId'];
                        $post["contact"] = $mobile;
                        $post["merchantMobile"] = $row["details"];
                        $post["merchantEmail"] = $row["email_id"];
                        $post["merchantBranchLocation"] = $row["branch_name"];
                        $post["merchantName"] = $row["merchant_name"];
                        $post["category"] = $row["category"];
                        array_push($response["posts"], $post);
                    }
//                    print_r($response['posts']);die;
                    $merchantNam = $response['posts'][0]["merchantName"];
                    $branchNam = $response['posts'][0]["merchantBranchLocation"];

                    $response["success"] = 1;
                    $response["message"] = "Your Request has been forwaded to " . $merchantNam;

//                    echo'<pre>';print_r($response);die;
                    $query = "insert into Tbl_EmployeeBookAppointment(clientId,dealId,branchId,merchantName,locationForBooking,Mobile,Date,Time, userUniqueId,comment, createdDate,service) values(:cli,:did,:bid,:mnam,:lfb,:mob,:dat,:tim,:uui,:com,:cdat,:ser)";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                    $stmt->bindParam(':did', $dealid, PDO::PARAM_STR);
                    $stmt->bindParam(':bid', $branchid, PDO::PARAM_STR);
                    $stmt->bindParam(':mnam', $merchantNam, PDO::PARAM_STR);
                    $stmt->bindParam(':lfb', $branchNam, PDO::PARAM_STR);
                    $stmt->bindParam(':mob', $mobile, PDO::PARAM_STR);
                    $stmt->bindParam(':dat', $dates, PDO::PARAM_STR);
                    $stmt->bindParam(':tim', $times, PDO::PARAM_STR);
                    $stmt->bindParam(':uui', $employeeid, PDO::PARAM_STR);
                    $stmt->bindParam(':com', $comment, PDO::PARAM_STR);
                    $stmt->bindParam(':cdat', $bdate, PDO::PARAM_STR);
                    $stmt->bindParam(':ser', $service, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        return $response;
                    }
                }
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "You are not authorised User";
                return $response;
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
            $response["posts"] = $e;
            return $response;
        }
    }

}

?>