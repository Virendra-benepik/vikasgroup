<?php
require_once('../Class_Library/class_like.php');

if(!empty($_POST))
{ 

$obj = new Like();

extract($_POST);

$val= $obj->getlike1($post_id);
print_r($val);
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