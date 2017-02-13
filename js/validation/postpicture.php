	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
		<?php  require_once('Class_Library/class_fetch_group.php');
		$obj = new GetGroup();
		 ?>
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet"type="text/css"href="css/post_picture.css"/>

<script src="js/display_group.js"></script>
<script src="js/validation/createPostValidation.js"></script>
<script>
function check() {
       if (confirm('Are You Sure, You want to publish this post?')) {
           return true;
       } else {
           return false;
       }
    }
</script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	

<script>
$(document).ready(function(){

$("#preview_post").click(function(){

var mesg = $("#content").val();
$("#testpopup").css({"display":"block"});
$(".contentPost").html(mesg);

$("#Iphone5").click(function(){
$("#rightoneIphone6").css({"z-index":0});
$("#rightoneIphone5").css({"z-index":1});
});
$("#Iphone6").click(function(){
$("#rightoneIphone5").css({"z-index":0});
$("#rightoneIphone6").css({"z-index":1});
});

});
});
</script>

<script>
$(document).ready(function(){
    $("#close_news_priview").click(function(){
        $("#testpopup").hide();
    });
    
});
</script>
<div id="testpopup" style="background-color:#ffffff !important;    box-shadow: 1px 1px 5px 1px #888888;margin-top:28px;">




<!--*********************************rajesh*******************************************-->

	<div style="width: 222px;
    height: 547px;
    background-image: url('images/mobile.jpg');
    background-size: 100% 100%;
    padding-top: 64px;
    padding-left: 20px;
    margin-left: 39px;
    margin-top: 6px;">
	<button  id="close_news_priview" type="button"class="btn btn-gray" style="    margin-left: 221px;
    margin-top: -64px;">X</button><br><br>
		<div style="    width: 182px;    height: 349px;background-color:white;"> 
		
		<div class="row">
<div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
<div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview">HR Name</p><p id="Date_newsPriview">Date: 12/09/2016</sub> </div>

</div>

<div class="imagePost"><img class="post_img" /></div>
<div class="titlePost"></div>
<div class="contentPost" style="overflow-y:scroll;height:200px;"></div>
<div class="row"style="margin:0px">
<div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Like /  Commnets      </div>
<div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
<hr style="height:1px;background-color:gray;width:92%;">
</div>

		
		</div>
	
	
	
	</div>



<!--*********************************rajesh*******************************************-->




<!--
<div id="leftone">
<p style=" margin-top: 10px; font-size: 19px;margin-left: 24Px;border-bottom:1px dotted gray;"><span class="glyphicon glyphicon-phone" id="Iphone6"> Android</span></p>
<p style="margin-top: 10px; font-size: 19px;margin-left: 24Px;border-bottom:1px dotted gray;"><span class="glyphicon glyphicon-phone" id="Iphone5"> iphone</span></p>


</div>-->
<!--<div id="rightoneIphone5">


<div id="inneriphone5">


<!--<div class="row">
<div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
<div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview">HR Name</p><p id="Date_newsPriview">Date</sub> </div>
</div>-->
<!--
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <div class="titlePost"></div>   </div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
<div class="contentPost PriviewcontentDiscription"></div>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
<img class="post_img"class="img img-responsive" />
</div>
</div>




<div class="row"style="margin:0px">
<div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Like /  Commnets      </div>
<div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
<hr style="height:1px;background-color:gray;width:92%;">
</div>


</div>



</div>-->
<!--
<div id="rightoneIphone6" style="background-color:green;">

<div id="iphone6">



</div>

<div class="iphoneSubParentDiv">
<div class="row">
<div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
<div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview">HR Name</p><p id="Date_newsPriview">Date</sub> </div>

</div>

<div class="imagePost"><img class="post_img" /></div>
<div class="titlePost"></div>
<div class="contentPost"></div>
<div class="row"style="margin:0px">
<div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Like /  Commnets      </div>
<div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
<hr style="height:1px;background-color:gray;width:92%;">
</div>

</div>
</div>-->

</div>
			   <div class="side-body padding-top">
				 <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
			<div class="bs-example">
   
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3><strong>Post Picture</strong></h3><hr>
				</div>
<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" style="margin-bottom:6px;">


<!-- Trigger the modal with a button -->

 <style>
  #tableftiphonePriview:hover{background-color:#d6d6c2;color:red;}
  #tableftiphonePriview a:hover{color:#ffffff;}
  #tableftiphonePriview{padding:10px;border-bottom:1px dotted gray;}
  </style>
<!--************************pop up start for live privie iphones output****************************** -->
<div id="IphoneLivePriviewModel" class="modal fade" role="dialog">
  <div class="modal-dialog"style="width:60%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       
<br>
<br>
<div class="row">
<div class="col-xs-3">

<div class="row">
<div class="col-xs-12"> <!-- required for floating -->
  <!-- Nav tabs -->
  <div class="nav nav-tabs tabs-left"style="border:none;background:#ffffff !important;"><!-- 'tabs-right' for right tabs -->
    <p class="active" id="tableftiphonePriview"><a href="#iphone5Priview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> iPhone 5</a></p>
    <p id="tableftiphonePriview"><a href="#iphone6Priview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> iPhone 6</a></p>
    <p id="tableftiphonePriview"><a href="#iphone6PlushPriview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> iPhone 6 Plush</a></p>
    <p id="tableftiphonePriview"><a href="#androidPriview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> Android </a></p>
  </div>
</div>
</div>
</div>

<div class="col-xs-9">
<div class="col-xs-12">
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active" id="iphone5Priview">
	  <h1 style="margin-top:-12%;">iPhone 5</h1><br><br><br><br>
	   <iframe src="http://admin.benepik.com/employee/virendra/www/picture_priview.html" style="width:320px; height:491px ;border:1 px solid #000000 ;position:absolute;">
 
        </iframe>
        <img src="img/iphone.png"style="width:351px;height:592px;margin-top:-58px;margin-left:-14px;"/>
		
	  </div>
      <div class="tab-pane" id="iphone6Priview">
 <h1 style="margin-top:-12%;">iPhone 6</h1><br><br><br><br>
	  <iframe src="http://admin.benepik.com/employee/virendra/www/picture_priview.html" style="width:375px ; height:667px ;border:1 px solid #000000 ;position:absolute;">
 
        </iframe>
        <img src="img/iphone.png"style="width:408px;height:795px;margin-top:-73px;margin-left:-14px;"/>
        </div>
		
		
		
		
      <div class="tab-pane" id="iphone6PlushPriview">
 <h1 style="margin-top:-12%;">iPhone Plush</h1><br><br><br><br>
	   <iframe src="http://admin.benepik.com/employee/virendra/www/picture_priview.html" style="width:414px ; height:736px ;border:1 px solid #000000 ;position:absolute;">
 
        </iframe>
        <img src="img/iphone.png"style="width:452px;height:878px;margin-top:-81px;margin-left:-17px;"/>
	  </div>
	  
	  
	  
	  
      <div class="tab-pane" id="androidPriview">
<h1 style="margin-top:-12%;">Android Phone</h1><br><br><br><br>
	   <iframe src="http://admin.benepik.com/employee/virendra/www/picture_priview.html" style="width:315px ;margin-left:18px; height:450px ;border:1 px solid #000000 ;position:absolute;">
 
        </iframe>
        <img src="images/motoe.jpg"style="width:381px;height:592px;margin-top:-57px;margin-left:-14px;"/>

	  </div>
    </div>
</div>
</div>
</div>
		
      </div>
      
    </div>

  </div>
</div>

<!--************************pop up end for live privie iphones output****************************** -->





</div>
			</div>
	<br>
	
			
			<div ng-app="" class="row">
			<form role="form" name="postpictureform" action="Link_Library/link_post_picture.php" method="post" enctype="multipart/form-data" onsubmit="return check()">
						<input type="hidden" name = "flag" value="3">
						<input type="hidden" name = "flagvalue" value="Picture">
						 <input type="hidden" name = "device" value="d2">
	<input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">	
	 <input type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			
	<!----------------------------------- form picture post staryt here ------------------------------------------>		
			<div class="row">
				<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
					<div class="form-group">
						<label for="Articlecontent">GALLERY IMAGE</label><br>
						
						
			
<script type="text/javascript">
function showimagepreview(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw1').attr('src', e.target.result);
$('.post_img').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}
</script>
<img id="imgprvw1" alt="uploaded image preview"style="margin-bottom:5px;"/>
<div>
<input type="file" name="uploadimage" id="filUpload" accept="images/*" onchange="showimagepreview(this)" multiple="true" />
</div>

					</div>
				</div>
			
				<div class="col-lg-7 col-sm-7 col-md-7 col-xs-7">
				<div class="form-group">
						<label for="Articlecontent">DESCRIPTION</label>
				<textarea class="form-control" name="content" id="content" rows="7" placeholder="Choose a caption for this image..." ></textarea>
				</div>
				</div>
				
				  <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="col-md-4">
                                            <input type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                                            <label for="radio5">
                                             Send Post to All Groups
                                            </label>
                                          </div>
                                          <div class="col-md-4">
                                            <input type="radio" id="user" name="user3" ng-model="content" value="Selected">
                                            <label for="radio6">
                                             Send Post to Selected Groups
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button---------------------->                        
					
	  <!------------Abobe script for show textbox on select radio button---------------------->
	                      
	                              <div id ="everything" ng-show="content == 'Selected'">
	                           <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
            <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
	    			<div class="col-sm-1"style="width:3.333333%;"></div>	  <div class="form-group col-sm-5"id="alldatadiv" >
 <center><p class="groupPicturealldataheading">All Group</p> </center>
           <div id="allitems" >
       </div>
      
      </div>
<div class="col-sm-1"></div>
      <div id="selecteditems1" class="form-group col-sm-5" style="border:1px solid #dddddd;width:44.666667%;" >
<center><p class="groupselecteddataheading">Selected Group</p> </center>  
 <p id="selecteditems"></p>
      
      
      </div>
					
					
					<textarea id ="allids" name="all_user" style="display:none;" height="660"></textarea>
                                         <textarea id ="selectedids" name="selected_user" style="display:none;" ></textarea>
					</div>
					
					
			</div>
	<!----------------------------------- form picture post end here ------------------------------------------>		
			
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			
				<div class="publication">
		<!------------------------------------------------------------------------------------>
				<br>
		<div class="publication"><p id="publication_heading">Options</p><hr>
		
			<div class="row">
			
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent"data-toggle="tooltip" data-placement="left" title="Post Comment (Enable/Disable) in case of Enable(On) User enable to comment on the post ">Comment ?</p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
					
				<div class="checkbox"style="margin-top:-10px;"><label><input type="checkbox" data-toggle="toggle" name="comment" value="COMMENT_YES" checked></label></div>
				
			</div>
			</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent"data-toggle="tooltip" data-placement="left" title="Post Like(Enable/Disable) in case of Enable(On) User enable to like the post ">Like ? </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<div class="checkbox"style="margin-top:-10px;"><label><input type="checkbox" data-toggle="toggle" name="like" value="LIKE_YES" checked></label></div>
				
			</div>
		</div>
		
		
		</div>
				
		<div class="publication"><p id="publication_heading">Notification</p><hr>
		
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent"data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post"> Push ?</p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<div class="checkbox"style="margin-top:-10px;"><label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>
				
			</div>
		</div>
		
		
		</div>		
				
				
				
			</div>
			
			</div>
					
					
					
		<div class="form-group col-sm-12">
		<center>
		<button type="button" class="btn btn-info btn-md preview_postBtn" name="preview_post" id="preview_post" > Preview</button>
		<input type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish Now" id="getData" onclick="return ValidatePostpicture();" /></center>
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
   <!--tooltip script end here-->
				<?php include 'footer.php';?>