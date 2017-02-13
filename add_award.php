<!-----
created by : - monika gupta
created date :- 26/10/2016
description :- It is create for design create award form . 
------>

<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	
<link rel="stylesheet" href="css/thought.css" />
<link rel="stylesheet" href="css/createNotice.css" />
<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="angularjs/updateGroup1.js"></script>
<script src="js/display_group.js"></script>
<!-------------------------------SCRIPT END FROM HERE   --------->	
<script>
function check() {
       if (confirm('Are You Sure, You want to Create this Award?')) {
           return true;
       } else {
           return false;
       }
    }
</script>
	
<script>
$(document).ready(function(){
    $(".closeThoughtPopoUpBtn").click(function(){
        $("#createNoticeDiv").hide();
    });
    $("#createNoticePubliceBtn").click(function(){

var title = $("#titlenotice").val();
var content = CKEDITOR.instances.editor1.getData();

$(".noticecontent").html(content);
$(".noticetitle").html(title);

        $("#createNoticeDiv").show();
    });
});
</script>

<div id="createNoticeDiv">

<button type="button"class="btn closeBtn closeThoughtPopoUpBtn">Close</button><br>
	<div class="row">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="nav nav-tabs Mynav">
				<p class="active"id="AndroidText"><a data-toggle="tab" href="#AndoidPriviewTab">Andoid</a><br></p>
				<p id="iphoneText"><a data-toggle="tab" href="#IphonePriviewTab">Iphone</a><br></p>
			</div>
		</div>
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div class="tab-content mytabContent">
				<div id="AndoidPriviewTab" class="tab-pane fade in active">  
					<div class="background_Android_Image">
						<img src="images/sam3.png"class="img img-responsive androidImage"/>
					</div>
					<div class="androidContentTab">
						<div class="wholeAndroidContentHolder">
						
					<div class="noticetitle"></div>
					<div class="noticecontent"></div>		
							
						</div>
					</div>
				</div>
				<div id="IphonePriviewTab" class="tab-pane fade">
					<div class="background_iphone_Image">
						<img src="images/i6.png"class="img img-responsive IphoneImage"/>
					</div>
					<div class="iphoneContentTab">
						<div class="wholeIOSContentHolder">
						
					<div class="noticetitle"></div>
					<div class="noticecontent"></div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

               
			<div class="side-body padding-top">
			<div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:-5px;">
			<div class="bs-example">
   
	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
				 <h3><strong>Create Award</strong></h3><hr>
				<?php 
				if(isset($_SESSION['msg']))
				{
				echo $_SESSION['msg'];
				}
				?>
				
				</div>

			</div>
	<br>
	
	<?php
	unset($_SESSION['msg']);
	?>
	
<!------------------------------------------message portal start from here------------------------------------------------>	
 <div class="row">
 <form role="form" method="post" action="Link_Library/link_add_award.php" enctype="multipart/form-data">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			
			<input type="hidden" name = "flag" value="13">
			<input type="hidden" name="uniqueuserid" value="<?php echo $_SESSION['user_unique_id']; ?>"/>
			<input type="hidden" name = "flagvalue" value="award : ">	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Award Name</label>
						<input style="color:#2d2a3b;" type="text" name="award_name" id="titlenotice" class="form-control" required>
					</div>

					<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
					   <div class="form-group">
							<label for="Articlecontent">Description</label>
								<div>
								<textarea cols="80" id="editor1" name="award_description" rows="10" required>	
								</textarea>
								</div>
					   </div>
					<script>
					CKEDITOR.replace( 'editor1' );  
					</script>   <!--- this is for ckeditor   ----->
 
				</div>
				
			</div>
	
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
		
		
		
<div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">

<div class="publication">
<!---------------------------------------------------------------------->

 <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style = "padding: 10% 10% 10% 10%;">
     
<label for="Article image">UPLOAD IMAGE</label>
        
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>

<script type="text/javascript">
function showimagepreview1(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw').attr('src', e.target.result);
$('.post_img').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}
</script>
<img id="imgprvw" alt="uploaded image preview"/>
<div>
<input type="file" id="uploadimage" name="uploadimage" onchange="showimagepreview1(this)" required/>
</div>

      
</div>
</div>
</div>
</div>



	
		<div class="form-group col-sm-12">
		<center><input type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Save Award" id="getData" onclick= "return check();" />
		</center>
		</div>
		
		
		
		</form>
		</div>
					
	
</div>
                   
           
            
            <!--this script is use for tooltip genrate-->     

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</div>
 </div>

   <!--tooltip script end here--> 
				<?php include 'footer.php';?>