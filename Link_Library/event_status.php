<?php
@session_start();
require_once('../Class_Library/class_event.php');

if (!empty($_GET)) {
   $obj = new Event();
   $uuid = $_SESSION['user_unique_id'];
   $pid = $_GET['eventid'];
   $pst = $_GET['status'];
   
  //$server = dirname(SITE_URL) . '/';
 $server = SITE_URL;

    if ($pst == 'Active') {
        $pst1 = 0;

        $result = $obj->status_Event($pid, $pst1,$uuid);
		//echo $result;
		
        if($result) {
            echo "<script>alert('status has changed')</script>";
            echo "<script>window.location='" . $server . "view_event.php'</script>";
          
        }
    } else {
        $pst2 = 1;
        $result = $obj->status_Event($pid, $pst2,$uuid);
        if ($result) {
            echo "<script>alert('status has changed')</script>";
            echo "<script>window.location='" . $server . "view_event.php'</script>";
        }
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">


        <p>Post id:
            <label for="textfield"></label>
            <input type="text" name="eventid" id="textfield">
        </p>
        <p>Post status:
            <label for="textfield"></label>
            <input type="text" name="status" id="textfield">
        </p>

        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <?php
}
?>