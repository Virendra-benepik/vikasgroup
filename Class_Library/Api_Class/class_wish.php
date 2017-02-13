<?php

/*
  Created By :- Monika Gupta
  Created Date :- 7/11/2016
  Description :- Create Function for work and birth notification .
 */

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once('class_connect_db_Communication.php');
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

        $imgpath = base_path . '/images/wishimg/' . $num . '.jpg';
        echo $imgpath;
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
                $response["msg"] = "Wish saved successfully";
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

    function workAndBirthMessage($WishDt, $Username, $WishFlag, $title='') {
        $crdate = @date("Y/m/d");
        $WishDate = date_format($WishDt, "Y/m/d");
        $DateName = date_format($WishDt, 'd F');
        $time = date_format($WishDt, 'h:i a');
        //echo "San : ".$DateName;
        $Message = "";
        $title = (!empty($title))?$title:"";
        
        try {
//            echo $WishDate.' '. $crdate.'<br>';
            IF ($WishDate == $crdate) {
                IF ($WishFlag == "1")
                    $Message = "Today is " . $Username . "'s Birthday.";
                Else IF ($WishFlag == "2") 
                    $Message = $title;
                Else IF ($WishFlag == "6") 
                    $Message = "You're registered for '$title' Event for today at $time.";
                Else
                    $Message = "Today is " . $Username . "'s work anniversary.";
            }
            ElseIF ($WishDate < $crdate) {
                IF ($WishFlag == "1")
                    $Message = $Username . "'s Birthday was on " . $DateName;
                Else IF ($WishFlag == "2")
                    $Message = $title;
                Else IF ($WishFlag == "6")
                    $Message = "You're registered for '$title' Event for $DateName.";
                Else
                    $Message = $Username . "'s work anniversary was on " . $DateName;
            }
            Else {
                IF ($WishFlag == "1")
                    $Message = $Username . "'s Birthday is on " . $DateName;
                IF ($WishFlag == "2")
                    $Message = $title;
                IF ($WishFlag == "6")
                    $Message = "You're registered for '$title' Event is on " . $DateName ." at $time." ;
                    
            }
        } catch (PDOException $e) {
            $Message = "There is error : " . $e;
        }
        return($Message);
    }

}

?>