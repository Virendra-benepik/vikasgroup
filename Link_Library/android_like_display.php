<?php
require_once('../Class_Library/class_post_like.php');

if(!empty($_POST))
{ 

$obj = new Like();
$pid = $_POST['post_id'];
$val = $obj->like_display($pid);
$val1 = json_decode($val, true);
echo $val;

}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
<p>Post_id:
  <label for="textfield"></label>
  <input type="text" name="post_id" id="textfield">
  </p>
  
  <p>
    <input type="submit" name="submit" id="button" value="Click to Display Post Details">
  </p>
</form>
<?php
}
?>