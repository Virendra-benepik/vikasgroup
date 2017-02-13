<?php
  
require_once('../Class_Library/class_eventSponsership.php');

if (!empty($_GET)) {
  $obj = new Sponsership();

    $pid = $_GET['postid'];
    $pst = $_GET['poststatus'];
   
//$server = dirname(SITE_URL) . '/';
 $server = SITE_URL;

    if ($pst == 'Publish') {
        $pst1 = 'Unpublish';

        $result = $obj->status_Post($pid, $pst1);
		//echo $result;
		
        if($result) {
            echo "<script>alert('status has changed')</script>";
            echo "<script>window.location='" . $server . "view_contributor.php'</script>";
          
        }
    } else {
        $pst2 = 'Publish';
        $result = $obj->status_Post($pid, $pst2);
        if ($result) {
            echo "<script>alert('status has changed')</script>";
            echo "<script>window.location='" . $server . "view_contributor.php'</script>";
        }
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">


        <p>Post id:
            <label for="textfield"></label>
            <input type="text" name="postid" id="textfield">
        </p>
        <p>Post status:
            <label for="textfield"></label>
            <input type="text" name="poststatus" id="textfield">
        </p>

        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <?php
}
?>