<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';
require_once('Class_Library/class_user_profile.php');
?>
<div class="container-fluid">
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<div class="container">
<?php 
$path = "http://admin.benepik.com/employee/virendra/benepik_admin/";

$idclient = $_SESSION['client_id'];
$iduser = $_SESSION['user_session'];

$obj = new Profile();
$result = $obj->getuserprofile($idclient,$iduser);
$getcat = json_decode($result,true);

$fullpath = $path.$getcat[0]['userImage'];
?>
				<div class="row"style="box-shadow:-1px 1px 5px 2px #888888;padding:20px;">
				
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"> 
						<img src="<?php echo $fullpath; ?>"style="width:140px;height:150px;"/>
					</div>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">  
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h4 id="mynameAttributes">
								<?php
								//echo $getcat;
								 echo $_SESSION['user_name'] ." [". $_SESSION['client_name'] ."]"?></h4><hr>
							</div>
							
						</div>
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3"> 
								<p><b>Full Name</b></p>
							</div>
							<div class="col-xs-8 col-sm-9 col-md-9 col-lg-9"> 
									<p> <?php 
$nam = $getcat[0]['firstName'];
echo trim($nam);
 ?></p>
							</div>
					
						</div>
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3"> 
								<p><b> Contact</b></p>
							</div>
							<div class="col-xs-8 col-sm-9 col-md-9 col-lg-9"> 
									<p><?php echo $getcat[0]['contact']; ?></p>
							</div>
					
						</div>
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3"> 
								<p><b>Department</b></p>
							</div>
							<div class="col-xs-8 col-sm-9 col-md-9 col-lg-9"> 
									<p><?php 
$cont = $getcat[0]['department'];
echo trim($cont);
?></p>
							</div>
					
						</div>
						
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 col-lg-3"> 
								<p><b>Designation</b></p>
							</div>
							<div class="col-xs-8 col-sm-9 col-md-9 col-lg-9"> 
								<p><?php 
$cont = $getcat[0]['designation'];
echo trim($cont);
?></p>
							</div>
					
						</div>
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
								<p><button type="button"class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalprofilePopUp"><span class="glyphicon glyphicon-edit"></span>Edit</button></p>
								
							</div>
				</div>
				</div>
				
​
<div class="container">
​
  <!-- Modal -->
  <div class="modal fade" id="myModalprofilePopUp" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <div class="modal-body">

			<form role="form" method="post" action="Link_Library/link_update_client.php" enctype="multipart/form-data">
				<div class="row">
					<div class="col-xs-6 col-sm-3 col-md-6 col-lg-6">
						<div class="form-group">
							<script type="text/javascript">
function showimagepreview(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw1').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}
</script>

<img id="imgprvw1" alt="uploaded image preview" src="<?php echo $path.$getcat[0]['userImage'];?>"/>
<div>
<input type="hidden" name="image_name" value="<?php echo $name; ?>" />
<!--<input type="file" name="clientimage" id="textfield" onchange="showimagepreview(this)" value="<?php echo $name; ?>" />-->

</div>
						</div>
					</div>
					<div class="col-xs-9 col-sm-9 col-md-6 col-lg-6"> 
					<input type="hidden" name="userid" value="<?php echo $_SESSION['user_session']; ?>">
					<input type="hidden" name="clientid" value="<?php echo $_SESSION['client_id']; ?>">
						<div class="form-group">
						<label for="user">Full Name </label>
							<div class="inner-addon left-addon">
								<i class="glyphicon glyphicon-user"></i>
								<input type="text" name="name" class="form-control" placeholder="Enter Full Name" value="<?php 
$nam = $getcat[0]['firstName'];
echo trim($nam);
 ?>"/>
							</div>
						</div>
						<div class="form-group">
						<!--<label for="user">Password</label>
							<div class="inner-addon left-addon">
								<i class="glyphicon glyphicon-user"></i>
								<input type="password" name="password" class="form-control" placeholder="Enter Full Name" value="<?php 
$pass = $getcat[0]['password'];
echo trim($pass);
 ?>"/>
						</div>-->
						</div>
						<div class="form-group">
						<label for="user">Mobile Number </label>
							<div class="inner-addon left-addon">
								<i class="glyphicon glyphicon-earphone"></i>
								<input type="text" class="form-control" name="mobile" placeholder="Contact Number" value="<?php 
$cont = $getcat[0]['contact'];
echo trim($cont);
?>"/>
							</div>
						</div>
						
						<div class="form-group">
						<label for="user">Department </label>
							<div class="inner-addon left-addon">
								<i class="glyphicon glyphicon-user"></i>
								<input type="text" name="depart" class="form-control" placeholder="Enter Full Name" value="<?php
$depart = $getcat[0]['department'];
echo trim($depart);
 ?>"/>
							</div>
						</div>
						
						<div class="form-group">
						<label for="user">Designation </label>
							<div class="inner-addon left-addon">
								<i class="glyphicon glyphicon-user"></i>
								<input type="text" name="desig" class="form-control" placeholder="Enter Full Name" value="<?php
$desig = $getcat[0]['designation'];
echo trim($desig);
 ?>"/>
							</div>
						</div>
						
						
					</div>
					
				</div>
				<center><input type="submit"class="btn btn-primary glyphicon glyphicon-floppy-save" 
				 value="Submit" /></center>
			
			</form>
		 
		 
		 
        </div>
       
      </div>
      
    </div>
  </div>
  
</div>
			</div>

</div>
<?php include 'footer.php';?>