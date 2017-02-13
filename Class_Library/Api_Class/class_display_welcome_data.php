<?php
include_once('class_connect_db_Communication.php');
include_once('class_find_groupid.php');  // this class for get group id on the base of unique id

class PostDisplayWelcome {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function PostDisplay($clientid, $uid, $start) {

        $this->idclient = $clientid;
        $this->value = $val;

        $querycheck = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
        $stmt = $this->DB->prepare($querycheck);
        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
        $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        if (count($rows) > 0) {

            $group_object = new findGroup();    // this is object to find group id of given unique id 
            $getgroup = $group_object->groupBaseofUid($clientid, $uid);
            $value = json_decode($getgroup, true);

            //   $in = implode("', '", array_unique($value['groups']));

        /************************************************************************************************* */

            $count_group = count($value['groups']);

            if ($count_group <= 0) {

                $result["success"] = 0;
                $result["message"] = "Sorry You are Not in Any Group";
                return $result;
            } 
			else 
			{
                $in = implode("', '", array_unique($value['groups']));
				//echo "group array : ".$in."<br/>";
                /*                 * ************************************************************************************************* */
                try {
                    $welcomequery = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_WelcomeDetails where clientId =:cid and status = 1 order by autoId desc";

                    $welstmt = $this->DB->prepare($welcomequery);
                    $welstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                    $welstmt->execute();
                    $welrows = $welstmt->fetchAll(PDO::FETCH_ASSOC);
                   // print_r($welrows);
                    $welcomearray = array();
                    $welcount = count($welrows);
//echo "total post ".$welcount."<br/>";
                    for ($w = 0; $w < $welcount; $w++) 
					{
                  //$welcomearray1["PostType"] = array();
                        $welcomearray1["PostData"] = array();
                        $weltype = $welrows[$w]['type'];
                        $welid = $welrows[$w]['id'];
                        $site_url = site_url;
                        switch ($weltype) 
		         {
                             case "Notice":
                                $noticequery = "select * from Tbl_Analytic_NoticeSentToGroup where groupId IN('" . $in . "') and noticeId =:id and clientId =:cid";
                                $nstmt = $this->DB->prepare($noticequery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $noticerows = $nstmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($noticerows) > 0) {
                                    $noticequery1 = "select *, Concat('Notice','') as type, Concat('7','') as flagCheck, Concat('$site_url','notice/notice_img/notice-min.jpg') as noticeImage,
             Concat('$site_url',fileName) as fileName, DATE_FORMAT(createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(publishingTime,'%d %b %Y') as publishingTime, DATE_FORMAT(unpublishingTime,'%d %b %Y') as unpublishingTime from Tbl_C_NoticeDetails where noticeId =:id and clientId =:cid";
                                    $nstmt = $this->DB->prepare($noticequery1);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $noticedata = $nstmt->fetch(PDO::FETCH_ASSOC);
                                    $userid = $noticedata['createdBy'];
                                    
                                    $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('".$site_url."',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                    $stmt12 = $this->DB->prepare($query);
                                    $stmt12->bindparam('eid', $userid, PDO::PARAM_STR);
                                    $stmt12->execute();
                                    $noticedata1 = $stmt12->fetch(PDO::FETCH_ASSOC);
                                    $username = $noticedata1['firstName'] . " " . $noticedata1['lastName'];

                                    $noticedata['postedBy'] = $noticedata1['userImage'];
                                    $noticedata['posted'] = $username;
                                    $noticedata['module'] = 'Notice';
                                    
                                    array_push($welcomearray,$noticedata );
                                }
                                break;
                                                       
//                        Display Event Code                            
                            case "Event":
                                $eventquery = "select * from Tbl_Analytic_EventSentToGroup where groupId IN('" . $in . "') and eventId =:id and clientId =:cid";
                                $nstmt = $this->DB->prepare($eventquery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $eventrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                if (count($eventrows) > 0) {
                                    // array_push($welcomearray1["PostType"],$weltype);
                                    $eventquery1 = "select *,Concat('Event','') as type, Concat('6','') as flagCheck, DATE_FORMAT(createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(eventTime,'%d %b %Y %h:%i %p') as eventTime, Concat('$site_url',imageName) as imageName ,REPLACE(description,'\r\n','') as description from Tbl_C_EventDetails where eventId =:id and clientId =:cid";
                                    $nstmt = $this->DB->prepare($eventquery1);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $eventdata = $nstmt->fetch(PDO::FETCH_ASSOC);
                                    $userid = $eventdata['createdBy'];

                                    $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('".$site_url."',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                    $stmt12 = $this->DB->prepare($query);
                                    $stmt12->bindparam('eid', $userid, PDO::PARAM_STR);
                                    $stmt12->execute();
                                    $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);
                                    $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];

                                    $eventdata['postedBy'] = $eventdata1['userImage'];
                                    $eventdata['posted'] = $username;
                                    $eventdata['module'] = 'Events';

                                    array_push($welcomearray, $eventdata);
                                }
                                break;

//                        Display Album Code                            
                            case "Album":
                                $eventquery = "select * from Tbl_Analytic_AlbumSentToGroup where groupId IN('" . $in . "') and albumId =:id and clientId =:cid";
                                $nstmt = $this->DB->prepare($eventquery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $eventrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                if (count($eventrows) > 0) {
                                    $eventquery1 = "select album.*,Concat('Album','') as type, Concat('11','') as flagCheck, DATE_FORMAT(album.createdDate,'%d %b %Y') as createdDate, Concat('$site_url',album_image.imgName) as imageName from Tbl_C_AlbumDetails as album join Tbl_C_AlbumImage as album_image on album_image.albumId=album.albumId where album.albumId =:id and album.clientId =:cid";
                                    $nstmt = $this->DB->prepare($eventquery1);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $eventdata = $nstmt->fetch(PDO::FETCH_ASSOC);
                                    $userid = $eventdata['createdby'];

                                    $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('$site_url',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                    $stmt12 = $this->DB->prepare($query);
                                    $stmt12->bindparam(':eid', $userid, PDO::PARAM_STR);
                                    $stmt12->execute();
                                    $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);

                                    $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];
                                    $eventdata['posted'] = $username;
                                    $eventdata['postedBy'] = $eventdata1['userImage'];
                                    $eventdata['module'] = 'Media';

                                    array_push($welcomearray, $eventdata);
                                }
                                break;

//                        Display Poll Code                                                            
                       /*     case "Poll":
                                $pollquery = "select * from Tbl_Analytic_PollSentToGroup where groupId IN('" . $in . "') and pollId =:id and clientId =:cid";
                                $nstmt = $this->DB->prepare($pollquery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $pollrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                if (count($pollrows) > 0) {
                                    $pollquery = "select PD.*,Concat('Poll','') as type, Concat('4','') as flagCheck, DATE_FORMAT(PD.createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(PD.publishingTime,'%d %b %Y') as publishingTime,Concat('$site_url',PD.pollImage) as pollImage, DATE_FORMAT(PD.unpublishingTime,'%d %b %Y') as unpublishingTime ,PO.* from Tbl_C_PollDetails as PD join Tbl_C_PollOption as PO on PD.pollId = PO.pollId where PD.pollId =:id and PD.clientId =:cid";
                                    $nstmt = $this->DB->prepare($pollquery);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $polldata = $nstmt->fetch(PDO::FETCH_ASSOC);
                                    $userid = $polldata['createdBy'];
									$pollId = $polldata['pollId']; 
									
 /***********************************************poll option **********************************
 $polldata['option'] = array();
 
   $query = "select *,if(ansInImage IS NULL or ansInImage='', '', Concat('$site_url',ansInImage)) as ansInImage from Tbl_C_PollOption where pollId=:pid";
                            $stmt = $this->DB->prepare($query);
                            $stmt->bindParam(':pid', $pollId, PDO::PARAM_STR);
                            $stmt->execute();
                            $polloption = $stmt->fetchAll(PDO::FETCH_ASSOC);
   // array_push($polldata['option'], $polloption);
	$polldata['option'] = $polloption;
 /**********************************************************************************
									
									
                                    $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('$site_url',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                    $stmt12 = $this->DB->prepare($query);
                                    $stmt12->bindparam(':eid', $userid, PDO::PARAM_STR);
                                    $stmt12->execute();
                                    $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);

                                    $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];
                                    $polldata['posted'] = $username;
                                    $polldata['postedBy'] = $eventdata1['userImage'];
                                    $polldata['module'] = 'Feedbacks';

                                    array_push($welcomearray, $polldata);
                                }

                                break;  */

//                        Display News Code                                                                                            
                            case "News":
                             case ($weltype == "News" || $weltype == "Message" || $weltype == "Picture"):


//$status = "Publish";
                                $eventquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and postId =:id and clientId =:cid and status = 1";
                                $nstmt = $this->DB->prepare($eventquery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $postrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
//                                Concat('$site_url', post_img) as post_img
                                if (count($postrows) > 0) 
                                    {
                                    $newsquery = "select *, Concat(:type,'') as type ,  if(thumb_post_img IS NULL or thumb_post_img='' , Concat('$site_url',post_img),Concat('$site_url',thumb_post_img) ) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";
                                    $nstmt = $this->DB->prepare($newsquery);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->bindParam(':type', $weltype, PDO::PARAM_STR);

                                    $nstmt->execute();
                                    $val = $nstmt->fetch(PDO::FETCH_ASSOC);
                                    $userid = $val['userUniqueId'];

                                    $imgquery = "select ud.firstName, concat('$site_url',up.userImage) as UserImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where ud.clientId=:cli and ud.employeeId=:empid";
                                    $stmt = $this->DB->prepare($imgquery);
                                    $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                    $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
//$val["UserName"]=$rows["firstName"];
                                    $val["UserImage"] = $rows["UserImage"];

                                    array_push($welcomearray, $val);
                                    
                                 //   print_r($val);
                                }
                                break;

                              
				  case "CEOMessage":
                                $eventquery1 = "select *,Concat('CEOMessage','') as type, DATE_FORMAT(created_date,'%d %b %Y') as created_date, if(thumb_post_img IS NULL or thumb_post_img='' , Concat('$site_url',post_img),Concat('$site_url',thumb_post_img) ) as post_img from Tbl_C_PostDetails where Post_id =:id and clientId =:cid and flagCheck = 9";
                                $nstmt = $this->DB->prepare($eventquery1);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $val1 =  $nstmt->fetch(PDO::FETCH_ASSOC);
                                 $userid = $val1['userUniqueId'];
                                
                                 $imgquery = "select ud.firstName, concat('$site_url',up.userImage) as UserImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where ud.clientId=:cli and ud.employeeId=:empid";
                                    $stmt = $this->DB->prepare($imgquery);
                                    $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                    $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
//$val["UserName"]=$rows["firstName"];
                                    $val1["UserImage"] = $rows["UserImage"];
                                
                                array_push($welcomearray,$val1);
                                break;
				
                             case "Onboard":
                                $noticequery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and 
    postId =:id and clientId =:cid";
                                $nstmt = $this->DB->prepare($noticequery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $onboardrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($onboardrows) > 0) {
                                    $noticequery1 = "select *, Concat('Post','') as type, Concat('12','') as flagCheck, Concat('$site_url','notice/notice_img/notice-min.jpg') as userImage,
             if(thumb_post_img IS NULL or thumb_post_img='' , Concat('$site_url',post_img),Concat('$site_url',thumb_post_img) ) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails where post_id=:id and clientId =:cid";
                                    $nstmt = $this->DB->prepare($noticequery1);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $onboardData = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                    //echo'<pre>';print_r($onboardData);die;
                                    foreach ($onboardData as $values) {
                                        //echo '<pre>';print_r($values);die;
                                        $post_content_keys = explode("#Benepik#", $values['post_content']);

                                        //echo '<pre>';print_r($post_content_keys);die;

                                        unset($post_content_keys[0]);
                                        $post_content_keys = array_values($post_content_keys);
                                        //echo'<pre>';print_r($post_content_keys);die;
                                        $final_data_keys = array();
                                        $final_data_value = array();
                                        foreach ($post_content_keys as $keys => $val) {

                                            $key_data = explode("###", $val);

                                            array_push($final_data_keys, trim($key_data[0], " "));
                                            array_push($final_data_value, strip_tags(trim($key_data[1], " \n\t\t "), ""));
                                        }
                                        $final_data_value[2] = date('d M Y', strtotime($final_data_value[2]));
                                        array_push($final_data_keys, 'user_image', 'user_name');
                                        array_push($final_data_value, $values['post_img'], $values['post_title']);

                                        $response_data = array_combine($final_data_keys, $final_data_value);
                                        $response_data['auto_id'] = $values['auto_id'];
                                        $response_data['post_id'] = $welid;
                                        $response_data['clientId'] = $this->idclient;
                                        $response_data['type'] = "Onboard";
                                        $response_data['flagCheck'] = $values['flagCheck'];

                                        $response_data['username'] = $response_data['user_name'];
                                        $response_data['user_name'] = 'Welcome Aboard : ' . $response_data['user_name'];
                                    }
                                    //echo'<pre>';print_r($response_data);die;

                                    array_push($welcomearray, $response_data);
                                }
                                break;
                                       
	      //Display  Contributor Code                                                                                            
                        /*   case "Contributor":
                                $contributorquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and postId =:id and clientId =:cid";
                                $nstmt = $this->DB->prepare($contributorquery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $postrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
//                                if(post_img IS NULL or post_img='' ,'',Concat('$site_url',post_img) ) as post_img,
                                if (count($postrows) > 0)
									{
                                    $newsquery = "select *, Concat(:type,'') as type ,  if(thumb_post_img IS NULL or thumb_post_img='' ,Concat('$site_url',post_img),Concat('$site_url',thumb_post_img) ) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date,REPLACE(post_content,'\r\n','') as post_content from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";
                                    $nstmt = $this->DB->prepare($newsquery);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->bindParam(':type', $weltype, PDO::PARAM_STR);

                                    $nstmt->execute();
                                    $val1 = $nstmt->fetch(PDO::FETCH_ASSOC);
                                    $userid = $val1['userUniqueId'];

                                    $imgquery = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('$site_url',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.clientId=:cli and emp_master.employeeId=:empid";
                                    $stmt = $this->DB->prepare($imgquery);
                                    $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                    $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                    $stmt->execute();
                                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $username = $rows['firstName'] . " " . $rows['lastName'];
                                    $eventdata['posted'] = $username;
                                    $val1["postedBy"] =  $rows["userImage"];
                                    $val1['module'] = 'Contribute';

                                    array_push($welcomearray, $val1);
                                }
                                break;*/

//                        Display AchiverStory Code                                                                                            
                       /*     case "AStory":
                                $eventquery1 = "select *,Concat('AStory','') as type, DATE_FORMAT(createdDate,'%d %b %Y') as createdDate, Concat('$site_url',imagePath) as imagePath, flagType as flagCheck, REPLACE(story,'\r\n','') as story from Tbl_C_AchiverStory where storyId =:id and clientId =:cid and flagType = 16";
                                $nstmt = $this->DB->prepare($eventquery1);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $val = $nstmt->fetch(PDO::FETCH_ASSOC);
                                $val['post_img'] = $val['imagePath'];
                                unset($val['imagePath']);
                                $userid = $val['createdBy'];

                                $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('$site_url',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                $stmt12 = $this->DB->prepare($query);
                                $stmt12->bindparam(':eid', $userid, PDO::PARAM_STR);
                                $stmt12->execute();
                                $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);

                                $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];
                                $val['posted'] = $username;
                                $val['postedBy'] = $eventdata1['userImage'];
                                $val['module'] = 'Hall of Fame';

                                array_push($welcomearray, $val);
                                break;*/

//                        Display JobPost Code                                                                                            
                          /*  case "JobPost":
                                $eventquery1 = "select *,Concat('JobPost','') as type, Concat('15','') as flagCheck, DATE_FORMAT(createdDate,'%d %b %Y') as created_date from Tbl_C_JobPost where jobId =:id and clientId =:cid and status = 1";
                                $nstmt = $this->DB->prepare($eventquery1);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $val = $nstmt->fetch(PDO::FETCH_ASSOC);
                                $userid = $val['createdBy'];
                                unset($val['createdDate']);

                                $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('$site_url',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                $stmt12 = $this->DB->prepare($query);
                                $stmt12->bindparam(':eid', $userid, PDO::PARAM_STR);
                                $stmt12->execute();
                                $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);

                                $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];
                                $val['posted'] = $username;
                                $val['postedBy'] = $eventdata1['userImage'];
                                $val['module'] = 'Opportunities';

                                array_push($welcomearray, $val);
                                break;*/

                            default: "Invalid data";
                        }
                    }
                } catch (PDOException $e) {
                    echo $e;
                    $result['success'] = 0;
                    $result['message'] = "data not fount found";
                    return $result;
                }

       /*********************************************************************************************** */
//$uniquedata = array_values(array_unique($welcomearray));
                $datacount = count($welcomearray);
//echo "array of user ".$datacount."<br>";
                $result['totalpost'] = $datacount;
                /* echo "<pre>";
                  //print_r($welcomearray);
                  echo "</pre>"; */
                $welcomedata = array();
                if ($datacount < 1) {
                    $result['success'] = 0;
                    $result['message'] = "No Post Available";
                    return $result;
                } else {
//$start = $this.value * 5;
//echo "start value ".$start;
//echo "<br>";

                    for ($ui = $start, $kh = 1; $ui < $datacount; $ui++, $kh++) {
//print_r($welcomearray[$ui]);
//echo "welcome array ".$kh."<br>";
                        array_push($welcomedata, $welcomearray[$ui]);
                        if ($kh <= 4) {
//echo "if part".$kh;
                            continue;
                        } else {
//echo "else part ".$kh;
                            break;
                        }
                    }
//print_r($welcomedata);
                    $result['success'] = 1;
                    $result['message'] = "data found";
                    $result['welcomedata'] = $welcomedata;
//echo "welcome array"."<br/>";
                    /* echo "<pre>";
                      print_r($result);
                      echo "</pre>"; */
                }
            }
        } else {
            $result['success'] = 0;
            $result['message'] = "Sorry !! You are not Authorized user";
        }
        return $result;
    }

}

?>