<?php   include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
<?php 
require_once('Class_Library/class_get_group.php');
?>

<?php 

$obj = new Group();

$clientid =$_GET["clientid"];
$groupid = $_GET["groupid"];

$result = $obj->getGroupDetails($clientid,$groupid);

$value = json_decode($result, TRUE);
//echo "<pre>";
//print_r($value);
$getcat = $value['posts'][0];

?>

<div style="width: 80%;height: auto;margin: 100px 100px;border: 1px solid #ccc;padding: 25px 50px;">
<div style="background: #DDD;padding: 1px 15px;border-radius: 20px;">
<?php echo "<h2>".ucfirst($getcat['groupName'])."</h2>"; ?>
</div>
<p style="margin: 25px 0px;font-weight: 600;font-size: 16px;">About Group</p>
<div style="width: 100%;max-height: 150px;overflow-y:auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;">
<?php echo "<p>".$getcat['groupDescription']."</p><br>";?>
</div>
<p style="margin: 25px 0px;font-weight: 600;font-size: 16px;">Group Admin Name</p>
<div style="width: 100%;max-height: 150px;overflow-y:auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;margin: 10px 0px;">
<?php
$admindetails = $getcat['adminEmails'];
$count = count($admindetails);

for($i=0;$i<$count;$i++)
{
echo $admindetails[$i]['adminEmail']."<br>";
}
?>
</div>
<div style="height: 200px;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;margin: 10px 0px;" class="row">
<div style="max-height: 175px; overflow-y:auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;float:left" class="col-md-3">
<h6>Company Name</h6><hr>
<?php
$value = $getcat['companyName'];
$count = count($value);

for($i=0;$i<$count;$i++)
{
echo $value[$i]['columnValue']."<br>";
}
?>
</div>
<div style="max-height: 175px; overflow-y:auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;float:left"class="col-md-3">
<h6>Location</h6><hr>
<?php
$value = $getcat['location'];
$count = count($value);

for($i=0;$i<$count;$i++)
{
echo $value[$i]['columnValue']."<br>";
}
?>
</div>
    <div style="max-height: 175px; overflow-y:auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;float:left"class="col-md-3">
<h6>Department</h6><hr>
<?php
$value = $getcat['department'];
$count = count($value);

for($i=0;$i<$count;$i++)
{
echo $value[$i]['columnValue']."<br>";
}
?>
</div>
    <div class="col-md-3" style="max-height: 175px; overflow-y:auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;float:left">
<h6>Grade</h6><hr>
<?php
$value = $getcat['grade'];
$count = count($value);

for($i=0;$i<$count;$i++)
{
echo $value[$i]['columnValue']."<br>";
}
?>
</div>
</div>
</div>

<?php include 'footer.php';?>