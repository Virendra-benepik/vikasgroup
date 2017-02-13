<?php
require_once('../Class_Library/class_welcome_analytic.php');

if(!empty($_POST))
{ 

$obj = new WelcomeAnalytic();

extract($_POST);

$val= $obj->getLastThreeComment($post_id);
print_r($val);

/*$getcat= $value->{'posts'};

for($i=0;$i<count($getcat);$i++)
{
echo $getcat[$i]->{'ptitle'}."&nbsp;&nbsp;&nbsp;";
?>
<img src="http://admin.benepik.com/employee/virendra/benepik_client/<?php echo $getcat[$i]->{'pimg'} ; ?>" />
<?php
echo $getcat[$i]->{'pcontent'}."&nbsp;&nbsp;&nbsp;";
echo $getcat[$i]->{'cdate'}."&nbsp;&nbsp;&nbsp;"."<br>";
}*/

}
else
{
?>
<form name="form1" method="post" action="one_post_display.php" enctype="multipart/form-data">
<p>
POST id<br>
<input type="text" name="post_id" />
</p>  
<p>
    <input type="submit" name="submit" id="button" value="Click to Display Post Details">
  </p>
</form>
<?php
}
?>