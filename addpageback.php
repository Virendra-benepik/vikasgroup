	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
<link rel="stylesheet" href="css/thought.css" />
<link rel="stylesheet" href="css/addpage.css" />
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	
	
<script>
function check() {
       if (confirm('Are You Sure, You want to publish this post?')) {
           return true;
       } else {
           return false;
       }
    }
</script>	
	
	
	
<script>
function showimagepreview1(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#pageimg').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}

$(document).ready(function(){
    $(".closeThoughtPopoUpBtn").click(function(){
        $("#addpage2DIV").hide();
    });
 $(".showpage2DivBTN").click(function(){
        $("#addpage2DIV").show();

var titlepage = $("#pagetitle").val();
var content = CKEDITOR.instances.editor1.getData();

$(".titlepage").html(titlepage);
$(".contentpage").html(content);
    });
   
});
</script>
               
			   <div class="side-body padding-top">
				

<div id="addpage2DIV">

	<button type="button"class="btn btn-danger closeThoughtPopoUpBtn">Close</button><br>
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
						
						<div class="titlepage"></div>
						<div class="imagepage"><img style="width:170px;height:150px;" src='' id="pageimg"/></div>
						<div class="contentpage"></div>
							
							
						</div>
					</div>
				</div>
				<div id="IphonePriviewTab" class="tab-pane fade">
					<div class="background_iphone_Image">
						<img src="images/i6.png"class="img img-responsive IphoneImage"/>
					</div>
					<div class="iphoneContentTab">
						<div class="wholeAndroidContentHolder">

						<div class="titlepage"></div>
						<div class="imagepage"><img style="width:170px;height:150px;" src='' id="pageimg"/></div>
						<div class="contentpage"></div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>



			<div class="bs-example">
   
	
			<div class="row Subheader" style="background-color:#dddddd;margin:1px !important;">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
				<center><h3>Create HR Policy</h3></center>
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
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			<form role="form" method="post" enctype="multipart/form-data" action="Link_Library/link_page.php" >
			<input type="hidden" name = "flag" value="2">
			<input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Page Title</label>
						<input type="text" name="pagetitle" id="pagetitle" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="Articlecontent">Select Image</label>
						<input type="file" name="pageimage" class="form-control" onchange="showimagepreview1(this)" >
					</div>
					
					<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
					   <div class="form-group">
						<label for="Articlecontent">Content</label>
						<div>
						<textarea cols="80" id="editor1" name="pagecontent" rows="10">	
	                    </textarea>
						</div>
					</div>
					<script>
		CKEDITOR.replace( 'editor1' );  
	</script>   <!--- this is for ckeditor   ----->
			   
					   
                                  <!--       <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="radio3 radio-check radio-success radio-inline">
                                            <input type="radio" id="radio5" name="selecteduser" value="Male">
                                            <label for="radio5">
                                              Send Post to All Users
                                            </label>
                                          </div>
                                          <div class="radio3 radio-check radio-warning radio-inline">
                                            <input type="radio" id="radio6" name="selecteduser" value="Female">
                                            <label for="radio6">
                                             Send Post to Selected users
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button----------------------                       
	<script type="text/javascript">
    $(function () {
     $("#show_textbox").hide();
        $("input[name='selecteduser']").click(function () {
            if ($("#radio6").is(":checked")) {
                $("#show_textbox").show();
            } else {
                $("#show_textbox").hide();
            }
        });
    });
</script>				
	  <!------------Abobe script for show textbox on select radio button----------------------
	                               <div id ="show_textbox">
	    				<div class="form-group col-sm-6" >
					<input type="text" name ="selecteduser" id="selecteduser" class="form-control" placeholder=" Choose group" />					</div>
					
					<div id="selecteditems" class="form-group col-sm-6" >
					data is here.............
					
					</div>
					
					<div id="allitems" class="form-group col-sm-12" >
					show all data here.......
					</div>
					<textarea id ="allids" style="display:none;" height="660"></textarea>
                                         <textarea id ="selectedids" name="selected_user" style="display:none;" ></textarea>
					</div> -->
					
					
				</div>
				
			</div>
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		
		<div class="publication">
		<p id="publication_heading">PUBLICATION</p><hr>
		
		<p class="publication_subheading">PUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Immediately </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button type="button" class="btn btn-default btn-xs" id="showshortcontent">ON</button>
					<button type="button" class="btn btn-primary active btn-xs"id="hideshortcontent">OFF</button>
					
				</div>
			
			</div>
		</div>
			<script>
$(document).ready(function(){
    $("#hideshortcontent").click(function(){
        $("#shortpublicationdivcontent").hide();
    });
    $("#showshortcontent").click(function(){
        $("#shortpublicationdivcontent").show();
    });
});
</script><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<div id="shortpublicationdivcontent"style="width:100% !important;">
<input type="date" placeholder="mm/dd/yyyy" style="width:100% !important;" name="publish_date1"/><br><br>
  
				<input type="time"  style="width:100% !important;" name="publish_time1"/>
				
		</div></div></div>
		
		<br>
		
		<p class="publication_subheading">UNPUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Not Scheduled </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button type="button" class="btn btn-default btn-xs"id="showshortcontent1">ON</button>
					<button type="button" class="btn btn-primary active btn-xs"id="hideshortcontent1">OFF</button>
					
				</div>
				
			</div>
		</div>
		<script>
$(document).ready(function(){
    $("#hideshortcontent1").click(function(){
        $("#shortUnpublicationdivcontent").hide();
    });
    $("#showshortcontent1").click(function(){
        $("#shortUnpublicationdivcontent").show();
    });
});
</script>
				<div id="shortUnpublicationdivcontent" >
				 <input type="date" placeholder="mm/dd/yyyy" style="width:100%;" name="publish_date2"/><br><br>
  
				<input type="time" style="width:100%;" name="publish_time2"/>
				
		</div>
		</div>
		
		<br>
		
<div class="publication"><p id="publication_heading">Options</p><hr>
			
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <p class="publication_leftcontent"style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" ></label></div>
    
  </div>
 
</div>
		
		
		</div>
		

		</div>
		<div class="form-group col-sm-12"><center>
					
<input type="button" class="btn btn-md btn-info showpage2DivBTN preview_postBtn" style="text-shadow:none;font-weight:normal;" value="Priview"  />
<input type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish Now" id="getData" onclick="return check();"  />

</center>
					</div>
		</div>
		
					
		 </form>
</div>                  
            </div>
				<?php include 'footer.php';?>