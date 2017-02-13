<?php

include_once('class_connect_db_Communication.php');

class Alumni {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    /**     * ********************************* check user registration ******************************************* */
    function searchAlumni($clientid, $employeeid, $searchkey, $limit = "") {
        $this->keyword = "%" . $searchkey . "%";
        //  $path = dirname(SITE_URL) . "/";
        $path = site_url;
        try {
            $query = "select edm.firstName,edm.location,edm.grade,epd.userCompanyname from Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId AND edm.employeeCode = epd.employeeCode where edm.clientId = :cid AND edm.employeeId = :empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $name = $row['firstName'];
                $location = $row['location'];
                $batch = $row['grade'];
                $companyname = $row['userCompanyname'];
            }
            if (!empty($name) && !empty($location) && !empty($batch) && !empty($companyname)) {
                if (!empty($searchkey)) {
                    /*                     * **************************************** total count ******************************* */
                    $query1 = "select count(edm.autoId) as totalemployee from Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId where (edm.firstName like '" . $this->keyword . "' or edm.location like '" . $this->keyword . "' or edm.grade like '" . $this->keyword . "' or epd.userCompanyname like '" . $this->keyword . "') AND edm.clientId = :clientid order by edm.autoId asc";

                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':clientid', $clientid, PDO::PARAM_STR);
                    $stmt1->execute();
                    $total = $stmt1->fetch(PDO::FETCH_ASSOC);

                    /*                     * ************************************* employee record ************************************ */
                    $query = "select edm.autoId,edm.userId,edm.clientId,edm.employeeCode,edm.employeeId,CONCAT(CONCAT(UCASE(LEFT(edm.firstName, 1)), SUBSTRING(edm.firstName, 2)),' ',CONCAT(UCASE(LEFT(edm.lastName, 1)), SUBSTRING(edm.lastName, 2)))as name,edm.contact,edm.emailId,edm.location,edm.designation,edm.department,if(epd.userImage IS NULL or epd.userImage = '', '',CONCAT('" . $path . "',epd.userImage)) as userImage,epd.userCompanyname,edm.grade from Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId where (edm.firstName like '" . $this->keyword . "' or edm.contact like '" . $this->keyword . "' or edm.location like '" . $this->keyword . "' or edm.grade like '" . $this->keyword . "' or epd.userCompanyname like '" . $this->keyword . "') AND edm.clientId = :clientid ORDER BY edm.autoId ASC LIMIT :limit,5";


                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':clientid', $clientid, PDO::PARAM_STR);
                    $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
                    $response = array();
                    $stmt->execute();
                    $searchdata = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($searchdata)) {
                        $response["Success"] = 0;
                        $response["Message"] = "There is no result ";
                        return json_encode($response);
                    } else {
                        $response["Success"] = 1;
                        $response["flag"] = 1;
                        $response["Message"] = "search result show here";
                        $response["total_posts"] = $total['totalemployee'];
                        $response["Posts"] = $searchdata;
                        return json_encode($response);
                    }
                } else {

                    /*                     * **************************************** total count ******************************* */
                    $query1 = "select count(autoId) as totalemployee from Tbl_EmployeeDetails_Master where grade =:batch AND clientId =:clientid order by autoId asc";

                    $stmt2 = $this->DB->prepare($query1);
                    $stmt2->bindParam(':clientid', $clientid, PDO::PARAM_STR);
                    $stmt2->bindParam(':batch', $batch, PDO::PARAM_STR);
                    $stmt2->execute();
                    $total = $stmt2->fetch(PDO::FETCH_ASSOC);
                    //echo "<pre>";
                    //	print_r($total);
                    /*                     * ************************************* employee record ************************************ */

                    $query2 = "select edm.autoId,edm.userId,edm.clientId,edm.employeeCode,edm.employeeId,CONCAT(edm.firstName,' ',edm.lastName)as name,edm.contact,edm.emailId,edm.location,edm.designation,edm.department,if(epd.userImage IS NULL or epd.userImage = '', '',CONCAT('" . $path . "',epd.userImage)) as userImage,epd.userCompanyname,edm.grade from Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId where edm.grade =:batch and edm.clientId = :clientid ORDER BY edm.firstName ASC LIMIT $limit,5";

                    $stmt3 = $this->DB->prepare($query2);
                    $stmt3->bindParam(':clientid', $clientid, PDO::PARAM_STR);
                    $stmt3->bindParam(':batch', $batch, PDO::PARAM_STR);
                    // $stmt3->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
                    $stmt3->execute();
                    $searchdata = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                    //	print_r($searchdata);
                    /*                     * ******************************************************************* */


                    $response["Success"] = 1;
                    $response["flag"] = 1;
                    $response["Message"] = "Please Complete Your Profile .";
                    $response["total_posts"] = $total['totalemployee'];
                    $response["Posts"] = $searchdata;
                    return json_encode($response);
                }
            } else {
                $response["Success"] = 1;
                $response["flag"] = 2;
                $response["Message"] = "Please complete your profile first.";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>