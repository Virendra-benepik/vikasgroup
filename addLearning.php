<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             


<?php
session_start();
//print_r($_SESSION);
?>


<div class="container" style="margin-top:80px;border:1px solid #cdcdcd;">
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h3><strong>Add Certificate</strong></h3><hr>
</div>
	</div>
  <form action="Link_Library/link_TrainingDetails.php" method="post">
  <input type="hidden" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
<input type="hidden" name="clientId" value="<?php echo $_SESSION['client_id']; ?>">

    <div class="form-group">
      <label for="learningName">Certificate Name:</label>
      <input style="color:#2d2a3b;" type="text" required name="trainingName" placeholder="Enter Certificate Name" class="form-control">
    </div>
    <div class="form-group">
      <label for="learningDescription">Certificate Description:</label>
      <textarea style="color:#2d2a3b;" required name="trainingDescription" placeholder="Enter Certificate Description" class="form-control" rows="5"></textarea>

    </div>
    
   <button type="submit" class="btn btn-primary" name="addtrainingdetails" style="margin-bottom:50px;">Submit</button>
  </form>
  </div>

 <?php include 'footer.php';?>
