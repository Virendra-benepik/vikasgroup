<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

class ContactPerson {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    /*     * ************************* Create Module and insert data into database  ************************************* */

    public $clientid;
    public $location;
    public $department;
    public $emailid;
    public $mob;

    function createPerson($cid, $location, $dept, $employeeid, $empname, $mob_p, $mob_o, $desig, $emailid,$user) {
        $this->clientid = $cid;
        $this->location = $location;
        $this->department = $dept;

        $this->desig = $desig;
        $status = "Active";
        $createDate = date('Y-m-d H:i:s');

        try {
            $max = "select max(autoId) from Tbl_ContactDirectoryPerson";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $l_id = $tr[0];
                $l_id1 = $l_id + 1;
                $pid = "CP-" . $l_id1;
            }
        } catch (PDOException $e) {
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }


        try {
            $query = "insert into Tbl_ContactDirectoryPerson(contactId,clientId,locationId,departmentId,empCode,userName,contactNoPersonal,contactNoOffice,designation,emailid,status,createdDate,createdBy)values(:id1,:cid,:lid,:dept,:empcode,:username,:personalno,:mobofc,
		:desig,:email,'" . $status . "','" . $createDate . "',:cb)";
            $stmt = $this->db_connect->prepare($query);

            $stmt->bindParam(':id1', $pid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':lid', $this->location, PDO::PARAM_STR);
            $stmt->bindParam(':dept', $this->department, PDO::PARAM_STR);
            $stmt->bindParam(':empcode', $employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':username', $empname, PDO::PARAM_STR);
            $stmt->bindParam(':personalno', $mob_p, PDO::PARAM_STR);
            $stmt->bindParam(':mobofc', $mob_o, PDO::PARAM_STR);
            $stmt->bindParam(':desig', $this->desig, PDO::PARAM_STR);
            $stmt->bindParam(':email', $emailid, PDO::PARAM_STR);
			$stmt->bindParam(':cb', $user, PDO::PARAM_STR);


            if ($stmt->execute()) {
                $response['success'] = 1;
                $response['msg'] = "New Contact Person Successfully Added";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

//------------------------end of create module function

    function viewPerson() {

        try {
            $query = "SELECT Tbl_ClientDetails_Master. * , Tbl_ContactDirectoryPerson. * 
FROM Tbl_ClientDetails_Master
JOIN Tbl_ContactDirectoryPerson ON Tbl_ContactDirectoryPerson.clientId = Tbl_ClientDetails_Master.client_id";
            $stmt = $this->db_connect->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if ($rows) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = array();
                foreach ($rows as $row) {
                    $post["designation"] = $row["designation"];
                    $post["contact_id"] = $row["contactId"];
                    $post["clientId"] = $row["clientId"];
                    $post["client_name"] = $row["client_name"];
                    $post["contactNo"] = $row["contactNo"];
                    $post["locationId"] = $row["locationId"];
                    $post["departmentId"] = $row["departmentId"];
                    $post["contactEmail"] = $row["contactEmail"];

                    array_push($response['posts'], $post);
                }
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

//------------------------end of create module function

    function deleteContactPerson($cid) {
        $this->clientid = $cid;
        try {
            $query = "delete from Tbl_ContactDirectoryPerson where contactId =:cid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $row = $stmt->execute();

            if ($row) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Delete contact Person Details";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

    function getContactPerson($cid) {
        $this->clientid = $cid;
        echo $this->clientid;
        try {
            $query = "select * from Tbl_ContactDirectoryPerson where contactId =:cid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            print_r($rows);
            if ($rows) {
                $response['success'] = 1;
                $response['msg'] = "Successfully display contact person details";
                $response['posts'] = array();
                foreach ($rows as $row) {
                    $post["designation"] = $row["designation"];
                    $post["contactNo"] = $row["contactNo"];
                    $post["locationId"] = $row["locationId"];
                    $post["departmentId"] = $row["departmentId"];
                    $post["contactEmail"] = $row["contactEmail"];

                    array_push($response['posts'], $post);
                }
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

    function editContactPerson($cid, $conid, $empcode, $loc, $dep, $desig, $mob, $mob_o, $desig, $email,$user) {
        //function editContactPerson($cid,$conid,$mob,$mail,$loc,$dep){
        
        $this->clientid = $cid;
        $this->contactid = $conid;
        $this->mobile = $mob;
        $this->location = $loc;
        $this->depart = $dep;
        $this->mobofc = $mob_o;
        $this->desig = $desig;
        $this->email = $email;
        $updateDate = date('Y-m-d H:i:s');
//        echo'<pre>';print_r($this);die;
        try {
            $query = "update Tbl_ContactDirectoryPerson set emailId=:email,locationId =:loc,departmentId =:dep,contactNoPersonal=:mob,contactNoOffice=:mobofc,designation=:desig,updatedDate='" . $updateDate . "',updatedBy=:ub where contactId =:con and clientId =:cid";
            $stmt = $this->db_connect->prepare($query);

            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':con', $this->contactid, PDO::PARAM_STR);
            $stmt->bindParam(':mob', $this->mobile, PDO::PARAM_STR);
            $stmt->bindParam(':mobofc', $this->mobofc, PDO::PARAM_STR);
            $stmt->bindParam(':loc', $this->location, PDO::PARAM_STR);
            $stmt->bindParam(':desig', $this->desig, PDO::PARAM_STR);
            $stmt->bindParam(':dep', $this->depart, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindParam(':ub', $user, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response['success'] = 1;
                $response['msg'] = "Successfully update contact person details";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

    /*     * ************************* View main module data from database  ************************************* */


    /*     * ************************* View contact directory data from database  ************************************* */

    public $clientids;
    public $locations;

    function viewContactDetails($cid, $loc, $depart) {
        $this->clientids = $cid;
        $this->locations = $loc;
        $this->department = $depart;
        try {
            if ($this->department != "") {
                $query = "select  Tbl_ContactDirectoryPerson.locationId,Tbl_ContactDirectoryPerson.departmentId,Tbl_ContactDirectoryPerson.userUniqueId,Tbl_ContactDirectoryPerson.contactNoPersonal,Tbl_ContactDirectoryPerson.contactNoOffice,Tbl_ContactDirectoryPerson.designation, ConCat('http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/',Tbl_EmployeePersonalDetails.userImage) as userImage,Tbl_EmployeeDetails_Master.firstName,Tbl_EmployeeDetails_Master.middleName,Tbl_EmployeeDetails_Master.lastName from Tbl_ClientDetails_Master join Tbl_ContactDirectoryPerson on Tbl_ClientDetails_Master.client_id = Tbl_ContactDirectoryPerson.clientId join Tbl_EmployeePersonalDetails on Tbl_EmployeePersonalDetails.emailId = Tbl_ContactDirectoryPerson.userUniqueId join Tbl_EmployeeDetails_Master on Tbl_EmployeeDetails_Master.emailId = Tbl_EmployeePersonalDetails.emailId where Tbl_ContactDirectoryPerson.clientId =:id1 and Tbl_ContactDirectoryPerson.locationId=:loc and Tbl_ContactDirectoryPerson.departmentId=:dep";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
                $stmt->bindParam(':loc', $this->locations, PDO::PARAM_STR);
                $stmt->bindParam(':dep', $this->department, PDO::PARAM_STR);
            } else {
                $query = "select  Tbl_ContactDirectoryPerson.locationId,Tbl_ContactDirectoryPerson.departmentId,Tbl_ContactDirectoryPerson.userUniqueId,Tbl_ContactDirectoryPerson.contactNoPersonal,Tbl_ContactDirectoryPerson.contactNoOffice,Tbl_ContactDirectoryPerson.designation,ConCat('http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/',Tbl_EmployeePersonalDetails.userImage) as userImage,Tbl_EmployeeDetails_Master.firstName,Tbl_EmployeeDetails_Master.middleName,Tbl_EmployeeDetails_Master.lastName from Tbl_ClientDetails_Master join Tbl_ContactDirectoryPerson on Tbl_ClientDetails_Master.client_id = Tbl_ContactDirectoryPerson.clientId join Tbl_EmployeePersonalDetails on Tbl_EmployeePersonalDetails.emailId = Tbl_ContactDirectoryPerson.userUniqueId,join Tbl_EmployeeDetails_Master on Tbl_EmployeeDetails_Master.emailId = Tbl_EmployeePersonalDetails.emailId where Tbl_ContactDirectoryPerson.clientId =:id1 and Tbl_ContactDirectoryPerson.locationId=:loc";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
                $stmt->bindParam(':loc', $this->locations, PDO::PARAM_STR);
            }
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {

                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = $rows;
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Display data";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

    /*     * ************************* client contact directory database  ************************************* */

    function clientContactDetails($cid1) {
        $this->clientids = $cid1;
        $server_name = SITE_URL;
        try {
            $query = "select Tbl_ContactDirectoryPerson.contactId,
            Tbl_ContactDirectoryPerson.locationId,
            Tbl_ContactDirectoryPerson.departmentId,
            Tbl_ContactDirectoryPerson.empCode,
            Tbl_ContactDirectoryPerson.contactNoPersonal,
            Tbl_ContactDirectoryPerson.contactNoOffice,
            Tbl_ContactDirectoryPerson.userName,
            Tbl_ContactDirectoryPerson.designation, Concat('" . $server_name . "',Tbl_ContactDirectoryPerson.imgPath) as imgPath,
            Tbl_ContactDirectoryPerson.emailId,Tbl_ContactDirectoryLocation.*,Tbl_ContactDirectoryDepartment.* from Tbl_ContactDirectoryPerson join Tbl_ContactDirectoryDepartment on Tbl_ContactDirectoryPerson.departmentId = Tbl_ContactDirectoryDepartment.deptId join Tbl_ContactDirectoryLocation on Tbl_ContactDirectoryPerson.locationId = Tbl_ContactDirectoryLocation.locationID
            left join Tbl_EmployeePersonalDetails as edm on edm.employeeCode = Tbl_ContactDirectoryPerson.empCode
            where Tbl_ContactDirectoryPerson.clientId =:id1 order by Tbl_ContactDirectoryPerson.contactId";
            //$server_name = "http://".$_SERVER['SERVER_NAME']."/";
            /* $query = "select Tbl_ContactDirectoryPerson.contactId,Tbl_ContactDirectoryPerson.locationId,Tbl_ContactDirectoryPerson.departmentId,Tbl_ContactDirectoryPerson.userUniqueId,Tbl_ContactDirectoryPerson.contactNoPersonal,Tbl_ContactDirectoryPerson.contactNoOffice,Tbl_ContactDirectoryPerson.designation, Concat('".$server_name."',Tbl_ContactDirectoryPerson.imgPath) as imgPath,Tbl_ContactDirectoryPerson.userName,Tbl_ContactDirectoryPerson.emailId,Tbl_ContactDirectoryLocation.*,Tbl_ContactDirectoryDepartment.* from Tbl_ContactDirectoryPerson join Tbl_ContactDirectoryDepartment on Tbl_ContactDirectoryPerson.departmentId = Tbl_ContactDirectoryDepartment.deptId join Tbl_ContactDirectoryLocation on Tbl_ContactDirectoryPerson.locationId = Tbl_ContactDirectoryLocation.locationID where Tbl_ContactDirectoryPerson.clientId =:id1 order by Tbl_ContactDirectoryPerson.contactId"; */


            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id1', $this->clientids, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
//            echo'<pre>';
//            print_r($rows);die;
            if ($rows) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = array();
                foreach ($rows as $row) {
                    $post["contactId"] = $row["contactId"];
                    $post["locationId"] = $row["locationId"];
                    $post["locationName"] = $row["locationName"];
                    $post["departmentId"] = $row["departmentId"];
                    $post["departmentName"] = $row["departmentName"];
                    $post["userUniqueId"] = $row['empCode'];
                    $post["contactNoPersonal"] = $row['contactNoPersonal'];
                    $post["contactNoOffice"] = $row["contactNoOffice"];
                    $post["designation"] = $row["designation"];
                    $post["imgpath"] = $row["imgPath"];
                    $post["userName"] = $row["userName"];
                    $post["emailId"] = $row["emailId"];

                    array_push($response['posts'], $post);
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Display data";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

    /*     * ************************* Contact person details ************************************* */

    function clientContactPersonDetails($cpid, $clientid) {
        $this->contactid = $cpid;
//        print_r($cpid);die;
        try {
            $query = "select Tbl_ContactDirectoryPerson.*,Tbl_ContactDirectoryDepartment.*,Tbl_ContactDirectoryLocation.* from Tbl_ContactDirectoryDepartment "
                    . "join Tbl_ContactDirectoryPerson on Tbl_ContactDirectoryPerson.departmentId = Tbl_ContactDirectoryDepartment.deptId "
                    . "join Tbl_ContactDirectoryLocation on Tbl_ContactDirectoryPerson.locationId = Tbl_ContactDirectoryLocation.locationID where Tbl_ContactDirectoryPerson.contactId = :cid and Tbl_ContactDirectoryPerson.clientId = :cli";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $this->contactid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rows) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
                $response['posts'] = $rows;
            } else {
                $response['success'] = 0;
                $response['msg'] = "No Display data";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

    /*     * ********************************** delete contact directory ************************ */

    function deleteContactDirectory($cp_id) {
        $this->contact_id = $cp_id;
        try {
            $query1 = "delete from Tbl_ContactDirectoryPerson where contactId = :cid";
            $stmt = $this->db_connect->prepare($query1);
            $stmt->bindParam(':cid', $this->contact_id, PDO::PARAM_STR);
            $stmt->execute();
            $result['success'] = 1;
            $result['message'] = 'Data Successfully Deleted';
            return json_encode($result);
        } catch (PDOException $es) {
            $result['success'] = 0;
            $result['message'] = $es;
            return json_encode($result);
        }
    }

}

// end of class module
?>