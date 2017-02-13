<?php

require_once('class_connect_db_deal.php');
require_once('class_connect_db_Communication.php');

class Category {

    public $db_connect;
    public $db_analysis;

    public function __construct() {

        $dbh = new Connection_Deal(/* ... */);
        $this->db_connect = $dbh->getConnection_Deal();

        $dbh1 = new Connection_Communication();
        $this->db_communication = $dbh1->getConnection_Communication();
    }

    function categoryDisplay($clientid, $employeeid) {

        try {
            $query1 = "select Tbl_ClientDetails_Master.client_id, Tbl_ClientDetails_Master.categoryHide from Tbl_ClientDetails_Master join Tbl_EmployeeDetails_Master as ed on ed.clientId = Tbl_ClientDetails_Master.client_id  where Tbl_ClientDetails_Master.client_id=:cli1 and ed.employeeId =:empid";
            $stmt1 = $this->db_communication->prepare($query1);
            $stmt1->bindParam(':cli1', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            if ($stmt1->execute()) {
                $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            }

            $query = "select d_category.* from d_category  where d_category.dc_id !=:hidcat";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':hidcat', $result1[0]['categoryHide'], PDO::PARAM_STR);


            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($result) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Yes, UUI:- $employeeid is a valid User";
                    $response["posts"] = $result;
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "No data found with this employeeid";
                }

                return $response;
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
            $response["posts"] = $e;
            return $response;
        }
    }

    function entryCategory($clientid, $employeeID, $device) {

        date_default_timezone_set('Asia/Calcutta');
        $cat_date = date('Y-m-d, H:i:s');

        try {
            /* $query = "insert into categoryAnalysis(employeeID,clientId,device,dateEntry) values(:empid,:packnam,:dev,:dat)";
              $stmt = $this->db_communication->prepare($query);
              $stmt->bindParam(':empid',$employeeID, PDO::PARAM_STR);
              $stmt->bindParam(':packnam',$clientid, PDO::PARAM_STR);
              $stmt->bindParam(':dev',$device, PDO::PARAM_STR);
              $stmt->bindParam(':dat',$cat_date, PDO::PARAM_STR);
              $stmt->execute(); */
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function categoryShowDeals($clientid, $employeeid, $categorynam, $location) {

        if ($location != "") {
            $query = "select d.category,d.deal_id,d.img_logo,d.percentage_offer,d.merchant_name,b.* from merchant_branch as b join deal as d join UserDetails as ud on d.deal_id = b.deal_id where ud.clientId=:cli and ud.employeeId=:empid and d.category = :category and  b.city = :location and d.status = 'active' order by d.priority";
            $query_params = array(
                ':category' => $categorynam,
                ':location' => $location,
                ':cli' => $clientid,
                ':empid' => $employeeid
            );
//execute query
        } else {
            $location = "Gurgaon";

            $query = "select d.category,d.deal_id,d.img_logo,d.percentage_offer,d.merchant_name,b.* from merchant_branch as b join deal as d join UserDetails as ud on d.deal_id = b.deal_id where ud.clientId=:cli and ud.employeeId=:empid and d.category = :category and  b.city = :location and d.status = 'active' order by d.priority";
            $query_params = array(
                ':category' => $categorynam,
                ':location' => $location,
                ':cli' => $clientid,
                ':empid' => $employeeid
            );
        }

        try {
            $stmt = $this->db_connect->prepare($query);
            $result = $stmt->execute($query_params);
        } catch (PDOException $ex) {
            echo $ex;
            $response["success"] = 0;
            $response["message"] = "Database Error!";
            die(json_encode($response));
        }

// Finally, we can retrieve all of the found rows into an array using fetchAll 
        $rows = $stmt->fetchAll();
        $imagebasepath = "http://ap.benepik.com/";

        $query2 = "select distinct(city_name) from merchant_city";
//$query_params2 = array();
        try {
            $stmt2 = $this->db_connect->prepare($query2);
            $stmt2->execute();
        } catch (PDOException $ex) {
            echo $ex;
        }


        if ($rows) {
            $response["success"] = 1;
            $response["version number"] = 1;
            $response["message"] = "Display all deals!";

            $response["posts"] = array();
            $response["posts"]["city"] = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);
            $response["posts"]["merchant"] = array();

            foreach ($rows as $row) {

                $post = array();
                $post["dealId"] = $row["deal_id"];
                $post["deal_id"] = $row["deal_id"];
                $post["merchantName"] = $row["merchant_name"];
                $post["id"] = $row["branch_id"];
                $post["image"] = $imagebasepath . $row["img_logo"];
                $post["offerHead"] = $row["percentage_offer"];
                $post["latitude"] = $row["latitude"];
                $post["longitude"] = $row["longitude"];
                $post["name"] = $row["branch_name"];
                $post["category"] = $row["category"];
                $post["address"] = $row["address"];


                array_push($response["posts"]["merchant"], $post);
            }

            return $response;
        } else {

            $response["success"] = 0;
            $response["message"] = "No Post Available!";
            $response["posts"]["city"] = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);
            return $response;
        }





        /*        try
          {

          if($location!="")
          {
          $query = "select deal.deal_id,deal.category,deal.merchant_name,concat('http://ap.benepik.com/',deal.img_deal) as deal_img, merchant_branch.branch_id,merchant_branch.branch_name,merchant_branch.address,merchant_branch.longitude,merchant_branch.latitude,offer_head.offer_head from offer_head join deal on offer_head.deal_id = deal.deal_id join merchant_branch on deal.deal_id= merchant_branch.deal_id join d_category on deal.category = d_category.dc_category join merchant_city on deal.deal_id=merchant_city.deal_id join UserDetails where UserDetails.clientId=:cli and UserDetails.employeeId=:empid and d_category.dc_id=:dcid and merchant_city.city_name=:city";

          $stmt = $this->db_connect->prepare($query);
          $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
          $stmt->bindParam(':empid',$employeeid, PDO::PARAM_STR);
          $stmt->bindParam(':dcid',$categoryid, PDO::PARAM_STR);
          $stmt->bindParam(':city',$location, PDO::PARAM_STR);
          }
          else
          {
          $query = "select deal.deal_id,deal.category,deal.merchant_name,concat('http://ap.benepik.com/',deal.img_deal) as deal_img ,merchant_branch.branch_id,merchant_branch.branch_name,merchant_branch.address,merchant_branch.longitude,merchant_branch.latitude,offer_head.offer_head from offer_head join deal on offer_head.deal_id = deal.deal_id join merchant_branch on deal.deal_id= merchant_branch.deal_id join d_category on deal.category = d_category.dc_category join UserDetails where UserDetails.clientId=:cli and UserDetails.employeeId=:empid and d_category.dc_id=:dcid";

          $stmt = $this->db_connect->prepare($query);
          $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
          $stmt->bindParam(':empid',$employeeid, PDO::PARAM_STR);
          $stmt->bindParam(':dcid',$categoryid, PDO::PARAM_STR);
          }


          if($stmt->execute())
          {
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          if($result)
          {
          $response = array();
          $response["success"] = 1;
          $response["message"] = "Yes, UUI:- $employeeid is a valid User";
          $response["posts"] = $result;
          }
          else{
          $response = array();
          $response["success"] = 0;
          $response["message"] = "Wrong category id or UUI or client id";

          }

          return $response;
          }

          }      //--------------------------------------------- end of try block
          catch(PDOException $e)
          {
          $response["success"] = 0;
          $response["message"] = "Some Error Occured Please Try Again Later To Report Please write to us at info@benepik.com";
          $response["posts"] = $e;
          return $response;

          } */
    }

    function entryShowDeals($clientid, $employeeID, $cat_id, $device) {

        date_default_timezone_set('Asia/Calcutta');
        $cat_date = date('Y-m-d, H:i:s');

        try {
            $query = "insert into Tbl_Analytic_ClickedCategory(employeeID,clientId,categoryName,device,dateEntry) values(:empid,:packnam,:cat_id,:dev,:dat)";
            $stmt = $this->db_communication->prepare($query);
            $stmt->bindParam(':empid', $employeeID, PDO::PARAM_STR);
            $stmt->bindParam(':packnam', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_STR);
            $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $cat_date, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
            $response["success"] = 0;
            $response["message"] = "Database Error!";
            die(json_encode($response));
        }
    }

    /*     * *********************************************************************************************************************************** */

    function categoryShowDealsByValue($clientid, $employeeid, $categoryid, $location) {

        $qu = "select * from Tbl_EmployeeDetails_Master where clientId =:cid and employeeId = :eid";

        $check_emp = $this->db_communication->prepare($qu);
        $check_emp->bindParam(':cid', $clientid, PDO::PARAM_STR);
        $check_emp->bindParam(':eid', $employeeid, PDO::PARAM_STR);
        if ($check_emp->execute()) {
            $ans = $check_emp->fetchAll(PDO::FETCH_ASSOC);
        }
        $count = count($ans);
        //echo "this is count-".$count;
//print_r($ans);
        if ($count == 0) {
            $response["success"] = 0;
            $response["message"] = "Sorry! You are not authorized person";
            return $response;
        } else {
            if ($location != "") {
                $query = "SELECT deal.deal_id,deal.category,deal.img_logo,deal.percentage_offer,deal.merchant_name,d_category.AppointText, merchant_branch.* from deal join merchant_branch on deal.deal_id = merchant_branch.deal_id join d_category on deal.category = d_category.dc_category where d_category.dc_id=:category and merchant_branch.city=:location and deal.status='active' order by deal.priority";
                $query_params = array(
                    ':category' => $categoryid,
                    ':location' => $location
                );
//execute query
            } else {
                $location = "Gurgaon";

                $query = "SELECT deal.deal_id,deal.category,deal.img_logo,deal.percentage_offer,deal.merchant_name,d_category.AppointText, merchant_branch.* from deal join merchant_branch on deal.deal_id = merchant_branch.deal_id join d_category on deal.category = d_category.dc_category where d_category.dc_id=:category and merchant_branch.city=:location and deal.status='active' order by deal.priority";
                $query_params = array(
                    ':category' => $categoryid,
                    ':location' => $location
                );
            }

            try {
                $stmt = $this->db_connect->prepare($query);
                $result = $stmt->execute($query_params);
            } catch (PDOException $ex) {
                echo $ex;
                $response["success"] = 0;
                $response["message"] = "Database Error!";
                die(json_encode($response));
            }

// Finally, we can retrieve all of the found rows into an array using fetchAll 
            $rows = $stmt->fetchAll();
            $imagebasepath = "http://ap.benepik.com/";

            $query2 = "select distinct(city_name) from merchant_city";
//$query_params2 = array();
            try {
                $stmt2 = $this->db_connect->prepare($query2);
                $stmt2->execute();
            } catch (PDOException $ex) {
                echo $ex;
            }


            if ($rows) {
                $response["success"] = 1;
                $response["version number"] = 1;
                $response["message"] = "Display all deals!";

                $response["posts"] = array();
                $response["posts"]["city"] = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);
                $response["posts"]["merchant"] = array();

                foreach ($rows as $row) {

                    $post = array();
//                    $post["AppointText"] = $row["AppointText"];
                    $post["dealId"] = $row["deal_id"];
//                    $post["deal_id"] = $row["deal_id"];
                    $post["merchantName"] = $row["merchant_name"];
                    $post["id"] = $row["branch_id"];
                    $post["image"] = $imagebasepath . $row["img_logo"];
                    $post["offerHead"] = $row["percentage_offer"];
                    $post["latitude"] = $row["latitude"];
                    $post["longitude"] = $row["longitude"];
                    $post["name"] = $row["branch_name"];
                    $post["category"] = $row["category"];
                    $post["address"] = $row["address"];
                    $post["city"] = $row["city"];


                    array_push($response["posts"]["merchant"], $post);
                }

                return $response;
            } else {

                $response["success"] = 0;
                $response["message"] = "No Post Available!";
                $response["posts"]["city"] = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);
                return $response;
            }
        }
    }

    /*     * ********************************************************************************************************************************** */

    function dealData($dealid, $branchid) {
        $query = "Select * FROM deal where deal_id = :id order by priority DESC";
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
                $cop = "select coupanCode from DealCoupanCode where dealId = :dilid  and  status ='Show'";
                $param = array(':dilid' => $dealid);
                $cstmt = $this->db_connect->prepare($cop);
                $cresult = $cstmt->execute($param);
                $value1 = $cstmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($value1)) {
                    $coupancode = $value1['coupanCode'];
                } else
                    $coupancode = "No coupon code required. Please click on Visit Store";
            }
            else {
                $coupancode = "No Coupan";
            }
        } catch (PDOException $err) {
            echo $err;
        }
        /*         * ****************************************************  End  **************************** */
// Finally, we can retrieve all of the found rows into an array using fetchAll 
        $rows = $stmt->fetchAll();
        $imagebasepath = "http://ap.benepik.com/";


        if ($rows) {
            $response["success"] = 1;
            $response["message"] = "Post Available!";
            $response["coupan"] = $coupancode;

            $response["posts"] = array();

            foreach ($rows as $row) {

                $offerdesc = "";
                $post = array();

                $post["image"] = $imagebasepath . $row["img_cover"];
                $post["image1"] = $imagebasepath . $row["img_logo"];
                $post["dealurl"] = $row["website"];
                $post["dealName"] = $row["merchant_name"];
                $post["doShowBookAppointmentButton"] = $row["doShowBookAppointmentButton"];
                $post["companyinfo"] = $row["about_merchant"];
                $post["branchName"] = $branchname;




                $query8 = "SELECT *  FROM branch_contact_person WHERE branch_id=:id";
                $query_params8 = array(
                    ':id' => $branchid
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

                $post["contact"] = array();
                foreach ($rows8 as $row8) {

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

                $leadContact["name"] = $row9["name"];
                $leadContact["email"] = $row9["email_id"];
                if ($row["contact_no"] == "+91")
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

            for ($i = 0; $i < count($rows10); $i++) {
                array_push($post["TermAndCondition"], $rows10[$i]["t_c"]);
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
                $offers["heading"] = $row12["offer_head"];

                $query15 = "SELECT offer_description FROM offer_desc WHERE off_head_id=:id";
                $query_params15 = array(
                    ':id' => $row12["offer_id"]
                );
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
                    array_push($offers["values"], $rows15[$i]["offer_description"]);
                }



                array_push($post["offers"], $offers);
            }

            //update our repsonse JSON data
            $response["posts"] = $post;
            return $response;
        } else {
            $response["success"] = 0;
            $response["message"] = "No Post Available!";
            die(json_encode($response));
        }
    }

    /*     * ************************************************************************************************************************************************** */

    function entryDeal($clientid, $employee, $dealNam, $device) {
        date_default_timezone_set('Asia/Calcutta');
        $deal_date = date('Y-m-d, H:i:s');

        try {
            $query = "insert into Tbl_Analytic_ClickDeal(clientId,employeeId,dealName,device,dateEntry) values(:packnam,:uui,:cat,:dev,:dat)";
            $stmt = $this->db_communication->prepare($query);
            $stmt->bindParam(':packnam', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':uui', $employee, PDO::PARAM_STR);
            $stmt->bindParam(':cat', $dealNam, PDO::PARAM_STR);
            $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $deal_date, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*
      function getSubLocations()
      {

      try
      {
      $query = "select distinct(city_name) from merchant_city";
      $stmt = $this->db_connect->prepare($query);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
      if($result)
      {
      $response["city"] = $result;
      }
      }
      catch(PDOException $e)
      {
      echo $e;
      }
      return $response;
      } */
}

?>