<?php
require_once('../Class_Library/class_notice.php');
if(!empty($_POST))
{ 
$obj = new Notice();
extract($_POST);

$result = $obj->updateNotice($clientid,$noticeid,$noticetitle);
if($result['success']==1)
{

$target = '../notice/';
$pagename = $target.$noticeid.".html";

if(unlink($pagename))
{
file_put_contents($target.$noticeid.".html",$noticecontent);
echo "<script>window.location='../view_Notice.php'</script>";
}
}


}
else
{
?>
<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>

<form name="form1" method="post" action="" enctype="multipart/form-data">
 <p>Client id:
  <label for="textfield"></label>
  <input type="text" name="clientid" id="textfield"> 
  </p>

 <p>Notice id:
    <label for="textfield"></label>
  <input type="text" name="noticeid" id="textfield"> 
  </p>
 
  <p> Title:
    <label for="textfield"></label>
  <input type="text" name="noticetitle" id="textfield">
  </p>
  
  <p>Notice Content:
    <label for="textfield"></label>
    <textarea cols="80" id="editor1" name="noticecontent" rows="10"></textarea>

  <p>
    <input type="submit" name="submit" id="button" value="Submit">
  </p>
</form>
<script>
		CKEDITOR.replace( 'editor1' );
</script>
<?php
}
?>
