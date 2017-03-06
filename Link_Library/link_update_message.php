<?php
session_start();
require_once('../Class_Library/class_post.php');
$obj = new Post();
if (!empty($_POST['client'])) {
   $cid = $_POST['client'];
   $pid = $_POST['postid'];
   $page = $_POST['page'];
    // echo $page;
   $USERID = $_SESSION['user_unique_id'];
    
   $title = $_POST['posttitle'];
   $content = $_POST['postcontent']; 
    
    date_default_timezone_set('Asia/Calcutta');
    $post_date = date("Y-m-d h:i:sa", time());
    
	$POST_IMG = "";
    $result = $obj->updatePost($cid, $pid, $title, $content, $POST_IMG, $post_date, $USERID);
   
    if ($result['success'] == 1) 
        {
        if($page == "message")
        {
        echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_message.php'</script>";
        }
    }
	else{
	    echo "<script>alert('Post Not Updated');</script>";
        echo "<script>window.location = '../view_message.php'</script>";	
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
