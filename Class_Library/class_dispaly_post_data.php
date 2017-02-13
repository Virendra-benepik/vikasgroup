<?php
include_once('class_connect_db_Communication.php');
include_once('class_find_groupid.php');  
class PostDisplay
{

 public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
    $this->DB = $db->getConnection_Communication();
  }

function PostDisplay($clientid,$uid,$val)
  {

     $this->idclient = $clientid;
     $this->value = $val;
   
     try
     {
     $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt->bindParam(':empid',$uid, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
               if(count($rows)>0)
                  {
                  
                   $group_object = new findGroup();    // this is object to find group id of given unique id 
     
        $getgroup = $group_object->groupBaseofUid($clientid,$uid);
        $value = json_decode($getgroup,true);
        
/**************************************************************************************************/

$count_group = count($value['groups']);
//echo "total group of empid =: ".$count_group."<br/>";

if($count_group <= 0 )
{

     $result["success"]=0;
     $result["message"]="Sorry You are Not in Any Group";  
     return $result;

}
//$fr = "' . implode('", "', $elements) . '";
else
{
$in = implode("', '", array_unique($value['groups']));
//echo "group array : ".$in."<br/>";

/****************************************************************************************************/
$eventquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('".$in."') and clientId =:cid";
   $nstmt = $this->DB->prepare($eventquery);
             $nstmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
             $nstmt->execute();
             $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
$postarray = array();
/*echo "<pre>";
print_r($welrows);
echo "</pre>";*/
foreach($welrows as $postid)
{
array_push($postarray,$postid['postId']);
}

 $unique_postid = array_values(array_unique($postarray));
$totalpost = count($unique_postid);

print_r($unique_postid);die;
$status = "Publish";
$newspostarray = array();
	
	/***********************************************************************/
	
for($k=0;$k<$totalpost;$k++)
{
	
$qu = "select flagCheck from Tbl_C_PostDetails where post_id=:pid and clientId=:cid and status = :pub";
 $stmt3 = $this->DB->prepare($qu);
             $stmt3->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
             $stmt3->bindParam(':pid',$unique_postid[$k], PDO::PARAM_STR);
              $stmt3->bindParam(':pub',$status, PDO::PARAM_STR);
             $stmt3->execute();
             $rows5 = $stmt3->fetch(PDO::FETCH_ASSOC);
           // print_r($rows5);
	
if($rows5['flagCheck'] == 1 || $rows5['flagCheck'] == 2 || $rows5['flagCheck'] == 3)
{
//echo "flag check ".$rows5['flagCheck']."<br>";
array_push($newspostarray,$unique_postid[$k]);
}
	if ($module == "web") 
	{
		if($rows5['flagCheck'] == 1)
			{
			//echo "flag check ".$rows5['flagCheck']."<br>";
			array_push($newspostarray,$unique_postid[$k]);
			}
	}
	

}

	/********************************************************************/
	
$unique_postid1 = array_values(array_unique($newspostarray));
/*echo "<pre>";
print_r($newspostarray);
echo "</pre>";*/
$totalpostnews = count($unique_postid1);


$post = array();
$result['success'] = 1;
$result['message'] = "data found";
$result['totalpost'] = $totalpostnews;
$result['posts'] = array();
$welcount = count($unique_postid1);
//echo "total post".$welcount."<br>";
for($w=$welcount-1;$w>=0;$w--)
{
$postid = $unique_postid1[$w];
//$clientid = $welrows[$w]['clientId'];
//echo $postid."<br>";
  $query3 = "select count(likeBy) as total_likes from Tbl_Analytic_PostLike where postId=:pstid and clientId=:cli";
             $stmt3 = $this->DB->prepare($query3);
             $stmt3->bindParam(':pstid',$postid, PDO::PARAM_STR);
             $stmt3->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt3->execute();
             $rows3 = $stmt3->fetch(PDO::FETCH_ASSOC);
             $post["total_likes"]=$rows3["total_likes"];

             $query4 = "select count(commentBy) as total_comments from Tbl_Analytic_PostComment where postId=:pstid and clientId=:cli";
             $stmt4 = $this->DB->prepare($query4);
             $stmt4->bindParam(':pstid',$postid, PDO::PARAM_STR);
             $stmt4->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt4->execute();
             $rows4 = $stmt4->fetch(PDO::FETCH_ASSOC);
             $post["total_comments"]=$rows4["total_comments"];

             $query2 = "select * , concat('http://mconnect.benepik.com/',post_img) as post_img , DATE_FORMAT(created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where post_id=:pstid and clientId=:cli order by auto_id limit ".$this->value.",5";
             $stmt2 = $this->DB->prepare($query2);
             $stmt2->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt2->bindParam(':pstid',$postid, PDO::PARAM_STR);
             $stmt2->execute();
             $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);

$post["auto_id"] = $rows2["auto_id"];
$post["post_id"] = $rows2["post_id"];
$post["clientId"] = $rows2["clientId"];
$post["post_title"]=$rows2["post_title"];
$post["post_img"]=$path.$rows2["post_img"];
$post["postTeaser"]=$rows2["postTeaser"];
$post["post_content"]=$rows2["post_content"];
$post["flagCheck"]=$rows2["flagCheck"];

$post["created_date"]=$rows2["created_date"];
$post["likeSetting"]=$rows2["likeSetting"];
$post["comment"]=$rows2["comment"];
$post["userUniqueId"]=$rows2["userUniqueId"];

$uui = $post["userUniqueId"];

     $query = "select Tbl_EmployeeDetails_Master.firstName, concat('http://admin.benepik.com/employee/virendra/benepik_admin/',Tbl_EmployeePersonalDetails.userImage) as UserImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeePersonalDetails.employeeId=:empid and Tbl_EmployeeDetails_Master.employeeId=:empid";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
             $stmt->bindParam(':empid',$uui, PDO::PARAM_STR);
             $stmt->execute();
             $rows = $stmt->fetch(PDO::FETCH_ASSOC);
$post["UserName"]=$rows["firstName"];
$post["UserImage"]=$rows["UserImage"];

array_push($result["posts"],$post);
               
}

/************************************************************************************************/
$datacount = count($post);
//echo $datacount;
if($datacount < 1)
{
$result['success'] = 0;
$result['message'] = "No Post Available";
return $result;
}
else
{
 return $result;
 }
}


                  }
                  else
                  {
                  $result['success'] = 0;
                       $result['message'] = "Sorry You are not Authorized";
                       return $result;
                  
                  }
                 
                 
  }
   catch(PDOException $e)
                 {
                       echo $e;
                       $result['success'] = 0;
                       $result['message'] = "data not fount found ".$e;
                       return $result;

                   }
}
}
?>