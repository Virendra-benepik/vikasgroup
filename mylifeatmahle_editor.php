<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php'; ?>


<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<link rel="stylesheet" type="text/css" href="css/post_news.css">
<script>
function check() {
       if (confirm('Are You Sure, You want to publish this post?')) {
           return true;
       } else {
           return false;
       }
    }
</script>

------------------------------------------------->
<script src="js/nice_editor/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({maxHeight : 120}).panelInstance('area1');
	
	new nicEditor({maxHeight : 250}).panelInstance('area5');
	
	new nicEditor({maxHeight : 250}).panelInstance('area6');
	
	new nicEditor({maxHeight : 250}).panelInstance('area7');
	
	new nicEditor({maxHeight : 250}).panelInstance('area8');
	
	new nicEditor({maxHeight : 250}).panelInstance('area9');
	
	new nicEditor({maxHeight : 250}).panelInstance('area3');
});
</script>
<!-----------------------------------nice editor script  end here ------------------------->

<script type="text/javascript">

$(document).ready(function(){

$("#preview_post1").click(function(){
//var mesg = $("#message").val();
var heading 	 = $("#title").val();

var about 	 = ((nicEditors.findEditor('area1').getContent() !='<br>') && (nicEditors.findEditor('area1').getContent() !=''))?"<b>About Me</b><br>"+nicEditors.findEditor('area1').getContent():$('.about').html('');
var path  	 = ((nicEditors.findEditor('area3').getContent() != '<br>') && (nicEditors.findEditor('area3').getContent() != ''))?"<b>My Path at Mahle</b><br>"+nicEditors.findEditor('area3').getContent():$('.path').html('');
var lifeMahle 	 = ((nicEditors.findEditor('area5').getContent() != '<br>') && (nicEditors.findEditor('area5').getContent() != ''))?"<b>My Life at Mahle</b><br>"+nicEditors.findEditor('area5').getContent():$('.lifeMahle').html('');
var usualDay  	 = ((nicEditors.findEditor('area6').getContent() != '<br>') && (nicEditors.findEditor('area6').getContent() !=''))?"<b>My usual day at work</b><br>"+nicEditors.findEditor('area6').getContent():$('.usualDay').html('');
var proudProject = ((nicEditors.findEditor('area7').getContent() != '<br>') && (nicEditors.findEditor('area7').getContent() !=''))?"<b>Project I Am Proud of</b><br>"+nicEditors.findEditor('area7').getContent():$('.proudProject').html('');
var places 	 = ((nicEditors.findEditor('area8').getContent() != '<br>') && (nicEditors.findEditor('area8').getContent() !=''))?"<b>Places I Have been</b><br>"+nicEditors.findEditor('area8').getContent():$('.places').html('');
var personal 	 = ((nicEditors.findEditor('area9').getContent() != '<br>') && (nicEditors.findEditor('area9').getContent() !=''))?"<b>My Personal Life</b><br>"+nicEditors.findEditor('area9').getContent():$('.personal').html('');

$("#testpopup").css({"display":"block"});
$(".titlePost").html(heading);
$(".about").html(about);
$(".path").html(path);
$(".lifeMahle").html(lifeMahle);
$(".usualDay").html(usualDay);
$(".proudProject").html(proudProject);
$(".places").html(places);
$(".personal").html(personal);

$(".contentPost").html(content);

});
});

</script>
<!-------------------------------SCRIPT END FROM HERE   --------->

<script type="text/javascript">
    
$(document).ready(function(){
    $("#close_news_priview").click(function(){
        $("#testpopup").hide();
    });
    

$("#Iphone5").click(function(){
$("#rightoneIphone5").css({"z-index":1});
$("#rightoneIphone6").css({"z-index":0});
});
$("#Iphone6").click(function(){
$("#rightoneIphone6").css({"z-index":1});
$("#rightoneIphone5").css({"z-index":0});
});

});
</script>

<div id="testpopup">

<p id="close_news_priview"><button type="button"class="btn closeBtn"><span class="glyphicon glyphicon-remove-circle"> close </span></button></p><br><br>

<div id="leftone">
<p style=" margin-top: 10px; font-size: 19px;margin-left: 24Px;border-bottom:1px dotted gray;"><span class="glyphicon glyphicon-phone" id="Iphone6"> Android</span></p>

<p style="margin-top: 10px; font-size: 19px;margin-left: 24Px;border-bottom:1px dotted gray;"><span class="glyphicon glyphicon-phone" id="Iphone5"> iphone</span></p>
</div>

<div id="rightoneIphone5">

<div id="iphone5">
<div id="inneriphone5">
<div class="iphoneSubParentDiv">
<div style="padding:5px">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p class="titlePost NewsPriviewtitle"></p> 

<p class="author">Author : </p>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><img class="post_img img img-responsive imagePost previewImage" />    </div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<p class="about">About </p>  
<p class="path">My Path at Mahle</p>
<p class="lifeMahle">My Life at Mahle</p>
<p class="usualDay">My Usual Work Day</p>
<p class="proudProject">Project I Am Proud of</p>
<p class="places">Place I Have been</p>
<p class="personal">My Personal Life</p>
<!-- <p class="date">Date:</p> -->
 </div>
</div>
</div>


<div class="row"style="margin:0px">
<div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Likes /  Commnets      </div>
<div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
<hr style="height:1px;background-color:gray;width:92%;">
</div>


</div>
</div>
</div>

</div>

<div id="rightoneIphone6">

<div id="iphone6DivMain"style="background-color:white;height: 612px;">
<div id="iphone6">
<div id="inneriphone6">

<div class="iphoneSubParentDiv">
<div style="padding:5px">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p class="titlePost NewsPriviewtitle"></p> 

<p class="author">Author : </p>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><img class="post_img img img-responsive imagePost previewImage" />    </div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<p class="about">About </p>  
<p class="path">My Path at Mahle</p>
<p class="lifeMahle">My Life at Mahle</p>
<p class="usualDay">My Usual Work Day</p>
<p class="proudProject">Project I Am Proud of</p>
<p class="places">Place I Have been</p>
<p class="personal">My Personal Life</p>
<!-- <p class="date">Date:</p> -->
 </div>
</div>
</div>

<div class="row"style="margin:0px">
<div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Likes /  Commnets      </div>
<div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
<hr style="height:1px;background-color:gray;width:92%;">
</div>

</div>
</div></div>
</div>

</div>

</div>    
 
  <div class="side-body padding-top">
    
  <div class="bs-example">

  <div class="row Subheader " style="background-color:#dddddd;margin:1px !important;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;color:#fff;">
    <center><h3>My Life at Mahle</h3></center>
    </div>

  </div>
<br/>
<div id="meetop"></div>
<div class="row">

<!---------------------------------long news from start here--------------------------------->	

 <form name="form1" role="form" action="Link_Library/link_mylifeatmahle.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name = "flag" value="8">			
<input type="hidden" name = "device" value="d2">			
<input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
<input type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			

  <div ng-app="" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
         <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="TITLE">Title</label>
        <input type="text" name="title" id="title" class="form-control" placeholder=" Choose a heading for this article..." required />
     
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
      
        <label for="Article image">Upload Image</label>
        
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
    
    
    <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
    <div class="form-group">
<label for="comment">About</label>
<textarea class="form-control" rows="8" id="area1" name="userabout" placeholder="Short paragraph to draw attention to the article... "></textarea>
</div>
    </div>
  </div>
  
  <div class="row">
  
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">My Path at Mahle</label>
      <div><textarea class="form-control" rows="8" id="area3" cols="8" name="mypath" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">My Life at Mahle</label>
      <div><textarea class="form-control" rows="8" id="area5" cols="8" name="mylife" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">My Usual Work Day</label>
      <div><textarea class="form-control" rows="8" id="area6" cols="8" name="myworkday" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">Project I am Proud of</label>
      <div><textarea class="form-control" rows="8" id="area7" cols="8" name="projectdone" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">Places I have been</label>
      <div><textarea class="form-control" rows="8" id="area8" cols="8" name="placeiseen" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">My Personal Life</label>
      <div><textarea class="form-control" rows="8" id="area9" cols="8" name="mypersonallife" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
  </div>
 
 

    <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js">

</script>
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
                                        <input type="radio" id="user" ng-model="content"  name="user3" value="Selected">
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
          <div class="form-group col-sm-5"id="alldatadiv" >
 <center><p class="groupalldataheading">All Group</p> </center>
           <div id="allitems" >
       </div>
      
      </div>
<div class="col-sm-1"></div>
      <div id="selecteditems1" class="form-group col-sm-6" style="border:1px solid #dddddd;" >
<center><p class="groupselecteddataheading">Selected Group</p> </center>  
 <p id="selecteditems"></p>
      
      
      </div> 
      
     
                                    <textarea id ="allids" style="display:none;" name="all_user"  height="660"></textarea>
                                     <textarea id ="selectedids" style="display:none;" name="selected_user" ></textarea>
      </div>
    
      </div>


<!---------------------------------long news from End here--------------------------------->	

<div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
<div class="publication">
<!---------------------------------------------------------------------->
<div class="publication"><p id="publication_heading">Options</p><hr>
  <div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
   <p class="publication_leftcontent" style="font-weight:500;" data-toggle="tooltip" data-placement="left" title="Post Comment (Enable/Disable) in case of Enable(On) User enable to comment on the post ">Comment ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    

    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="comment" value="COMMENT_YES" checked></label>
    </div>

                                
  </div>
  </div>
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <p class="publication_leftcontent" style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Post Like(Enable/Disable) in case of Enable(On) User enable to like the post ">Like ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="like" value="LIKE_YES" checked></label></div>
    
  </div>
 
</div>
</div>

<div class="publication"><p id="publication_heading">Notification</p><hr>
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
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <p class="publication_leftcontent"style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>
    
  </div>
 
</div>
</div>

</div>

</div>

<br/>
<br/>
<center><div class="form-group col-md-12">	
<input type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish Now" onclick= "return check();"/>
<!---<a href="#meetop"><input type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Priview" /></a>--->

<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" style="margin-bottom:8px;"><center>
<a href="#meetop"><input type="button" name="preview_post1"  id="preview_post1" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none;
    font-weight: normal;
    position: absolute;
    left: 280%;" value="Preview" /></a>
</center>
</div>
</div></center>

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