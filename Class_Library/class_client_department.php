<?php

include_once('class_connect_db_Communication.php');

class ContactDepartment {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    /*     * ************************* *******************
      | Create Module and insert data into database  ************************************************ */

    public $clientid;
    public $location;
    public $department;

    function createDepartment($cid, $loc, $dept) {
        $this->clientid = $cid;
        $this->location = $loc;
        $this->department = $dept;

        try {
            $max = "select max(autoId) from Tbl_ContactDirectoryDepartment";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $l_id = $tr[0];
                $l_id1 = $l_id + 1;
                $did = "Dept-" . $l_id1;
                //echo $mid;
            }
        } catch (PDOException $e) {
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }


        try {
            $query = "insert into Tbl_ContactDirectoryDepartment(deptId,clientId,locationId,departmentName)values(:id,:cid,:lid,:dept)";
            $stmt = $this->db_connect->prepare($query);

            $stmt->bindParam(':id', $did, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':lid', $this->location, PDO::PARAM_STR);
            $stmt->bindParam(':dept', $this->department, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response['success'] = 1;
                $response['msg'] = "New Department Successfully Added";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            // echo "Error occured while trying to insert into the DB:". $e->getMessage();
        }  //---------------------------------------------end of catch blok
        return json_encode($response);
    }

//------------------------end of create module function

    public $clientids;

    /*     * ******************* select deapartment on the base of location from database  *************************** */

    function viewDepartment($cid, $locid) {
        $this->clientid = $cid;
        $this->locationid = $locid;

        try {
            $query = "select * from Tbl_ContactDirectoryDepartment where clientId =:id1 and locationId=:loc";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id1', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':loc', $this->locationid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if ($rows) {
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
                $response['msg'] = "Client id or location id is incorrect";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            $response['success'] = 0;
            $response['msg'] = $e;
            echo $e;
        }
        return (json_encode($response));
    }

    /*     * ************************* View main module data from database  ************************************* */

    function ViewMainModule() {
        try {
            $k = "select * from  B_Main_Module";
            $stmt = $this->db_connect->prepare($k);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e;
            $rows = $e;
            return "not done";
            trigger_error('Error occured while trying to fetch data data from the DB:' . $e->getMessage(), E_USER_ERROR);
        }

        return $rows;
    }

    /*     * *************************Update Department data from database  ************************************* */

    function updateDepartment($cid, $lid, $did, $dname) {
        $this->clientid = $cid;
        $this->locid = $lid;
        $this->deptid = $did;
        $this->departmentname = $dname;

        try {
            $query = "update Tbl_ContactDirectoryDepartment set departmentName=:dn where clientId =:cli and deptid=:dpi and locationId=:loid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':dpi', $this->deptid, PDO::PARAM_STR);
            $stmt->bindParam(':loid', $this->locid, PDO::PARAM_STR);
            $stmt->bindParam(':dn', $this->departmentname, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response['success'] = 1;
                $response['msg'] = "Successfully Display data";
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

    /*     * *************************Update Department data from database  ************************************* */

    /*     * ************************* Delete department from database  ************************************* */

    function deleteDepartment($locid) {
        $this->department_id = $locid;

        try {
            $query = "delete from Tbl_ContactDirectoryPerson where departmentId =:id1 ";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':id1', $this->department_id, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $query1 = "delete from Tbl_ContactDirectoryDepartment where deptId =:id1 ";
                $stmt1 = $this->db_connect->prepare($query1);
                $stmt1->bindParam(':id1', $this->department_id, PDO::PARAM_STR);

                if ($stmt1->execute()) {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully Department delete";
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

    /*     * ************************* delete department data database  ************************************* */

    /*     * ************************* Create Sub Module and insert data into database  ************************************* */

    public $mname_id;
    public $sub_module_name;

    //public $linkpage;
    function createSubModule($mmid, $submodname, $linkpage) {
        $this->mname_id = $mmid;
        $this->sub_module_name = $submodname;
        $this->linkpage = $linkpage;

        try {
            $max = "select max(auto_id) from B_Sub_Module";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $sm_id = $tr[0];
                $sm_id1 = $sm_id + 1;
                $smid = "SM-" . $sm_id1;
                echo $smid;
            }
        } catch (PDOException $e) {
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }


        try {
            $query = "insert into B_Sub_Module(main_module_id,sub_module_id,sub_module_name,link_page)values(:mid,:smid,:subname,:linkpage)";
            $stmt = $this->db_connect->prepare($query);

            $stmt->bindParam(':mid', $this->mname_id, PDO::PARAM_STR);
            $stmt->bindParam(':smid', $smid, PDO::PARAM_STR);
            $stmt->bindParam(':subname', $this->sub_module_name, PDO::PARAM_STR);
            $stmt->bindParam(':linkpage', $this->linkpage, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return "1 row inserted";
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {

            //  trigger_error("Error occured while trying to insert into the DB:" . $e->getMessage(), E_USER_ERROR);
            echo "Error occured while trying to insert into the DB:" . $e->getMessage();
            // return "not done";
        }  //---------------------------------------------end of catch blok
        return "not done";
    }

//------------------------end of create module function
}

// end of class module
?>