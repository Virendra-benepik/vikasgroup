	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
<!--<link rel="stylesheet"type="text/css" href="css/thought.css" />-->
<link rel="stylesheet"type="text/css" href="css/addpage.css" />
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	
	
<script>
function showimagepreview1(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('.pageimg').attr('src', e.target.result);
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
				<div class="row mobile_articals"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i><font class="white_color"></font></div>

<div id="addpage2DIV">

	<button type="button"class="btn btn-gray closeThoughtPopoUpBtn" id="close_news_priview"style="margin-left:268px;margin-top:5px;">X</button><br><br><br><br><br>
	<div class="row">
	
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div class="">
				<div id="" class=""> 
					<div class="">
						<img src="images/mobile.jpg"class="img img-responsive " style="height: 544px;width:221px;margin-top:-103px;margin-left:37px;;
    width: 221px ! important;
    margin-top: -125px;"/>
					</div>
					<div class="androidContentTab">
						<div class="wholeAndroidContentHolder">

<div class="row" style="background-color: #5cb85c;
    margin: 0px;
    height: 32px;border: 1px solid #5cb85c;">

<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12" ><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i><font style="color:white;">&nbsp;Article</font><!--<span class="glyphicon glyphicon-folder-open"></span>--></div></div>


<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
<div class="titlepage"></div>
</div></div>


<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
<div class="contentpage"  style="overflow-y:scroll;margin-top:0px;height:205px;"></div>		<div class="row"style="margin:0px;padding-top: 14px;">
                    <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 "><font style="font-size:10px;">0 Likes</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><font style="font-size:10px;">Like</font></button> </div>
                    <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 "><font style="font-size:10px;"> 0 Comments</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-commenting-o" aria-hidden="true"></i><font style="font-size:10px;">Comments</font></button></div
                    <hr style="height:1px;background-color:gray;width:92%;">
                </div>
               

            </div>								
</div>
</div>	
						</div>
					</div>
				</div>
				<div id="IphonePriviewTab" class="tab-pane fade">
					<div class="background_iphone_Image">
						<img src="images/i6.png"class="img img-responsive IphoneImage"/>
					</div>
					<div class="iphoneContentTab">
						<div class="wholeIOSContentHolder">

						
<div class="row">

<div class="col-xs-3 col-md-3 col-lg-2 col-sm-2"><!--<span class="glyphicon glyphicon-folder-open"></span>--></div>
<div class="col-xs-9 col-md-9 col-lg-9 col-sm-9">
<div class="titlepage"></div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
<div class="contentpage"></div>										
</div>
</div>		

							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>



			<div class="bs-example">
   
	<div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3><strong>Create HR Policy</strong></h3><hr>
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
			<input style="color:#2d2a3b;" type="hidden" name = "flag" value="2">
			<input style="color:#2d2a3b;" type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Page Title</label>
						<input style="color:#2d2a3b;" type="text" name="pagetitle" id="pagetitle" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="Articlecontent">Select Image(resolution 720*720)</label>
						<input style="color:#2d2a3b;" type="file" name="pageimage" accept="image/*" class="form-control" onchange="showimagepreview1(this)" >
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
	</script>
					<div class="form-group col-sm-12"><center>
					
<input style="color:#2d2a3b;" type="button" class="btn btn-md btn-info showpage2DivBTN preview_postBtn" style="text-shadow:none;font-weight:normal;" value="Priview"  />
<input style="color:#2d2a3b;" type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish" id="getData" />

</center>
					</div>
					
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
				<p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Immediately ?</p>
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
<input type="date" placeholder="YYYY-MM-DD" style="width:100% !important;" name="publish_date1"/><br><br>
  
				<input type="time" style="width:100% !important;" name="publish_time1"/>
				
		</div></div></div>
		
		<br>
		
		<p class="publication_subheading">UNPUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Not Scheduled ?</p>
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
				 <input style="color:#2d2a3b;" type="date" placeholder="YYYY-MM-DD" style="width:100%;" name="publish_date2"/><br><br>
  
				<input style="color:#2d2a3b;" type="time" style="width:100%;" name="publish_time2"/>
				
		</div>
		</div>
		
		<br>
	<!--	
<div class="publication"><p id="publication_heading">Options</p><hr>
		
			
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "id="rightpublicationdiv6 ">
    <p class="publication_leftcontent " data-toggle="tooltip" data-placement="left"  title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input  style="color:#2d2a3b;"type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>
    
  </div>
 
</div>
		
		
		</div>-->
		

		</div>
		</div>
					
		 </form>
</div>                  
            </div>
			</div>
			
			                <!--this script is use for tooltip genrate-->     
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
   <!--tooltip script end here-->
				<?php include 'footer.php';?>