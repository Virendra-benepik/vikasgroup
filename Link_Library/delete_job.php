<?php
require_once('../Class_Library/class_jobpost.php');

if (!empty($_GET)) {
    $obj = new JobPost();
    $jobid = $_GET['jobid'];

    $server = SITE_URL;
    $result = $obj->delete_job($jobid);
    if (!empty($result)) {
        echo "<script>alert('Job has been deleted successfully')</script>";
        if ($_GET['page'] == "jobs") {
            echo "<script>window.location='".$server."view_jobs_directory.php'</script>";
        }
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">


        <p>Post id:
            <label for="textfield"></label>
            <input type="text" name="post_id" id="textfield">
        </p>
        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <?php
}
?>