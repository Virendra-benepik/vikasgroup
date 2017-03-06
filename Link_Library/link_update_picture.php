<?php
session_start();
require_once('../Class_Library/class_post.php');
$obj = new Post();
if (!empty($_POST['client'])) {
    $cid = $_POST['client'];
    $pid = $_POST['postid'];
    $page = $_POST['page'];
     //echo $page;
    $USERID = $_SESSION['user_unique_id'];
    
    $title ="";
    $content = $_POST['content']; 
    $previousimage = $_POST['himage'];
    $path = $_FILES['uploadimage']['name'];
    $pathtemp = $_FILES['uploadimage']['tmp_name'];

    $target = '../images/post_img/';   // folder name for storing data
    $folder = 'images/post_img/';      //folder name for add with image insert into table

    date_default_timezone_set('Asia/Calcutta');
    $post_date = date("Y-m-d h:i:sa", time());

    /************************fetch max id ************************************ */
      if(!empty($path))
      {
	  unlink(BASE_PATH . '/' . $previousimage);
      $path_name = $pid . "-" . $path;

      $imagepath = $target . $path_name;
      
       $POST_IMG = $folder . $path_name;
    $fullpath = SITE_URL . "images/post_img/" . $path_name;
//echo $fullpath;
    $obj->compress_image($pathtemp, $imagepath, 20);
    
      }
 else {
         $POST_IMG = $previousimage;
         }
		 
		 
    $result = $obj->updatePost($cid, $pid, $title, $content, $POST_IMG, $post_date, $USERID);
   
    if ($result['success'] == 1) 
        {
        if($page == "picture")
        {
        echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_picture.php'</script>";
        }
        }
	else
	{
		echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_picture.php'</script>";
	}
}


/* * ********************* insert into databse ************************************************ */ 
else {
    ?>
    <script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>

    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <p>Page Id:
            <label for="textfield"></label>
            <input type="text" name="pageid" id="textfield">
        </p> 
        <p>Page Title:
            <label for="textfield"></label>
            <input type="text" name="pagetitle" id="textfield">
        </p>

        <p>Page image:
            <label for="textfield"></label>
            <input type="file" name="pageimage" id="textfield">
        </p>
        <p>Page Content:
            <label for="textfield"></label>
            <textarea cols="80" id="editor1" name="pagecontent" rows="10">	
            </textarea>

        <p>created date:
            <label for="textfield"></label>
            <input type="date" name="date" id="textfield"> 
        </p>

        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <?php

}
?>
