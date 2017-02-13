<?php

require_once('class_connect_db_Communication.php');

class UserDirectory {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication(/* ... */);
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function getLocationDepartment($cid) {
        $this->clientids = $cid;

        try {
            $query = "select distinct(location) as location from Tbl_EmployeeDetails_Master where clientId =:id1 ";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

           $query = "select distinct(department) as department from Tbl_EmployeeDetails_Master where clientId =:id1 ";
            $stmtd = $this->db_connect->prepare($query);
            $stmtd->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
            $stmtd->execute();
            $rows1 = $stmtd->fetchAll(PDO::FETCH_ASSOC);

            if (count($rows) > 0) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['location'] = $rows;
                $response['department'] = $rows1;
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Location Available for Contact List";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return $response;
    }

    function viewDepartments($cid, $locid) {
        $this->clientid = $cid;
        $this->locationid = $locid;

        try {
           // $query = "select distinct(department) as department from Tbl_EmployeeDetails_Master where clientId =:id1 and location=:loc";
            $query = "select autoId, department from Tbl_EmployeeDetails_Master where clientId =:id1 and location=:loc group by (department)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id1', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':loc', $this->locationid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
           // print_r($rows);
            if (count($rows) > 0) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = array();
                foreach ($rows as $row) {
                    
                      $post["departmentName"] = $row["department"];
                      $post["autoid"] = $row["autoId"];
                      $post["location"] = $this->locationid;
                    array_push($response['posts'], $post);
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Department Available for this location";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = "Client id or location id is incorrect -" . $e;
            //echo $e;                
        }
        return $response;
    }

    function viewContactDetails($cid, $loc, $depart) {
        $this->clientids = $cid;
        $this->locations = $loc;
        $this->department = $depart;
        $server_name = site_url;

        try {
            if ($this->department != "") {

                $query = "select edm.*,if(epd.userImage IS NULL or epd.userImage='','', ConCat('$server_name',epd.userImage)) as imgpath from  Tbl_EmployeeDetails_Master  as edm left join Tbl_EmployeePersonalDetails as epd on "
                        . "epd.employeeCode = edm.employeeCode where edm.clientId =:id1 and edm.location=:loc and edm.department = :dep";
                $stmt = $this->db_connect->prepare($query);

                $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
                $stmt->bindParam(':loc', $this->locations, PDO::PARAM_STR);
                $stmt->bindParam(':dep', $this->department, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $query = "select edm.*,if(epd.userImage IS NULL or epd.userImage='','', ConCat('$server_name',epd.userImage)) as imgpath from  Tbl_EmployeeDetails_Master  as edm left join Tbl_EmployeePersonalDetails as epd on "
                        . "epd.employeeCode = edm.employeeCode where edm.clientId =:id1 and edm.location=:loc";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
                $stmt->bindParam(':loc', $this->locations, PDO::PARAM_STR);
                $stmt->execute();
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

//            	print_r($rows);die;

            if ($rows) {

                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = $rows;
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Contact Person Found";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return $response;
    }

}

?>