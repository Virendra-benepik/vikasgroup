<?php
  
require_once('../Class_Library/class_upload_album.php');

if (!empty($_GET)) {
   $obj = new Album();

   $pid = $_GET['postid'];
   $pst = $_GET['imagestatus'];
   $imgid = $_GET['imageid'];
   
  //$server = dirname(SITE_URL) . '/';
 $server = SITE_URL;

    if ($pst == 1) {
        $pst1 = 0;

        $result = $obj->status_albumImage($pid, $pst1,$imgid);
		//echo $result;
		
        if($result) {
            echo "<script>alert('status has changed')</script>";
            echo "<script>window.location='" . $server . "full_view_album.php?albumid=".$pid."'</script>";
          
        }
    } else {
        $pst2 = 1;
        $result = $obj->status_albumImage($pid, $pst2,$imgid);
        if ($result) {
            echo "<script>alert('status has changed')</script>";
            echo "<script>window.location='" . $server . "full_view_album.php?albumid=".$pid."'</script>";
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