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
<script src="js/text_editor/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({maxHeight : 120}).panelInstance('area1');
	
	new nicEditor({maxHeight : 250}).panelInstance('area5');
	
	new nicEditor({maxHeight : 250}).panelInstance('area6');
	
	new nicEditor({maxHeight : 250}).panelInstance('area7');
	
	new nicEditor({maxHeight : 250}).panelInstance('area8');
	
	new nicEditor({maxHeight : 250}).panelInstance('area9');
});
</script>
<!-----------------------------------nice editor script  end here ------------------------->

<script>


function cominghere()
{
 $("#IphoneLivePriviewNewsModel").modal('show');
var iframe = document.getElementById('youriframe');
iframe.src = iframe.src;
  
}

$(document).ready(function(){

$("#preview_post").click(function(){

var heading = $("#title").val();
var content = CKEDITOR.instances.editor1.getData();
var teaser = $("#comment").val();

$("#testpopup").css({"display":"block"});

$(".titlePost").html(heading);
$(".contentPost").html(content);


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
<!-------------------------------SCRIPT END FROM HERE   --------->

<script>
    
$(document).ready(function(){
    $("#close_news_priview").click(function(){
        $("#testpopup").hide();
    });
    
});
</script>



<!--****************************code start for PopUp**************************************-->


<script>
$(document).ready(function(){
    $("#hide").click(function(){
        $(".sony").hide();
    });
    $("#show").click(function(){
        $(".sony").show();
    });
});
</script>
<style>
.sony{display:none;height:554;width:221px;}
</style>

<div class="sony">

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-md-12" style="margin-top: 103px;background-color:#fff;margin-left:600px;box-shadow: -1px 1px 5px 2px #888888;height:600px;width:310px;position: absolute;
    z-index: 200;">
<button id="hide" class="btn btn-gray" style="float:right;">X</button>

<!--this div for mobile image-->
<div class="" style="background-image:url('images/mobile.jpg');height: 564px; width: 261px;background-size:100% 100%;    padding-top: 101px;    margin-top: 30px;
    padding-left: 24px">
	
	
<!--this div for  data-->
	<div style="height:360px;width:213px;background-color:#fff"> 
	<div class="row mobile_articals"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i><font class="white_color">Article</font></div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
<p class="titlePost NewsPriviewtitle" style="margin-top:-13px ! important;"></p> 
<p class="author previewAuthor"><font style="color:#acacac;">Author:</font> <font style="font-size:10px;">Virendra</font> </p>

</div>
</div>
<!--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5"><i class="fa fa-signal white_color" aria-hidden="true"></i><i class="fa fa-pencil white_color" aria-hidden="true"></i></div>-->
</div>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
<p class="date" style="margin-top:-235px;" >Date: 27/10/2016</p>
 </div>

 <div class="row">
<div class="col-xs-12 col-md-12 col-sm-4 col-lg-4 " style="margin-top:-112px;margin-left: 10px;"><font style="font-size:10px;">0 Likes</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><font style="font-size:10px;">Like</font></button> </div>
<div class="col-xs-12 col-md-12 col-sm-8 col-lg-8 " style="margin-top:-112px;margin-left:137px;"><font style="font-size:10px;"> 12 Comments</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-commenting-o" aria-hidden="true"></i><font style="font-size:10px;">Comments</font></button></div
<hr style="height:1px;background-color:red;width:92%;padding-top:-23px;">
</div>


</div>
 
</div>

	
	
</div>
</div>



</div>
<!--****************************code end of popup**************************************-->

<div id="meetop">	</div>
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
<div class="row">


<div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
<div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview">HR Name</p><p id="Date_newsPriview">Date</sub> </div>

</div>
<div class="titlePost"></div>
<div class="imagePost"><img class="post_img" /></div>


<div class="contentPost"></div>
<div class="row"style="margin:0px">
<div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Like /  Commnets      </div>
<div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
<hr style="height:1px;background-color:gray;width:92%;">
</div>


</div>
</div>
</div>

</div>

<div id="rightoneIphone6">

<div id="iphone6DivMain"style="background-color:white;height: 716px;">
<div id="iphone6">
<div id="inneriphone6">

<div class="iphoneSubParentDiv">
<div class="row">
<div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
<div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview">HR Name</p><p id="Date_newsPriview">Date</sub> </div>

</div>
<div class="titlePost"></div>
<div class="imagePost"><img class="post_img" /></div>

<div class="contentPost"></div>
<div class="row"style="margin:0px">
<div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Like /  Commnets      </div>
<div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
<hr style="height:1px;background-color:gray;width:92%;">
</div>

</div>
</div>
</div>



</div>




</div>

</div>    
 
  <div class="side-body" style="border:2px solid #cdcdcd;padding:20px;padding-top:27px;margin-top:60px;">
    
  <div class="bs-example">

 
<br/>
 <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3><strong>My Life at Mahle</strong></h3><hr>
    </div>

  </div>
<div class="row">

<!---------------------------------long news from start here--------------------------------->	

 <form name="form1" role="form" action="Link_Library/link_mylifeatmahle.php" method="post" enctype="multipart/form-data">
  <input style="color:#2d2a3b;" type="hidden" name = "flag" value="8">			
<input style="color:#2d2a3b;"type="hidden" name = "device" value="d2">			
<input style="color:#2d2a3b;"type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
<input style="color:#2d2a3b;" type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			

  <div ng-app="" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
         <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="TITLE">Title</label>
        <input style="color:#2d2a3b;"type="text" name="title" id="title" class="form-control" placeholder=" Choose a heading for this article..." required />
     
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
<input style="color:#2d2a3b;" type="file" id="uploadimage" name="uploadimage" accept="image/*" onchange="showimagepreview1(this)" required/>
</div>

      
    </div>
    
    
    <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
    <div class="form-group">
<label for="comment">About</label>
<textarea style="color:#2d2a3b;"class="form-control" rows="8" id="area1" cols="8" name="userabout" placeholder="Short paragraph to draw attention to the article... "></textarea>
</div>
    </div>
  </div>
  
  <div class="row">
  
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">My Life at Mahle</label>
      <div><textarea style="color:#2d2a3b;" style="color:#2d2a3b;"class="form-control" rows="8" id="area5" cols="8" name="mylife" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">My Usual Work Day</label>
      <div><textarea style="color:#2d2a3b;" class="form-control" rows="8" id="area6" cols="8" name="myworkday" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">Project I am Proud of</label>
      <div><textarea style="color:#2d2a3b;" class="form-control" rows="8" id="area7" cols="8" name="projectdone" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">Place I have Seen</label>
      <div><textarea style="color:#2d2a3b;" class="form-control" rows="8" id="area8" cols="8" name="placeiseen" placeholder="Short paragraph to draw attention to the article... "></textarea>
</textarea></div>
      </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">My Personal Life</label>
      <div><textarea style="color:#2d2a3b;"class="form-control" rows="8" id="area9" cols="8" name="mypersonallife" placeholder="Short paragraph to draw attention to the article... "></textarea>
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
                                        <input style="color:#2d2a3b;" type="radio" id="user2" name="user3" ng-model="content" value="All">
                                        <label for="radio5">
                                          Send Post to All Groups
                                        </label>
                                      </div>
                                      <div class="col-md-4">
                                        <input style="color:#2d2a3b;" type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                                        <label for="radio6">
                                         Send Post to Selected Groups
                                        </label>
                                      </div>
                                    </div>
                                
                                    </div>
  <!---------------------this script for show textbox on select radio button---------------------->                        
	


<!------------Abobe script for show textbox on select radio button---------------------->
           <div id ="everything" ng-show="content == 'Selected'">
            <input style="color:#2d2a3b;" type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
            <input style="color:#2d2a3b;" type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
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
      
     
                                    <textarea  style="color:#2d2a3b;"id ="allids" style="display:none;" name="all_user"  height="660"></textarea>
                                     <textarea style="color:#2d2a3b;" id ="selectedids" style="display:none;" name="selected_user" ></textarea>
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
    <label><input style="color:#2d2a3b;"type="checkbox" data-toggle="toggle" name="comment" value="COMMENT_YES" checked></label>
    </div>

                                
  </div>
  </div>
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <p class="publication_leftcontent" style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Post Like(Enable/Disable) in case of Enable(On) User enable to like the post ">Like ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input style="color:#2d2a3b;"type="checkbox" data-toggle="toggle" name="like" value="LIKE_YES" checked></label></div>
    
  </div>
 
</div>
</div>

<div class="publication"><p id="publication_heading">Notification</p><hr>

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <p class="publication_leftcontent"style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input style="color:#2d2a3b;" type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>
    
  </div>
 
</div>
</div>

</div>

</div>

<br/>
<br/>
<center><div class="form-group col-md-12">	

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:0px;margin-left:10px;margin-top:50px;">

<button id="show" class="btn btn-md btn-info preview_postBtn">Preview</button>
<input style="color:#2d2a3b;"type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;margin-right:710px" value="Publish Now" onclick= "return check();"/>

</div>

</div></center>

</form> 
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