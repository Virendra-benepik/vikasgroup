<?php
include_once('class_connect_db_Communication.php');

class GetMyLifeMahle
{
    
  public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
       $this->DB = $db->getConnection_Communication();
  
  }
  
public $cid;
public $eid;
public $uid;
  function getAllMahleLife($cid,$eid,$usertype)
  {
  $this->cid = $cid;
  $this->eid = $eid;
  $this->uid = $usertype;
$server_name = "http://".$_SERVER['SERVER_NAME']."/Benepik_demo/";
if($this->uid == "SubAdmin")
{

$query = "select *, Concat('".$server_name."', post_img) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 8 and createdBy = :cb order by auto_id desc";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
		 $stmt->execute(array('cli'=>$this->cid,'cb'=>$this->eid));
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          //$response=array();
          $response["success"]=1;
          $response["message"]="data fetched successfully";
          $response["posts"]=$rows;

}
else
{
$query = "select *,Concat('".$server_name."', post_img) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 8 order by auto_id desc";

	  try
	  {
		 $stmt = $this->DB->prepare($query); 
		 $stmt->execute(array('cli'=>$this->cid));
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
	  echo $query;
 	  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //  $response=array();
          $response["success"]=1;
          $response["message"]="data fetched successfully";
          $response["posts"]=$rows;

}

    	 return json_encode($response);
    	 
}


/************************ get all notice ***************************************/

function getStatusOfNotice($pub,$unpub)
{

$pub1 = substr($pub,0,18);
$pub2 = $pub1."00";

$unpub1 = substr($unpub,0,18);
$unpub2 = $unpub1."00";

date_default_timezone_set("Asia/Kolkata");
$dat1 = date("d-m-Y h:i:s");
$dat = strtotime($dat1);
echo "Created Date in seconds:- ".$dat;
echo "<br>";
$pubDat = strtotime($pub2);
echo "<br>".$pub2."  Publishing Time:- ".$pubDat;
$unpubDat = strtotime($unpub2);
echo "<br>".$unpub2."  Unpublishing Time:- ".$unpubDat;
echo "<br><br>";


if(($dat>=$pubDat) && ($dat<=$unpubDat))
{
echo "Live Notice";
}
else if($dat<$pubDat)
{
echo "Have a time for publishing Notice";
}
else
{
echo "Expire Notice";
}


}


/**********************************Get Data for android *****************************************************/


  function getAllMahleLifeFORandroid($clientid,$val)
  {
  $server_name = "http://".$_SERVER['SERVER_NAME']."/";
$this->idclient = $clientid;
$this->value = $val;
	  try
	  {
            $query = "select *,Concat('".$server_name."', post_img) as post_img, DATE_FORMAT(Tbl_C_PostDetails.created_date,'%d %b %Y %h:%i %p') as created_date from Tbl_C_PostDetails where clientId=:cli and flagCheck = 8 order by auto_id desc limit ".$this->value." , 5";
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
		 $stmt->execute();
             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

             $response = array();

               if(count($rows)>0)
                  {


     $query1 = "select count(post_id) as totals from Tbl_C_PostDetails where clientId=:cli and flagCheck = 8";
             $stmt1 = $this->DB->prepare($query1);
             $stmt1->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
             $stmt1->execute();
             $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                  $response["success"]=1;
                  $response["message"]="You successfully fetched";
                  $response["totals"]=$rows1[0]["totals"];
                  $response["posts"]= $rows;
/*
foreach($rows as $row)
{
$post["autoId"] = $row["autoId"];
$post["clientId"] = $row["clientId"];
$post["post_id"] = $row["post_id"];
$post["noticeTitle"] = $row["noticeTitle"];
$post["fileName"] = $path.$row["fileName"];
$post["location"] = $row["location"];
$post["createdBy"] = $row["createdBy"];
$post["createdDate"] = $row["createdDate"];
$post["status"] = $row["status"];
$post["publishingTime"] = $row["publishingTime"];
$post["unpublishingTime"] = $row["unpublishingTime"];
array_push($response["posts"],$post);
}*/

                  return json_encode($response);
                  }
                  else
                  {
                  $response["success"]=0;
                  $response["message"]="No More Posts Available";
                  return json_encode($response);
                  }
	  }
         
         catch(PDOException $e)
         {
         echo $e;
                  $response["success"]=0;
                  $response["message"]="client id or initial value is incorrect";
                  return json_encode($response);
         }

 	 //$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //	 return json_encode($rows);
		
      
  }

  function getSinglePost($postid,$clientid)
  {
  $this->id = $postid;
  $this->cli = $clientid;
$server_name = "http://".$_SERVER['SERVER_NAME']."/Benepik_demo/";
      $query = "select *, DATE_FORMAT(created_date,'%d %b %Y %h:%i %p') as created_date , Concat('".$server_name."',post_img) as post_img  from Tbl_C_PostDetails where post_id =:pid and clientId=:cli";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':pid',$this->id, PDO::PARAM_STR);
                 $stmt->bindParam(':cli',$this->cli, PDO::PARAM_STR);
		 $stmt->execute();
                 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
return json_encode($rows);
	   }
         
         catch(PDOException $e)
         {
         echo $e;
         }

}

  function updateNoticeStatus($pid,$sta)
  {
  $this->noticeid = $pid;
  $this->status = $sta;

      $query = "update Tbl_C_NoticeDetails set status=:sta where noticeId =:pid";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':pid',$this->noticeid, PDO::PARAM_STR);
                 $stmt->bindParam(':sta',$this->status, PDO::PARAM_STR);
		 if($stmt->execute())
                 {
                    $response[success] =1;
                    $response[message] ="Successfully notice status changed";
                    return json_encode($response); 
                 }
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
  }

  function deleteNotice($nid)
  {
  $this->noticeid = $nid;

      $query = "delete from Tbl_C_NoticeDetails where noticeId =:nid";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
                 $stmt->bindParam(':nid',$this->noticeid, PDO::PARAM_STR);
 		 if($stmt->execute())
                 {
                    $response[success] =1;
                    $response[message] ="Successfully notice deleted";
                    return json_encode($response); 
                 }
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }
  }

}
?>