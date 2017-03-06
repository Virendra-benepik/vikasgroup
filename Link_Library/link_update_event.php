<?php
session_start();
require_once('../Class_Library/class_event.php');
require_once('../Class_Library/class_post.php');
$obj = new Post();
$obj_event = new Event();
if (!empty($_POST['client'])) {
  $cid = $_POST['client'];
  $pid = $_POST['postid'];
  $page = $_POST['page'];
     //echo $page;
	 
  $USERID = $_SESSION['user_unique_id'];
    
  $title = $_POST['posttitle'];
  $venue = $_POST['venue'];
  $eventdate = $_POST['event_date'];
  $eventtime = $_POST['event_time'];
  $registration = $_POST['reg'];
  $cost = $_POST['cost'];
  $description = $_POST['description'];
  $EVENT_FULL_TIME = $eventdate . " " . $eventtime;
  $previousimage = $_POST['himage'];
  $path = $_FILES['uploadimage']['name'];
  $pathtemp = $_FILES['uploadimage']['tmp_name'];

    $target = '../Event/event_img/';   // folder name for storing data
    $folder = 'Event/event_img/';      //folder name for add with image insert into table

    date_default_timezone_set('Asia/Calcutta');
    $post_date = date("Y-m-d h:i:sa", time());

    /************************fetch max id ************************************ */
      if(!empty($path))
      {
	   unlink(BASE_PATH . '/'. $previousimage);
		  //echo BASE_PATH;
      $path_name = $pid . "-" . $path;

      $imagepath = $target . $path_name;
      
    $POST_IMG = $folder . $path_name;
    $fullpath = SITE_URL . "Event/event_img/" . $path_name;
//echo $fullpath;
    $obj->compress_image($pathtemp, $imagepath, 20);
	//echo BASE_PATH . '/'. $previousimage;
      }
 else {
         $POST_IMG = $previousimage;
         }
		//echo $POST_IMG;
		 
    $result = $obj_event->updatePost($cid, $pid, $title, $venue,$registration,$description ,$EVENT_FULL_TIME, $POST_IMG, $post_date, $USERID,$cost);
   
    if ($result['success'] == 1) 
        {
        if($page == "event")
        {
        echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_event.php'</script>";
        }
    }
	else
	{
		echo "<script>alert('Post Not Updated');</script>";
        echo "<script>window.location = '../view_event.php'</script>";
	}
}



?>
