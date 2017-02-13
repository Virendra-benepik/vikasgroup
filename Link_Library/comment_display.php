<?php
require_once('class_comment.php');

if(!empty($_POST))
{ 

$obj = new Comment();

extract($_POST);

$val = $obj->getcommentdetails($post);
print_r($val);
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
Post id<br>
<input type="text" name="post" id="post" /><br>
<p>
    <input type="submit" name="submit" id="button" value="Click to Display Post Details">
  </p>
</form>
<?php
}
?>