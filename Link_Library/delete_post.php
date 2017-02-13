<?php
require_once('../Class_Library/class_post.php');

if(!empty($_GET))
{ 
$obj = new Post();
$post_id = $_GET['idpost'];

$result = $obj->delete_Post($post_id);
if(!empty($result))
{
echo "<script>alert('Post has deleted successfully')</script>";
if($_GET['page']=="mesg")
{
echo "<script>window.location='http://admin.benepik.com/employee/virendra/benepik_client/view_message.php'</script>";
}
else if($_GET['page']=="picture")
{
echo "<script>window.location='http://admin.benepik.com/employee/virendra/benepik_client/view_picture.php'</script>";
}
else
{
echo "<script>window.location='http://admin.benepik.com/employee/virendra/benepik_client/view_news.php'</script>";
}
}

}
else
{
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