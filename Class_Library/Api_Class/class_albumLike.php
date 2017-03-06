<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class Like {

    public $DB;
    public $db_connect;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function create_Like($clientid, $userid, $albumid, $imageid, $device) {

        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");
        $status = 1;

        try {
            $query = "insert into Tbl_Analytic_AlbumLike(clientId,userId,albumId,imageId,createdDate,status,deviceName)
             values(:cli,:userid,:albumid,:imgid,:cd,:sta,:dev)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
            $stmt->bindParam(':imgid', $imageid, PDO::PARAM_INT);
            $stmt->bindParam(':cd', $cd, PDO::PARAM_INT);
            $stmt->bindParam(':sta', $status, PDO::PARAM_INT);
            $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            if ($stmt->execute()) {

                $query2 = "select count(imageId) as total_likes from Tbl_Analytic_AlbumLike where albumId =:albumid AND imageId = :imgid AND status = :sta AND clientId=:cli";
                $stmt2 = $this->DB->prepare($query2);
                $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt2->bindParam(':albumid', $albumid, PDO::PARAM_INT);
                $stmt2->bindParam(':imgid', $imageid, PDO::PARAM_INT);
                $stmt2->bindParam(':sta', $status, PDO::PARAM_INT);
                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                $response["success"] = 1;
                $response["message"] = "You have liked this Image successfully";
                $response['total_likes'] = $row2['total_likes'];
                $response["post"] = self::totallikes($clientid, $albumid, $imageid);
                return $response;
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "You already liked this Image";
            return $response;
        }
    }

    /*     * **************************************************************************************** */

    function totallikes($clientid, $albumid, $imageid) {
        $status = 1;
        try {
            $query = "select count(userId) as total_likes from Tbl_Analytic_AlbumLike where clientId=:cli and albumId=:albumid AND imageId = :imgid AND status = :status";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
            $stmt->bindParam(':imgid', $imageid, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                $response["success"] = 1;
                $response["message"] = "like here";
                $response["total_likes"] = $row["total_likes"];
                $response["albumid"] = $albumid;
                $response["imageid"] = $imageid;
            } else {
                $response["success"] = 0;
                $response["message"] = "No like here";
            }
            return $response;
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "No like";
            return $response;
        }
    }

    /*     * ********************************************************************************************************** */

    /*     * ******************************* get total like and comment ************************************************* */

    function getTotalLikeANDcomment($clientid, $albumid, $imageid,$imgpath='') {
        $status = 1;

        $path = ($imgpath  == '')?dirname(SITE_URL)."/":site_url;
        try {
            $query = "select *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as likeDate from Tbl_Analytic_AlbumLike where albumId =:albumid AND imageId = :imgid and clientId=:cli AND status = :status";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
            $stmt->bindParam(':imgid', $imageid, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $response = array();

            if ($rows) {

                $response["Success"] = 1;
                $response["Message"] = "";
                $response["Posts"] = array();

                foreach ($rows as $row) {
                    $post["albumId"] = $row["albumId"];
                    $post["imageId"] = $row["imageId"];
                    $post["uuid"] = $row["userId"];
                    $employeeid = $row["userId"];
                     
                 
                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.*, IF(Tbl_EmployeePersonalDetails.userImage IS NULL OR Tbl_EmployeePersonalDetails.userImage='', '', if(Tbl_EmployeePersonalDetails.linkedIn = '1',Tbl_EmployeePersonalDetails.userImage, CONCAT('$path',Tbl_EmployeePersonalDetails.userImage))) as userImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                  
                    $post["name"] = $rows["firstName"];
//                    $post["userImage"] = !empty($rows["userImage"]) ? $path . $rows["userImage"] : "";
                    $post["userImage"] = $rows["userImage"];
                    $post["likeDate"] = $row["likeDate"];
                    $post["clientId"] = $row["clientId"];
                    array_push($response["Posts"], $post);
                 
                }
            } else {
                $response["Success"] = 0;
                $response["Message"] = "There is no display like";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************************** end total like and comment ************************************************** */
}

?>