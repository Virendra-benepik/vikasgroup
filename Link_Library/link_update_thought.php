<?php
session_start();
require_once('../Class_Library/class_thought.php');
$obj = new ThoughtOfDay();
if (!empty($_POST['client'])) {
    $cid = $_POST['client'];
    $pid = $_POST['postid'];
    $page = $_POST['page'];
     //echo $page;
    $USERID = $_SESSION['user_unique_id'];
    
    
    $content = $_POST['content']; 
    $previousimage = $_POST['himage'];
    $path = $_FILES['uploadimage']['name'];
    $pathtemp = $_FILES['uploadimage']['tmp_name'];

    $target = '../images/ThoughtsOFtheDAY/';   // folder name for storing data
    $folder = 'images/ThoughtsOFtheDAY/';      //folder name for add with image insert into table

    date_default_timezone_set('Asia/Calcutta');
    $post_date = date("Y-m-d h:i:sa", time());

    /************************fetch max id ************************************ */
      if(!empty($path))
      {
	  unlink(BASE_PATH . '/' . $previousimage);
      $path_name = $pid . "-" . $path;

      $imagepath = $target . $path_name;
      
       $POST_IMG = $folder . $path_name;
    $fullpath = SITE_URL . "images/ThoughtsOFtheDAY/" . $path_name;
//echo $fullpath;
    $obj->compress_image($pathtemp, $imagepath, 20);
    
      }
 else {
         $POST_IMG = $previousimage;
         }
		 
		 
    $result = $obj->updateThought($cid, $pid,$content, $POST_IMG, $post_date, $USERID);
   
    if ($result['success'] == 1) 
        {
        if($page == "thought")
        {
        echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_thought.php'</script>";
        }
        }
	else
	{
		echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_thought.php'</script>";
	}
}
?>
