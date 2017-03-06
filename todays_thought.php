<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php'; ?>


<!-------------------------------SCRIPT START FROM HERE   --------->
<link rel="stylesheet" href="css/thought.css" />	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/thought.js"></script>
<script src="js/display_group.js"></script>
<link rel="stylesheet" href="style.css" />

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
    $("#close_news_priview").click(function(){
        $("#preview_div").hide();
    });
   
});
</script>

<style>
.preview_content{float:left;text-align:left !important;}
</style>


<div>
<div id="preview_div">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 closebtn">
<button id="close_news_priview" type="button" class="btn btn-gray">X</button>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border:1px;"><img  style="height:547px;width:221px; margin-top:-47px;margin-left:-124px;" class="img-responsive" src="images/mobile.jpg" alt="Mobile" width="460" height="345"></div>


<div class="androidContentTab">

<div class="wholeAndroidContentHolder">
<div id="img_preview" style="display:none"><img src='' id='imgprvw'/></div>

<div class="preview_content mythoughtOFtheDay"></div>

</div>

</div>

<!--
<div class="iphoneContentTab">

<div class="wholeIOSContentHolder">
<div id="img_preview1" style="display:none"><img src='' id='imgprvw1'/></div>

<div class="preview_content"></div>

</div>

</div>
-->


</div>


<!--
<button id="closeThoughtPopoUpBtn" type="button" class="btn btn-danger">X</button>
<br>
<div class="row">
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
 <!--
  <div class="nav nav-tabs Mynav">
    <p class="active"id="AndroidText"><a data-toggle="tab" href="#AndoidPriviewTab">Andoid</a><br></p>
    <p id="iphoneText"><a data-toggle="tab" href="#IphonePriviewTab">Iphone</a><br></p>
  
  </div>-->
  <!--
</div>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

  <div class="tab-content mytabContent">
    <div id="AndoidPriviewTab" class="tab-pane fade in active">
      
<div class="background_Android_Image">

<img src="images/mobile.jpg"class="img img-responsive androidImage"/>

</div>

<div class="androidContentTab">

<div class="wholeAndroidContentHolder">
<div id="img_preview" style="display:none"><img src='' id='imgprvw'/></div>

<div class="preview_content mythoughtOFtheDay"></div>

</div>

</div>



    </div>
    <div id="IphonePriviewTab" class="tab-pane fade">
     <div class="background_iphone_Image">

<img src="images/i6.png"class="img img-responsive IphoneImage"/>

</div>

<div class="iphoneContentTab">

<div class="wholeIOSContentHolder">
<div id="img_preview1" style="display:none"><img src='' id='imgprvw1'/></div>

<div class="preview_content"></div>

</div>

</div>
    </div>
   
  </div>
</div>
</div>
/////////////////////////////////////////////////////////////////////
<!--

<button type="button"class="btn btn-danger closeThoughtPopoUpBtn">Close</button>
<div class="preview_content"></div>
<div id="img_preview" style="display:none"><img src='' id='imgprvw'/></div>-->
</div>

<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
  <div class="bs-example">

  <div class="row">
    <div class="col-xs-8 col-sm-8 col-md-9 col-lg-9">
    <h3><strong>Create Thought</strong><hr></h3>
    </div>
	
  </div>
<br/>

<div class="row">

<!---------------------------------long news from start here--------------------------------->	

<form name="form1" role="form" action="Link_Library/link_thoughtOFtheDAY.php" method="post" enctype="multipart/form-data">
<input type="hidden" name = "flag" value="5">         
<input type="hidden" name = "device" value="d2">   
<input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
<input type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">	         
  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
      
  
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      
        <label for="Article image">UPLOAD IMAGE</label>
        <div>
<input type="file" name="thoughtimage" accept="image/*" id="thoughtimage" value="uploadimage" onchange="showimagepreview1(this)" />
</div>
      
    </div>
    
   
  </div>
  
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">CONTENT</label>
      <div><textarea cols="100" id="editor1" name="content"  rows="10" required>    
</textarea></div>
      </div>
    </div>
  </div>
  
  <!---------------------this script for show textbox on select radio button---------------------->                            
</div>
<!---------------------------------long news from End here--------------------------------->  
<div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
<div class="publication">
<!---------------------------------------------------------------------->
<!--<div class="publication"><p id="publication_heading">Options</p><hr>
  <div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
   <p class="publication_leftcontent" style="font-weight:500;" data-toggle="tooltip" data-placement="left" title="Good Morning....this is demo text for testing">Comment ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    
    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="comment" value="COMMENT_YES" checked></label>
    </div>
                                
  </div>
  </div>
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <p class="publication_leftcontent" style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Good Morning....this is demo text for testing">Like ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="like" value="LIKE_YES" checked></label></div>
    
  </div>
 
</div>
</div>-->
 <!--- <div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <p class="publication_leftcontent" style="font">Email </p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    
    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="comment" value="EMAIL_YES"></label>
    </div>
                                
  </div>
  </div>  --->
        <div class="publication">
        <p id="publication_heading">PUBLICATION</p><hr>
        
        <p class="publication_subheading">PUBLICATION TIME </p>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                <p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Immediately ?</p>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                
                <div class="btn-group btn-toggle"> 
                    <button type = "button" class="btn btn-default btn-xs" id="showshortcontent">ON</button>
                    <button type = "button" class="btn btn-primary active btn-xs"id="hideshortcontent">OFF</button>
                    
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
</script>
                <div id="shortpublicationdivcontent">

<input type="date" class="form-control" placeholder="YYYY-MM-DD" name="publish_date1"/><br><br>

                <input type="time"class="form-control" style="width: 100% !important;" name="publish_time1"/>
                
        </div>
        
        <br>
        
        <p class="publication_subheading">UNPUBLICATION TIME </p>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                <p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Not Scheduled ?</p>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                
                <div class="btn-group btn-toggle"> 
                    <button type = "button" class="btn btn-default btn-xs"id="showshortcontent1">ON</button>
                    <button type = "button" class="btn btn-primary active btn-xs"id="hideshortcontent1">OFF</button>
                    
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
                <input type="date"class="form-control" style="width: 100% !important;" name="publish_date2"/><br><br>
                <input type="time"class="form-control"style="width: 100% !important;" name="publish_time2"/>
                
        </div>
        </div>

</div>


		
<div class="publication"><p id="publication_heading">Notification</p><hr>
		
			

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "id="rightpublicationdiv6 ">
    <p class="publication_leftcontent "data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>




  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;"><label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>
  </div>
 <!--<input type="checkbox" id="hh1" name="push" value="PUSH_YES" checked onclick="dev()">

<style>
#hh1{  width: 70px;height:35px; -webkit-appearance: none;margin-left:100px;}
#hh1{ content: url('off.png');display: block;}
#hh1:checked{ content: url('on.png');}
</style>-->
</div> 
		
		
		</div>
</div>


<br/>
<br/>
<center><div class="form-group col-md-12">    
<input type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Preview" />
<input type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish" onclick= "return check();"/>
<!---<a href="#meetop"><input type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Priview" /></a>--->
<!--<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" style="margin-bottom:8px;"><center>
<a href="#meetop"><input type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none;
    font-weight: normal;
    position: absolute;
    left: 280%;" value="Preview" /></a>
</center>
</div>-->
</div></center>
</form> 


</div>
               
    </div>
	</div>
	</div>
      <!--this script is use for tooltip genrate-->     

			                <!--this script is use for tooltip genrate-->     
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
   <!--tooltip script end here-->

   <!--tooltip script end here-->  
    <?php include 'footer.php';?>