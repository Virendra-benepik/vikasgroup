<?php
session_start();
require_once('../Class_Library/class_training.php');

if(!empty($_POST))
{ 
$obj = new Training();

date_default_timezone_set('Asia/Calcutta');
$createddate = date('Y-m-d H:i:s');
$status = 1;
$clientid = $_POST['clientId'];
$useruniqueid= $_POST['useruniqueid'];
$trainingname = $_POST['trainingName'];
$trainingdescription = $_POST['trainingDescription'];

$addtraining = $obj->addTrainingDetails($clientid,$useruniqueid,$trainingname,$trainingdescription,$createddate,$status);
$result = json_decode($addtraining, true);
//echo "<pre>";
//print_r($result);
	if($result['success'] == 1)
	{
	echo "<script>alert('Learning Details Add Successfully')</script>";
	echo "<script>window.location='../addLearning.php'</script>";
	}
}
else
{
?>
<form action="" method="post">
<input type="hidden" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
<input type="hidden" name="clientId" value="<?php echo $_SESSION['client_id']; ?>">
Training Name:
<br/>
<input type="text" name="trainingName" placeholder="Enter Training Name">
<br/>
<br/>
Training Description:
<br/>
<textarea name="trainingDescription" placeholder="Enter Training Description">
</textarea>
<br/>
<br/>
<input type="submit" value="Save" name="addtrainingdetails">
</form>
<?php
}
?>