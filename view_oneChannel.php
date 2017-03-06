<?php include 'navigationbar.php';?>
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
print_r($value);
$getcat = $value['posts'][0];

?>

<div style="width: 80%;height: auto;margin: 100px 100px;border: 1px solid #ccc;padding: 25px 50px;">
<div style="background: #DDD;padding: 1px 15px;border-radius: 20px;">
<?php echo "<h2>".ucfirst($getcat['groupName'])."</h2>"; ?>
</div>
<p style="margin: 25px 0px;font-weight: 600;font-size: 16px;">About Group</p>
<div style="width: 100%;height: 150px;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;">
<?php echo "<p>".$getcat['groupDescription']."</p><br>";?>
</div>
<p style="margin: 25px 0px;font-weight: 600;font-size: 16px;">Group Admin Name</p>
<div style="width: 100%;height: 150px;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;margin: 10px 0px;">
<?php
$admindetails = $getcat['adminEmails'];
$count = count($admindetails);

for($i=0;$i<$count;$i++)
{
echo $admindetails[$i]['adminEmail']."<br>";
}
?>
</div>
<div style="width: 100%;height: 150px;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;margin: 10px 0px;">
<div style="width: 30%;height: auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;float:left">
<h6>LOCATIONS</h6><hr>
<?php
$value = $getcat['locations'];
$count = count($value);

for($i=0;$i<$count;$i++)
{
echo $value[$i]['columnValue']."<br>";
}
?>
</div>
<div style="width: 30%;height: auto;border: 1px solid #ccc;padding: 10px 20px;font-size: 16px;float:left">
<h6>DEPARTMENTS</h6><hr>
<?php
$value = $getcat['departments'];
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