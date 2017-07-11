	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<script>
    function check() {
        if (confirm('Are You Sure, You want to create this custom group?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
function Validatecustomgroup()
{
    var group_title = document.form1.group_title;
	var cgroup_csv_file = document.form1.cgroup_csv_file;
    	
    if (group_title.value == "")
    {
        window.alert("Please Enter Group Name.");
        group_title.focus();
        return false;
    }
	if (cgroup_csv_file.value == "")
    {
        window.alert("Please Upload CSV File.");
        cgroup_csv_file.focus();
        return false;
    }
	return true;
}
</script>   
	<!-------------------------------SCRIPT END FROM HERE   --------->	
	             
<div  class="side-body padding-top">
	<div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
		<div class="bs-example">
            <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3>Create Custom Group</h3><hr>
				</div>

			</div>
	
			<div class="row">
				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
						<form role="form" name="form1" method="post" action="Link_Library/link_customgroup.php" enctype="multipart/form-data" onsubmit="return check();">
							<input type="hidden" name = "uuid" value="<?php echo $_SESSION['user_unique_id']; ?>">
							<input type="hidden"  name = "clientid" value="<?php echo $_SESSION['client_id']; ?>">
							<div class="row">
								<div class="form-group col-sm-6">
									<label for="exampleInputPassword1">Group Name</label>
									<input type="text" name="group_title" class="form-control" id="group_title" placeholder="Group Name">
								</div>
								
								<div class="form-group col-sm-6">
									<label for="exampleInputEmail1">About Group</label>
									<textarea cols="10" id="groupdesc" name="groupdesc" class="form-control"  rows="1"></textarea>
								</div>
							</div>
							<div class="row" style="margin-top:10px;margin-bottom:10px;">
								<div class="form-group col-sm-6">
									<label for="exampleInputEmail1">Upload CSV</label>
									<input style="color:#2d2a3b;" class="text-center" accept=".csv" name="cgroup_csv_file" type="file" id="cgroup_csv_file">
								</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
									<a style="font-size: 16px;text-decoration: underline;float:right;" href="demoCSVfile/customgroupdemoCSVformat.csv">Download CSV file format</a>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-12">
									<input type="submit" name ="customgroup" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Create Custom Group" id="getData" onclick="return Validatecustomgroup();" />
								</div>
							</div>
						</form>
					
				</div>
			</div>
		</div>		
	</div>
</div>
<?php include 'footer.php';?>