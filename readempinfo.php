<!-----------
Created BY - Monika Gupta
Created Date - 26/10/2016
description : create for fetch employee information using ajax from database .
----------->
<?php
session_start();
require_once('Class_Library/class_award.php');
$obj = new award();
$clientid = $_SESSION['client_id'];
if(!empty($_POST["keyword"])) {
$keyword = $_POST["keyword"];
$empinfo = $obj->employeeinfo($clientid,$keyword);
$result = json_decode($empinfo , true);
//echo $empinfo;
//echo "<pre>";
//print_r($result);
//echo $co = count($result["Data"]);
//die;
if(!empty($result)) {
?>
<!--<ul id="employee_list">
-->

<table class="table table-striped">
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
$co = count($result["Data"]);
for($i=0; $i<$co; $i++)
{
?>

<tr onClick="selectemployeeinfo('<?php echo $result["Data"][$i]["autoId"]; ?>','<?php echo $result["Data"][$i]["firstName"]; ?>');">

<td><?php echo $result["Data"][$i]["firstName"]; ?></td>
<td><?php echo $result["Data"][$i]["employeeCode"]; ?></td>
<td><?php echo $result["Data"][$i]["emailId"]; ?></td>
<td><?php echo $result["Data"][$i]["department"]; ?></td>
<td><?php echo $result["Data"][$i]["location"]; ?></td>

</tr>
</tbody>
<?php } ?>
</table>

<!--</ul>-->
<?php } } ?>