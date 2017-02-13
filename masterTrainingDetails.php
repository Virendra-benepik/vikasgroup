<?php
session_start();
//print_r($_SESSION);
?>
<form action="Link_Library/link_TrainingDetails.php" method="post">
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