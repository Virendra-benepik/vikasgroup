<?php
include_once('class_connect_db_Communication.php');

if (!class_exists('FindGroup')) {
    require_once('Api_Class/class_find_groupid.php');
}

class Poll {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 40) {
            $info = getimagesize($source_url);

            if ($info['mime'] == 'image/jpeg')
                $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif')
                $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png')
                $image = imagecreatefrompng($source_url);

            //save it
            imagejpeg($image, $destination_url, $quality);

            //return destination file url
            return $destination_url;
        }
        else {
            move_uploaded_file($source_url, $destination_url);
        }
    }

    public $pollid;
    public $clientid;
    public $pollimg;
    public $pollques;
    public $group;
    public $author;
    public $cdate;
    public $status;

    function pollMaxId() {
        try {
            $max = "select max(autoId) from Tbl_C_PollDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $pollid = "Poll-" . $m_id1;

                return $pollid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function optionMaxId() {
        try {
            $max = "select max(autoId) from Tbl_C_PollOption";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $optionid = "Opt-" . $m_id1;

                return $optionid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function createPoll($pollid, $clientid, $pollimg, $polltext, $group, $by, $ptime, $utime, $post_date) {
        $this->pollid = $pollid;
        $this->clientid = $clientid;
        $this->pollimg = $pollimg;
        $this->pollques = $polltext;
        $this->group = $group;
        $this->author = $by;
        $this->pubtym = $ptime;
        $this->unpubtym = $utime;
        $this->status = "Live";
        $this->pos_dat = $post_date;

        try {
            $query = "insert into Tbl_C_PollDetails(pollId,clientId,pollImage,pollQuestion,groupSelection,createdBy,status,publishingTime,unpublishingTime,createdDate)
            values(:pid,:cid,:pimage,:pques,:grp,:cb,:st,:ptym,:uptym,:cd)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->pollid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pimage', $this->pollimg, PDO::PARAM_STR);
            $stmt->bindParam(':pques', $this->pollques, PDO::PARAM_STR);
            $stmt->bindParam(':grp', $this->group, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->author, PDO::PARAM_STR);
            $stmt->bindParam(':st', $this->status, PDO::PARAM_STR);
            $stmt->bindParam(':ptym', $this->pubtym, PDO::PARAM_STR);
            $stmt->bindParam(':uptym', $this->unpubtym, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->pos_dat, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************FOR INSERTING ANSWER INTO DATABASE OF POLL QUESTION BY EMPLOYEE STARTS**************************** */

    function createAnswer($clientid, $pollid, $optionid, $answerby) {
        $this->idpoll = $pollid;
        $this->idoption = $optionid;
        $this->byanswer = $answerby;

        date_default_timezone_set('Asia/Calcutta');
        $post_date = date('Y-m-d H:i:s');

        try {
            $query = "insert into Tbl_Analytic_PollResult(pollId,optionId,answerBy,ansDate,clientId) values(:pid,:cid,:pimage,:pques,:cli)";
            $stmt = $this->DB->prepare($query);

            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $this->idpoll, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->idoption, PDO::PARAM_STR);
            $stmt->bindParam(':pimage', $this->byanswer, PDO::PARAM_STR);
            $stmt->bindParam(':pques', $post_date, PDO::PARAM_STR);

            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = 'You successfully gave answer';
            } else {
                $response["success"] = 0;
                $response["message"] = 'Not inserted successfully';
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "You have already submited";
        }
        return $response;
    }

    /*     * ******************FOR INSERTING ANSWER INTO DATABASE OF POLL QUESTION BY EMPLOYEE ENDS**************************** */

    /*     * ******************FOR INSERTING ANSWER OPTIONS INTO DATABASE OF POLL QUESTION STARTS**************************** */

    function insertAnswerOptions($clientid, $pollid, $optionid, $ansbytext, $ansbyimg) {
        $this->idclient = $clientid;
        $this->idpoll = $pollid;
        $this->idoption = $optionid;
        $this->answerbytext = $ansbytext;
        $this->answerbyimg = $ansbyimg;

        try {
            $query = "insert into Tbl_C_PollOption(pollId,optionId,clientId,ansInText,ansInImage) values(:pid,:cid,:pimage,:pques,:img)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->idpoll, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $this->idoption, PDO::PARAM_STR);
            $stmt->bindParam(':pimage', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':pques', $this->answerbytext, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->answerbyimg, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************FOR INSERTING ANSWER INTO DATABASE OF POLL QUESTION BY EMPLOYEE ENDS**************************** */

    /*     * ******************FOR GETTING ANSWERS FROM DATABASE BASED ON POLLID STARTS**************************** */

    function getAnswerOptions($pollid, $clientid) {
        $this->idpoll = $pollid;
        $this->idclient = $clientid;

        try {
            $query = "select * from Tbl_C_PollDetails where pollId=:poll and clientId=:cli";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':poll', $this->idpoll, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $response = array();
            $path = "http://admin.benepik.com/employee/virendra/benepik_client/";

            if ($rows) {
                $poll = $rows[0]["pollId"];
                $client = $rows[0]["clientId"];

                $query1 = "select * from Tbl_C_PollOption where pollId=:poll and clientId=:cli";
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':poll', $poll, PDO::PARAM_STR);
                $stmt1->bindParam(':cli', $client, PDO::PARAM_STR);
                $stmt1->execute();
                $row = $stmt1->fetchAll();
                if ($row) {
                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["poll_question"] = $rows[0]["pollQuestion"];
                    $response["poll_image"] = $path . $rows[0]["pollImage"];
                    $response["questions"] = array();
                    foreach ($row as $r) {
                        $post["optionId"] = $r["optionId"];
                        $post["pollId"] = $r["pollId"];
                        $post["ansInText"] = $r["ansInText"];
                        $post["ansInImage"] = $path . $r["ansInImage"];

                        array_push($response["questions"], $post);
                    }

                    return json_encode($response);
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "client id or poll id doesn't match";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************FOR GETTING ANSWERS FROM DATABASE BASED ON POLLID ENDS**************************** */

    /*     * ******************FOR GETTING POLL DETAILS FROM DATABASE BASED ON CLIENTID STARTS**************************** */

    public $eid;
    public $utype;

    function pollDetails($clientid, $user_uniqueid, $user_type) {
        $this->idclient = $clientid;
        $this->eid = $user_uniqueid;
        $this->utype = $user_type;

        if ($this->utype == "SubAdmin") {
            try {
                $query = "select * from Tbl_C_PollDetails where clientId=:cli and createdBy =:cb order by autoId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':cb', $this->eid, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();

                $response = array();

                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        } 
        else {
            try {
                $query = "select * from Tbl_C_PollDetails where clientId=:cli order by autoId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();

                $response = array();

                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        }
    }

    /*     * ******************FOR GETTING POLL DETAILS FROM DATABASE BASED ON POLLID AND CLIENTID ENDS**************************** */

    /*     * ******************ANDROID FOR GETTING POLL DETAILS FROM DATABASE BASED ON CLIENTID STARTS**************************** */

    function pollDetailsFORandroid($clientid, $val) {
        $this->idclient = $clientid;
        $this->value = $val;

        try {
            $query = "select * from Tbl_C_PollDetails where clientId=:cli order by autoId desc limit " . $this->value . ",5";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {

                $query1 = "select count(pollId) as totals from Tbl_C_PollDetails where clientId=:cli";
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt1->execute();
                $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["totals"] = $rows1[0]["totals"];
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "data doesn't fetch";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*****************FOR GETTING POLL DETAILS FROM DATABASE BASED ON POLLID AND CLIENTID ENDS**************************/

    function getAllPollsDetails($clientid, $empid, $val, $module = '') {
        $this->idclient = $clientid;
        $this->employeeId = $empid;
        $this->value = $val;

        $path = SITE_URL;
//        $path1 = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/";

        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $this->employeeId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//            print_r($rows);die;
            if (count($rows) > 0) 
			{
                $group_object = new FindGroup();    // this is object to find group id of given unique id 
                $getgroup = $group_object->groupBaseofUid($clientid, $empid);
                $value = json_decode($getgroup, true);
//                print_r($value);die;
                /************************************************************************************************ */

                $count_group = count($value['groups']);
                //echo "total group of empid =: ".$count_group."<br/>";
                if ($count_group <= 0) 
				{
                    $response["success"] = 0;
                    $response["message"] = "Sorry You are Not in Any Group";
                } 
				else 
				{
                    $in = implode("', '", array_unique($value['groups']));

                /****************************************************************************************************/
			  	 $pollquery1 = "select count(distinct(pollId)) as total from Tbl_Analytic_PollSentToGroup where groupId IN('".$in."') and clientId =:cid and status = 1 order by autoId desc";
										
                    $nstmt1 = $this->DB->prepare($pollquery1);
                    $nstmt1->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
                    $nstmt1->execute();
                    $welrows11 = $nstmt1->fetch(PDO::FETCH_ASSOC);
			       $totalpoll = $welrows11['total'];
				   //echo "total poll".$totalpoll;
			/**********************************************************************************/  
				  $eventquery = "select distinct(pollId) from Tbl_Analytic_PollSentToGroup where groupId IN('".$in."') and clientId =:cid and status = 1 order by autoId desc limit $val, 5";										
                    $nstmt = $this->DB->prepare($eventquery);
                    $nstmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
                    $nstmt->execute();
                    $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
			        $postarray = array();
						foreach($welrows as $postid)
						{
						array_push($postarray,$postid['pollId']);
						}						
					/*	echo "<pre>";
						print_r($postarray);
						echo "</pre>";
						*/
						 $polldetails = array_values(array_unique($postarray));
						$count = count($polldetails);
						//echo "count poll-".$count;
                      //    print_r($polldetails);      						
	/********************************************************************/
	/*			
                    if ($module == 1) 
					{
                        $query = "select * from Tbl_C_PollDetails where clientId=:cli limit 1";
                    } else 
					{
                       // $query = "select * from Tbl_C_PollDetails where clientId=:cli limit " . $this->value . ",5";
					 $query = "select count(distinct(pollId)) as total from Tbl_Analytic_StorySentToGroup where groupId IN('".$in."') and clientId =:cid and status = 1 order by autoId desc";
                    }
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $query2 = "select count(pollId) as total_polls from Tbl_C_PollDetails";
                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->execute();
                    $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

*/
                    $response = array();

                    if ($totalpoll > 0) 
					{
                        $response["success"] = 1;
                        $response["message"] = "Successfully data fetched";
                        $response["total_polls"] = $totalpoll;
                        $response["posts"] = array();

                        for($k=0;$k<$count;$k++) 
						{	
					   //  echo "i am here";
					      // print_r('polldetails');
                            $pollId = $polldetails[$k];
							//echo "pollid-".$pollId;
							//echo "k data-".$k;
              /**********************************************/
			       
							$pollquery = "select * ,DATE_FORMAT(publishingTime,'%d %b %Y %h:%i %p') as publishingTime,DATE_FORMAT(unpublishingTime,'%d %b %Y %h:%i %p') as unpublishingTime,DATE_FORMAT(createdDate,'%d %b %Y') as createdDate  from Tbl_C_PollDetails where clientId=:cli and pollId=:pollid";
							$stmt2 = $this->DB->prepare($pollquery);
							$stmt2->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                            $stmt2->bindParam(':pollid', $pollId, PDO::PARAM_STR);
                            $stmt2->execute();
                            $polldata = $stmt2->fetchAll(PDO::FETCH_ASSOC);
							//echo "<pre>";
							//print_r($polldata);
		    	/*************************************************************/				
                            $query = "select * from Tbl_C_PollOption where pollId=:cli";
                            $stmt = $this->DB->prepare($query);
                            $stmt->bindParam(':cli', $pollId, PDO::PARAM_STR);
                            $stmt->execute();
                            $rowss = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $query1 = "select count(pollId) as totals from Tbl_Analytic_PollResult where pollId=:cli";
                            $stmt1 = $this->DB->prepare($query1);
                            $stmt1->bindParam(':cli', $pollId, PDO::PARAM_STR);
                            $stmt1->execute();
                            $ssrow = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                            $post["Questions"] = array();
                            foreach ($rowss as $srow) 
							{
                                $new["ansInText"] = $srow["ansInText"];

                                $image = $srow["ansInImage"];
                                if (!empty($image)) {
                                    $output = $path . $image;
                                } else {
                                    $output = "";
                                }
                                $new["ansInImage"] = $output;
                                $new["optionId"] = $srow["optionId"];

                                $optionId = $new["optionId"];

                                $query2 = "select count(answerBy) as optionTotals from Tbl_Analytic_PollResult where optionId=:opt and pollId=:pol";
                                $stmt2 = $this->DB->prepare($query2);
                                $stmt2->bindParam(':opt', $optionId, PDO::PARAM_STR);
                                $stmt2->bindParam(':pol', $pollId, PDO::PARAM_STR);
                                $stmt2->execute();
                                $opt = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                $new["optionTotals"] = $opt[0]["optionTotals"];
                                array_push($post["Questions"], $new);
                            }
                            $post["totals"] = $ssrow[0]["totals"];
							$post["pollid"] = $polldata[0]["pollId"];
                            $post["pollQuestion"] = $polldata[0]["pollQuestion"];
                            $post["groupSelection"] = $polldata[0]["groupSelection"];
                            $post["createdBy"] = $polldata[0]["createdBy"];
						//	$post["pollid"] = $polldata[$k]["pollId"];
                            $mail = $post["createdBy"];

                            $query2 = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:mal";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':mal', $mail, PDO::PARAM_STR);
                            $stmt2->execute();
                            $imge = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            $post["UserName"] = $imge[0]["firstName"];
                            $post["UserImage"] = $path . $imge[0]["userImage"];
                            $post["publishingTime"] = $polldata[0]["publishingTime"];
                            $post["unpublishingTime"] = $polldata[0]["unpublishingTime"];
							
                            $post["status"] = $polldata[0]["status"];
/**********************************************/
 $query3 = "select count(answerBy) as YourAns from Tbl_Analytic_PollResult where clientId=:cli and pollId=:pol and answerBy=:ans";
             $stmt3 = $this->DB->prepare($query3);
             $stmt3->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt3->bindParam(':pol',$pollId, PDO::PARAM_STR);
			 $stmt3->bindParam(':ans',$empid, PDO::PARAM_STR);
             $stmt3->execute();
             $ans = $stmt3->fetch(PDO::FETCH_ASSOC);
$post["YourAnswer"]=$ans["YourAns"];

/**************************************************************/
														
                            array_push($response["posts"], $post);
                        }
                    } 
					else
					{
                        $response["success"] = 0;
                        $response["message"] = "No More Poll Available";
                    }
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "You are not authorized user please check youe employee code";
            }
        } catch (PDOException $e) {
            echo $e;
        }
        echo json_encode($response);
    }

    /*     * ******************ANDROID FOR GETTING POLL DETAILS FROM DATABASE BASED ON CLIENTID STARTS**************************** */

    function pollDetailsFORandroid2($clientid, $val) {
        $this->idclient = $clientid;
        $this->value = $val;

        $path = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/";
        $path1 = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/";

        try {
            $query = "select * from Tbl_C_PollDetails where clientId=:cli limit " . $this->value . ",5";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query2 = "select count(pollId) as total_polls from Tbl_C_PollDetails";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->execute();
            $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


            $response = array();

            if ($rows) {
                $response["success"] = 1;
                $response["message"] = "Successfully data fetched";
                $response["total_polls"] = $rows2[0]["total_polls"];
                $response["posts"] = array();

                foreach ($rows as $row) {
                    $post["pollId"] = $row["pollId"];
                    $pollId = $post["pollId"];

                    $query = "select * from Tbl_C_PollOption where pollId=:cli";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $pollId, PDO::PARAM_STR);
                    $stmt->execute();
                    $rowss = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $query1 = "select count(pollId) as totals from Tbl_Analytic_PollResult where pollId=:cli";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':cli', $pollId, PDO::PARAM_STR);
                    $stmt1->execute();
                    $ssrow = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                    $post["Questions"] = array();
                    foreach ($rowss as $srow) {
                        $new["ansInText"] = $srow["ansInText"];

                        $image = $srow["ansInImage"];
                        if (!empty($image)) {
                            $output = $path . $image;
                        } else {
                            $output = "";
                        }
                        $new["ansInImage"] = $output;
                        $new["optionId"] = $srow["optionId"];

                        $optionId = $new["optionId"];

                        $query2 = "select count(answerBy) as optionTotals from Tbl_Analytic_PollResult where optionId=:opt and pollId=:pol";
                        $stmt2 = $this->DB->prepare($query2);
                        $stmt2->bindParam(':opt', $optionId, PDO::PARAM_STR);
                        $stmt2->bindParam(':pol', $pollId, PDO::PARAM_STR);
                        $stmt2->execute();
                        $opt = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        $new["optionTotals"] = $opt[0]["optionTotals"];
                        array_push($post["Questions"], $new);
                    }
                    $post["totals"] = $ssrow[0]["totals"];
                    $post["pollQuestion"] = $row["pollQuestion"];
                    $post["groupSelection"] = $row["groupSelection"];
                    $post["createdBy"] = $row["createdBy"];
                    $mail = $post["createdBy"];

                    $query2 = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:mal";
                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':mal', $mail, PDO::PARAM_STR);
                    $stmt2->execute();
                    $imge = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    $post["UserName"] = $imge[0]["firstName"];
                    $post["UserImage"] = $path1 . $imge[0]["userImage"];
                    $post["publishingTime"] = $row["publishingTime"];
                    $post["status"] = $row["status"];

                    array_push($response["posts"], $post);
                }

                echo json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "data doesn't fetch";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************FOR GETTING POLL DETAILS FROM DATABASE BASED ON POLLID AND CLIENTID ENDS**************************** */

    function updatePollStatus($pid, $sta) {
        $this->pollid = $pid;
        $this->status = $sta;
        if ($this->status == 'Live') {
            $pollstatus = 1;
        } else {
            $pollstatus = 0;
        }

        try {
            $wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :comm1 ";
            $stmtw = $this->DB->prepare($wquery);
            $stmtw->bindParam(':comm1', $this->pollid, PDO::PARAM_STR);
            $stmtw->bindParam(':sta1', $pollstatus, PDO::PARAM_STR);
            $stmtw->execute();


            $query = "update Tbl_C_PollDetails set status=:sta where pollId =:pid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $this->pollid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response[success] = 1;
                $response[message] = "Successfully Feedback status changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>