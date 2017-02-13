<?php
session_start();
require_once('Class_Library/class_training.php');
$obj = new Training();
$clientid = $_SESSION['client_id'];
if(!empty($_POST["keyword"])) {
$keyword = $_POST["keyword"];
$empinfo = $obj->employeeinfo($clientid,$keyword);
$result = json_decode($empinfo , true);
//echo "<pre>";
//print_r($result);
if(!empty($result)) {
?>

<table border="1">
    <thead>
      <tr>
        <th>Name</th>
        <th>Employee Code</th>
        <th>Email ID</th>
		<th>Department</th>
        <th>Location</th>
      </tr>
    </thead>
	 <tbody>
      <tr>
<?php 
	$co = count($result);
	for($i=0; $i<$co; $i++)
	{
		$autoId =$result[$i]['autoId'];
		$firstName =$result[$i]['firstName'];
		$employeeCode =$result[$i]['employeeCode'];
		$emailId =$result[$i]['emailId'];
		$department =$result[$i]['department'];
		$location =$result[$i]['location'];
?>

<tr onClick="selectemployeeinfo('<?php echo $autoId; ?>','<?php echo $firstName; ?>');">

<td><?php echo $firstName; ?></td>
<td><?php echo $employeeCode; ?></td>
<td><?php echo $emailId; ?></td>
<td><?php echo $department; ?></td>
<td><?php echo $location; ?></td>

</tr>
</tbody>
<?php } ?>
</table>

<?php 
}
} 
?>