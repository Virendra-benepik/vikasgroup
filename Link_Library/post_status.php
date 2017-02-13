

<?php
  
require_once('../Class_Library/class_post.php');

if (!empty($_GET)) {
    $obj = new Post();

    $pid = $_GET['postid'];
    $pst = $_GET['poststatus'];

    //$server = dirname(SITE_URL) . '/';
	$server = SITE_URL;

    if ($pst == "Publish") {
        $pst1 = "Unpublish";
        $result = $obj->status_Post($pid, $pst1);
        if ($result) {
            echo "<script>alert('Post status has changed')</script>";
            if ($_GET['page'] == "mesg") {
                echo "<script>window.location='" . $server . "view_message.php'</script>";
            } else if ($_GET['page'] == "job") {
                echo "<script>window.location='" . $server . "view_job.php'</script>";
            } else if ($_GET['page'] == "picture") {
                echo "<script>window.location='" . $server . "view_picture.php'</script>";
            } else {
                echo "<script>window.location='" . $server . "view_news.php'</script>";
            }
        }
    } else {
        $pst2 = "Publish";
        $result = $obj->status_Post($pid, $pst2);
        if ($result) {
            echo "<script>alert('Post status has changed')</script>";
            if ($_GET['page'] == "mesg") {
                echo "<script>window.location='" . $server . "view_message.php'</script>";
            } else if ($_GET['page'] == "job") {
                echo "<script>window.location='" . $server . "view_job.php'</script>";
            } else if ($_GET['page'] == "picture") {
                echo "<script>window.location='" . $server . "view_picture.php'</script>";
            } else {
                echo "<script>window.location='" . $server . "view_news.php'</script>";
            }
        }
    }
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">


        <p>Post id:
            <label for="textfield"></label>
            <input type="text" name="post_id" id="textfield">
        </p>
        <p>Post status:
            <label for="textfield"></label>
            <input type="text" name="post_status" id="textfield">
        </p>

        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <?php
}
?>