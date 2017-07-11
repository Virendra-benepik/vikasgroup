<?php

/*
  Created By :- Monika Gupta
  Created Date :- 7/11/2016
  Description :- Create Function for work and birth notification .
 */

   error_reporting(E_ALL);
   ini_set('display_errors', 1);
if (!class_exists("Connection_Communication")) {
    include_once('class_connect_db_Communication.php');
}
/* * ----- -----------------------   $db_connect     is object of connection page ---------------------------------* */

class wish {

    public $db_connect;

    public function __construct() {
        $db = new Connection_Communication();
        $this->db_connect = $db->getConnection_Communication();
    }

    /*     * ****************************** generate three digit random number **************************** */

    function randomNumber($length) {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    /*     * ******************************end generate three digit random number **************************** */
    /*     * ******************************** convert into image ******************************************** */

    public $img;

    function convertIntoImage($encodedimage, $num) {

        $img = imagecreatefromstring(base64_decode($encodedimage));

        $imgpath = dirname(BASE_PATH). '/images/wishimg/' . $num . '.jpg';
       // echo $imgpath;
        imagejpeg($img, $imgpath);
        $imgpath1 = $num . '.jpg';
        return $imgpath1;
    }

    /*     * ********************************end convert into image ******************************************** */


    /*     * ************************* insert wish into database  ************************************* */

    function saveWish($wishcomment, $wishimage, $clientid, $employeeid, $wishflag, $createdby) {
        $status = 1;

        /*         * *************** Insert wish into Database start ************************************** */
        try {
            $query = "call SP_AddWishComment(:cid,:empid,:wishcomment,:wishimage,:wishflag,:createdby,:status)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':wishcomment', $wishcomment, PDO::PARAM_STR);
            $stmt->bindParam(':wishimage', $wishimage, PDO::PARAM_STR);
            $stmt->bindParam(':wishflag', $wishflag, PDO::PARAM_INT);
            $stmt->bindParam(':createdby', $createdby, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                $response["success"] = 1;
                $response["msg"] = "Wish Send Successfully";
            }
        } catch (PDOException $e) {
            echo $e;
            $response["success"] = 0;
            $response["msg"] = $e;
        }
        return(json_encode($response));
    }

    /*     * ************************************* end insert wish into database ************************* */

    /*     * **************************** view notification list start ********************************* */

    function workAndBirthNotiListDetails($clientid, $empid, $startlimit) {
        try {
            $query = "call SP_getWorkAndBirthNotiListDetails(:cid,:empid,:startlimit)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $empid, PDO::PARAM_STR);
            $stmt->bindParam(':startlimit', $startlimit, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($rows) {
                    $response["success"] = 1;
                    $response["Data"] = $rows;
                    $a = json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["Data"] = 0;
                    $response["message"] = "No notification Found";
                    $a = json_encode($response);
                }
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $e->getMessage();
            $a = json_encode($response);
        }
        return($a);
    }

    /*     * ****************************** end view notification list start ********************************* */

    /*     * ******************************** work and birth notification details **************************** */

    function workAndBirthNotificationDetails($clientid, $empid, $startlimit) {
        $url = site_url;       // for get full path of image 

        try {
            $query = "call SP_getWorkAndBirthNotiDetails(:cid,:empid,:startlimit,:url)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $empid, PDO::PARAM_STR);
            $stmt->bindParam(':startlimit', $startlimit, PDO::PARAM_INT);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $a = "";
                if ($rows) {
                    $response["success"] = 1;
                    $response["Data"] = $rows;
                    $a = json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No notification Found";
                    $a = json_encode($response);
                }
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $e->getMessage();
            $a = json_encode($response);
        }
        return($a);
    }

    /*     * ******************************* end work and birth notification details ************************* */

    function workAndBirthMessage($WishDt, $Username, $WishFlag, $eventId, $title = '') {
        $crdate = @date("m/d");
        //echo $WishDt;
        $number = date('Y')-date_format($WishDt, 'Y');
       // $year1 =  date_format($year, 'jS');
      //  echo $year."<br>";
      
       /*******************************************/
    /*** check for 11, 12, 13 ***/
        $ss = 0;
    if ($number % 100 > 10 && $number %100 < 14)
    {
        $os = 'th';
    }
    /*** check if number is zero ***/
    elseif($number == 0)
    {
        $os = '';
    }
    else
    {
        /*** get the last digit ***/
        $last = substr($number, -1, 1);

        switch($last)
        {
            case "1":
            $os = 'st';
            break;

            case "2":
            $os = 'nd';
            break;

            case "3":
            $os = 'rd';
            break;

            default:
            $os = 'th';
        }
    }

    /*** add super script ***/
    $os = $ss==0 ? $os : '<sup>'.$os.'</sup>';

    /*** return ***/
    if($number != 0)
     $year1 =  $number.$os;
    else
        $year1 = "";
   
   // echo "this is year difference-".$year1."<br/>";
       /***********************************************/
        $WishDate = substr(date_format($WishDt, "Y/m/d"), 5, 5);
        $DateName = date_format($WishDt, 'd F');
        $time = date_format($WishDt, 'h:i a');
      
        $Message = "";
        $title = (!empty($title)) ? $title : "";

        try {
			
			/*************************** event check *****************************/
			
			$query = "select * from Tbl_C_EventDetails where eventId = :eventId And flagCheck = :WishFlag";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':WishFlag', $WishFlag, PDO::PARAM_STR);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
               $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //print_r($rows);
				//echo $status = $rows['status'];
				//echo count($rows);
				for($i=0; $i<count($rows); $i++)
				{
					 $status = $rows[$i]['status'];
					// $eventTime = $rows[$i]['eventTime'];
					
				}
			}
			
			/************************ end event check ************************************/
			
            //   echo $WishDate.' '. $crdate.'<br>';
            IF ($WishDate == $crdate) {
                //  echo "data is equal";
                IF ($WishFlag == "1")
                    $Message = "Today is " . $Username . "'s Birthday.";
                Else IF ($WishFlag == "2")
                    $Message = "Today is " . $Username . "'s ".$year1." work anniversary.";
                Else IF ($WishFlag == "3")
                    $Message = $title;
                Else IF ($WishFlag == "6")
				{
					if($status == 'Active')
					{	
                    $Message = "You're registered for '$title' Event for today at $time.";
					}
					else
					{
					 $Message = "Event has been cancelled.";
					}
                }
				Else
                    $Message = "Today is " . $Username . "'s work anniversary.";
            }
            ElseIF ($WishDate < $crdate) {
                //  echo "date is less";
                IF ($WishFlag == "1")
                    $Message = $Username . "'s Birthday was on " . $DateName;
                Else IF ($WishFlag == "2")
                    $Message = $Username . "'s ".$year1." Work anniversary was on " . $DateName;
                Else IF ($WishFlag == "3")
                    $Message = $title;
                Else IF ($WishFlag == "6")
				{
					if($status == 'Active')
					{
                    $Message = "You're registered for '$title' Event for $DateName.";
					}
					else
					{
					 $Message = "Event has been cancelled.";
					}
				}
                Else
                    $Message = $Username . "'s work anniversary was on " . $DateName;
            }
            Else {
                // echo "other";
                IF ($WishFlag == "1")
                    $Message = $Username . "'s Birthday is on " . $DateName;
                IF ($WishFlag == "2")
                    $Message = $Username . "'s ".$year1." work anniversary is on " . $DateName;
                IF ($WishFlag == "3")
                    $Message = $title;
                IF ($WishFlag == "6")
				{
					if($status == 'Active')
					{
                    $Message = "You're registered for '$title' Event is on " . $DateName . " at $time.";
					}
					else
					{
					 $Message = "Event has been cancelled.";
					}
				}
            }
        } catch (PDOException $e) {
            $Message = "There is error : " . $e;    
        }
        return($Message);
    }

    public function getTodaysBirthdays($clientid, $reminder = "") {
        //  $url = dirname(SITE_URL) . "/";       // for get full path of image 
        $url = SITE_URL;       // for get full path of image 
        // echo $url;   
        date_default_timezone_set('Asia/Kolkata');
        $currentdate = date('d-m');
        //echo $currentdate;
        try {
            if ($reminder == 1) {
                $query = "select epd.userDOB,DATE_FORMAT(epd.userDOB, '%d-%m') as dob ,epd.userid,epd.employeeId, CONCAT(edm.firstName,' ',edm.lastName) as username, edm.emailId, edm.department, edm.designation,edm.location,edm.grade from Tbl_EmployeePersonalDetails as epd JOIN `Tbl_EmployeeDetails_Master` as edm ON epd.employeeId = edm.employeeId where edm.clientId=:cid and DATE_FORMAT(epd.userDOB, '%d-%m') = :cdate";
            } else {
                $query = "select epd.userDOB,DATE_FORMAT(epd.userDOB, '%d-%m') as dob ,epd.userid,epd.employeeId,IF(epd.linkedIn='1', epd.userImage, IF(epd.userImage IS NULL or epd.userImage='','',CONCAT('" . $url . "',epd.userImage))) AS userImage, gcm_detail.registrationToken, gcm_detail.deviceName,CONCAT(edm.firstName,' ',edm.lastName) as username, edm.emailId, edm.department, edm.designation,edm.location,edm.grade from Tbl_EmployeePersonalDetails as epd JOIN `Tbl_EmployeeDetails_Master` as edm ON epd.employeeId = edm.employeeId join Tbl_EmployeeGCMDetails as gcm_detail on gcm_detail.userUniqueId=edm.employeeId where edm.clientId=:cid and DATE_FORMAT(epd.userDOB, '%d-%m') = :cdate";
            }
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':cdate', $currentdate, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $a = "";
                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "Data Found";
                    $response["Data"] = $rows;
                    $a = $response;
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No Data Found";
                    $a = $response;
                }
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $e->getMessage();
            $a = $response;
        }
        return($a);
    }

    public function getTodaysBatchBirthdays($employeeId) {
        //  $url = dirname(SITE_URL) . "/";       // for get full path of image 
        $url = site_url;
        // echo $url;
        date_default_timezone_set('Asia/Kolkata');
        $currentdate = date('d-m');
        try {
            $query = "select epd.userDOB,epd.userid,epd.employeeId,IF(epd.linkedIn='1', epd.userImage, IF(epd.userImage IS NULL or epd.userImage='','',CONCAT('" . $url . "',epd.userImage))) AS userImage, gcm_detail.registrationToken, gcm_detail.deviceName,CONCAT(edm.firstName,' ',edm.lastName) as username, edm.emailId, edm.department, edm.designation,edm.location from Tbl_EmployeePersonalDetails as epd JOIN `Tbl_EmployeeDetails_Master` as edm ON epd.employeeId = edm.employeeId join Tbl_EmployeeGCMDetails as gcm_detail on gcm_detail.userUniqueId=edm.employeeId where edm.employeeId !=:employeeId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_STR);
            //    $stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "Data Found";
                    $response["Data"] = $rows;
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No Data Found";
                    $a = $response;
                }
            }
        } catch (Exception $ex) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $ex;
        }
        return $response;
    }

    function maxId() {
        try {
            $max = "select max(autoId) from Tbl_WishComment";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $id = $m_id1;

                return $id;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }
/************************************************** wish detail *************************************************/

 function wishDetail($clientid, $wishid, $eid){
        $url = site_url;       // for get full path of image 

        try {
            $query = "SELECT twc.autoId,twc.createdDate,twc.wishComment,IF(twc.wishImage IS NULL or twc.wishImage='','',CONCAT('".$url."',twc.wishImage)) as wishImage, upd.employeeId,IF(upd.linkedIn='1', upd.userImage, IF(upd.userImage IS NULL or upd.userImage='','',CONCAT('".$url."',upd.userImage))) as userImage,CONCAT(ud.firstName,' ',ud.lastName) as username,ud.designation,ud.location,twc.wishFlag FROM `Tbl_WishComment` as twc JOIN `Tbl_EmployeeDetails_Master` as ud ON twc.createdby = ud.employeeId JOIN `Tbl_EmployeePersonalDetails` as upd ON ud.employeeId = upd.employeeId JOIN Tbl_ClientDetails_Master as bclient ON twc.clientId = bclient.client_id WHERE twc.employeeId = :eid AND twc.clientId = :cid AND twc.autoId = :wishid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':wishid', $wishid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $eid, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                //echo "<pre>";
                //print_r($rows);
                $a = "";
                if ($rows) {
                    $response["success"] = 1;
					$response["message"] = "Data Found";
                    $response["Data"] = $rows;
                    $a = $response;
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No Data Found";
                    $a = $response;
                }
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Database Error!" . $e->getMessage();
            $a = $response;
        }
        return($a);
    }

/*********************************************** end wish detail ************************************************/
}

?>
