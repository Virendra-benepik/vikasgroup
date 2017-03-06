<?php

require_once('class_connect_db_Communication.php');

class ContactLocation {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function getLocationDepartment($cid, $companyId) {
        $this->clientids = $cid;
        $this->companyId = $companyId;

        try {
            $query = "select locationId,locationName from Tbl_ContactDirectoryLocation where clientId =:id1 and companyId=:companyId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
            $stmt->bindParam(':companyId', $this->companyId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
           

            $query = "select departmentName,deptId from Tbl_ContactDirectoryDepartment where clientId =:id1 and companyId=:companyId";
            $stmtd = $this->db_connect->prepare($query);
            $stmtd->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
            $stmtd->bindParam(':companyId', $this->companyId, PDO::PARAM_STR);
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
            $query = "select * from Tbl_ContactDirectoryDepartment where clientId =:id1 and locationId=:loc";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id1', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':loc', $this->locationid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if (count($rows) > 0) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = array();
                foreach ($rows as $row) {
                    $post["locationId"] = $row["locationId"];
                    $post["departmentName"] = $row["departmentName"];
                    $post["deptId"] = $row["deptId"];

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

    public function viewCompanies($cid, $companyUniqueId) {
        $this->clientid = $cid;
        
        try {
            $query = "select * from Tbl_Client_CompanyDetails where clientId =:cid";
            $query .= ($companyUniqueId != '')?" and companyUniqueId='$companyUniqueId'":"";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($rows) > 0) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = array();
                foreach ($rows as $row) {
//                    $post["locationId"] = $row["locationId"];
                    $post["companyName"] = $row["companyName"];
                    $post["companyId"] = $row["companyUniqueId"];

                    array_push($response['posts'], $post);
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Company Available for this location";
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

                $query = "select Tbl_ContactDirectoryPerson.autoId,"
                        . "Tbl_ContactDirectoryPerson.contactId,"
                        . "Tbl_ContactDirectoryPerson.locationId,"
                        . "Tbl_ContactDirectoryPerson.departmentId,"
                        . "Tbl_ContactDirectoryPerson.empCode,"
                        . "Tbl_ContactDirectoryPerson.contactNoPersonal,"
                        . "Tbl_ContactDirectoryPerson.contactNoOffice,"
                        . "Tbl_ContactDirectoryPerson.designation,"
                        . "if(Tbl_EmployeePersonalDetails.userImage IS NULL or Tbl_EmployeePersonalDetails.userImage='','', ConCat('$server_name',Tbl_EmployeePersonalDetails.userImage)) as imgpath,cl.locationName, 
                        Tbl_ContactDirectoryPerson.userName,Tbl_ContactDirectoryPerson.emailId from  Tbl_ContactDirectoryPerson left join Tbl_EmployeePersonalDetails on Tbl_EmployeePersonalDetails.employeeCode =Tbl_ContactDirectoryPerson.empCode join Tbl_ContactDirectoryLocation as cl on cl.locationId = Tbl_ContactDirectoryPerson.locationId where Tbl_ContactDirectoryPerson.clientId =:id1 and Tbl_ContactDirectoryPerson.locationId=:loc and Tbl_ContactDirectoryPerson.departmentId=:dep";
                $stmt = $this->db_connect->prepare($query);

                $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
                $stmt->bindParam(':loc', $this->locations, PDO::PARAM_STR);
                $stmt->bindParam(':dep', $this->department, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $query = "select Tbl_ContactDirectoryPerson.autoId,"
                        . "Tbl_ContactDirectoryPerson.contactId,"
                        . "Tbl_ContactDirectoryPerson.locationId,"
                        . "Tbl_ContactDirectoryPerson.departmentId,"
                        . "Tbl_ContactDirectoryPerson.empCode,"
                        . "Tbl_ContactDirectoryPerson.contactNoPersonal,"
                        . "Tbl_ContactDirectoryPerson.contactNoOffice,"
                        . "Tbl_ContactDirectoryPerson.designation,"
                        . "if(Tbl_EmployeePersonalDetails.userImage IS NULL or Tbl_EmployeePersonalDetails.userImage='','', ConCat('$server_name',Tbl_EmployeePersonalDetails.userImage)) as imgpath, cl.locationName,
                        Tbl_ContactDirectoryPerson.userName,Tbl_ContactDirectoryPerson.emailId from  Tbl_ContactDirectoryPerson left join Tbl_EmployeePersonalDetails on Tbl_EmployeePersonalDetails.employeeCode =Tbl_ContactDirectoryPerson.empCode join Tbl_ContactDirectoryLocation as cl on cl.locationId = Tbl_ContactDirectoryPerson.locationId where Tbl_ContactDirectoryPerson.clientId =:id1 and Tbl_ContactDirectoryPerson.locationId=:loc";
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