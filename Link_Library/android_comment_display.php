<?php
require_once('../Class_Library/class_comment.php');

if(!empty($_POST))
{ 
$obj = new Comment();

extract($_POST);

$result = $obj->Comment_display($post);
echo $result;
  /*if(isset($result) && $result == 'True')
  {
  echo "<script>alert('successfully commented')</script>";
  }*/
	//$response["message"] = $result;
	//echo json_encode($response);
}
else
{
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">

  
<p>Post_id:
  <label for="textfield"></label>
  <input type="text" name="post" id="textfield">
</p>

   <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<?php
}
?>