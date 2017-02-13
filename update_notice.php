	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_update_distict_location.js"></script>
<script>

function check() 
{

        if (confirm('Are You Sure, You want to send this notice to all locations ?')) 
       {
           return true;
       } else {
           return false;
       }
}
</script>

	<!-------------------------------SCRIPT END FROM HERE   --------->	
	
               
			   <div class="side-body padding-top">
				<div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
			<div class="bs-example">
   
	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
				<h3><strong>Update Notice</strong></h3><hr>
				<?php 
				if(isset($_SESSION['msg']))
				{
				echo $_SESSION['msg'];
				}

        require_once('Class_Library/class_getNotice.php');
	$pageobj = new GetNotice();

        $clientid = $_SESSION['client_id'];
	$noticeid = $_GET['noticeid'];

	$result1 = $pageobj->getSingleNotice($noticeid,$clientid);
	$result = json_decode($result1, true);

        $path =  $result['posts'][0]['fileName'];
        $counts = count($result);
         

				?>
				
				</div>

			</div>
	<br>
	
	<?php
	unset($_SESSION['msg']);
	?>
	
<!------------------------------------------message portal start from here------------------------------------------------>	
 <div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			<form role="form" method="post" action="Link_Library/link_update_notice.php" >
			<input style="color:#2d2a3b;" type="hidden" name = "flag" value="2">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Title</label>
<input style="color:#2d2a3b;" type="hidden" name ="clientid" value="<?php echo $_SESSION['client_id']; ?>">
<input style="color:#2d2a3b;" type="hidden" name ="noticeid" value="<?php echo $_GET['noticeid']; ?>">
						<input style="color:#2d2a3b;" type="text" name="noticetitle" class="form-control" value="<?php echo $result['posts'][0]['noticeTitle']; ?>">
					</div>
					
					
					<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
					   <div class="form-group">
						<label for="Articlecontent">Content</label>
						<div>
						<textarea style="color:#2d2a3b;" cols="80" id="editor1" name="noticecontent" rows="10">
<?php echo file_get_contents($path); ?>	
	                    </textarea>
						</div>
					</div>
					<script>
		CKEDITOR.replace( 'editor1' );  
	</script>   <!--- this is for ckeditor   ----->
			   
   <div class="form-group col-sm-12">
<input style="color:#2d2a3b;"type="submit" name="update_notice" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Update Notice"/>
  </div>	
			     </div>
				</form>
			    </div>
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		
		<br>
		</div>
		</div>
					
		
</div>
                   
            </div>
			</div>
				<?php include 'footer.php';?>