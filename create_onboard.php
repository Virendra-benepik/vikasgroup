<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php'; ?>


<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<link rel="stylesheet" type="text/css" href="css/post_news.css">
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
//var content = CKEDITOR.instances.editor1.getData();
var userabout = $("#userabout").val();
var designation = $("#designation").val();
var doj = $("#area5").val();
var location = $("#location").val();
var drinks = $("#drinks").val();
var food = $("#food").val();
var placeiseen = $("#placeiseen").val();
var projectdone = $("#projectdone").val();
var mypersonal = $("#mypersonal").val();
var teaser = $("#comment").val();


$("#testpopup").css({"display":"block"});

$(".titlePost").html(heading);
$(".useraboutPost").html(userabout);
$(".designationPost").html(designation);
$(".dojPost").html(doj);
$(".locationPost").html(location);
$(".drinksPost").html(drinks);
$(".foodPost").html(food);
$(".placeiseenPost").html(placeiseen);
$(".projectdonePost").html(projectdone);
$(".mypersonalPost").html(mypersonal);

//$(".contentPost").html(content);


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

<div id="meetop">	</div>
<div id="testpopup">

<p id="close_news_priview"style="margin-top:0px;" ><button type="button"class="btn btn-gray">X</button></p><br><br>

<div id="rightoneIphone6">

<div id="iphone6DivMain"style="background-color:white;height:0px;margin-top:22px;">
<div id="iphone6">
<div id="inneriphone6">

<div class="iphoneSubParentDiv">


<div class="row">
<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
<div class="mobile_articals"><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i><font class="white_color">Article</font></div>
</div>
</div>


<div class="row">
<div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
<div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview"><?php echo $username = $_SESSION['user_name']; ?></p><p id="Date_newsPriview">Date: <?php echo date("d/m/Y"); ?></sub> </div>

</div>
<div class="titlePost"></div>
<div class="imagePost"><img class="post_img" /></div>
<div class="useraboutPost OnboardPost" style="white-space:pre-wrap !important;"></div>

<div class="designationPost OnboardPost"></div>
<div class="dojPost OnboardPost"></div>
<div class="locationPost OnboardPost"></div>
<div class="drinksPost OnboardPost"></div>
<div class="foodPost OnboardPost" style="white-space:pre-wrap !important;"></div>
<div class="placeiseenPost OnboardPost"></div>
<div class="projectdonePost OnboardPost"></div>
<div class="mypersonalPost OnboardPost"></div>

<div class="contentPost"></div>

<br/>
<div class="row"style="margin:0px">
<div class="col-xs-12 col-md-12 col-sm-5 col-lg-5 "><font style="font-size:10px;">0 Likes</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><font style="font-size:10px;">Like</font></button> </div>
<div class="col-xs-12 col-md-12 col-sm-7 col-lg-7 "><font style="font-size:10px;"> 0 Comments</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-commenting-o" aria-hidden="true"></i><font style="font-size:10px;">Comments</font></button></div
<hr style="height:1px;background-color:gray;width:92%;">
</div>

</div>

</div>
</div>
</div>



</div>




</div>  
 
  <div class="side-body padding-top"  style="border:1px solid #cdcdcd;margin-bottom:100px;margin-top:80px;padding-left:10px;padding-right:10px;">
    
  <div class="bs-example">

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3><strong>Welcome Aboard</strong></h3><hr>
    </div>  

  </div>
  
  


<div class="row">

<!---------------------------------long news from start here--------------------------------->	

<form name="form1" role="form" action="Link_Library/link_new_onboard.php" method="post" enctype="multipart/form-data" onsubmit="return check()">
  <input style="color:#2d2a3b;" type="hidden" name = "flag" value="12">			
<input style="color:#2d2a3b;"type="hidden" name = "device" value="d2">			
<input style="color:#2d2a3b;" type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
<input style="color:#2d2a3b;"type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			

  <div ng-app="" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
         <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="TITLE"> Joinee's Name<span style="color:red">*</span></label>
        <input style="color:#2d2a3b;" type="text" name="name" id="title" class="form-control" placeholder="Enter Joinee's Name" />
     
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
      
        <label for="Article image">Upload Image<span style="color:red">*</span>(Max Image Upload Size: 2MB, Image Resolution: 640X362)</label>
        
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>

<script type="text/javascript">
/*function showimagepreview1(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw').attr('src', e.target.result);
$('.post_img').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}*/

											function showimagepreview1(input) 
											{
											if (input.files && input.files[0]) {
											var filerdr = new FileReader();
											filerdr.onload = function(e) {
											   var image = new Image();
                                            image.src = e.target.result;
                                            image.onload = function () {
                                                //alert($("#uploadimage")[0].files[0].size);
                                                var height = this.height;
                                                var width = this.width;
                                                var size = parseFloat($("#uploadimage")[0].files[0].size / 1024).toFixed(2);
                                                if (size > 2000)
                                                {
                                                    alert("Sorry, your Image Size is too large , Max 2MB Size Are Allowed");
                                                    $('#imgprvw').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#uploadimage').val("");
                                                    return false;
                                                }

                                                else if (height > 1000 || width > 1000) {
                                                    alert("Width and Height must not exceed 1000 X 1000 px.");
                                                    $('#imgprvw').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#uploadimage').val("");
                                                    return false;
                                                }
                                                else
                                                {
                                                    $('#imgprvw').attr('src', e.target.result);
                                                    $('.post_img').attr('src', e.target.result);
                                                }
                                            }
    
											/*$('#imgprvw').attr('src', e.target.result);
											$('.post_img').attr('src', e.target.result);*/
											}
											filerdr.readAsDataURL(input.files[0]);
											}
											}
</script>
<img id="imgprvw" alt="uploaded image preview"/>
<div>
<input style="color:#2d2a3b;" type="file" id="uploadimage" accept="image/*" name="uploadimage" onchange="showimagepreview1(this)"/>
</div>

      
    </div>
    
    
    <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
    <div class="form-group">
<label for="comment">About<span style="color:red">*</span></label>
<textarea style="color:#2d2a3b;" class="form-control" rows="9" id="userabout" cols="5" name="userabout" placeholder="Enter About"></textarea>
</div>
    </div>
  </div>
  
  <div class="row">
  
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">Designation<span style="color:red">*</span></label>
		<div><textarea style="color:#2d2a3b;" class="form-control" rows="1" id="designation" cols="3" name="designation" placeholder="Enter Designation"></textarea></div>
      </div>
    </div>
	
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">Date of joining<span style="color:red">*</span></label>
		<div><input style="color:#2d2a3b;" type="date" class="form-control"  id="area5"  name="doj" placeholder="Enter Date Of Joining"></div>
      </div>
    </div>
	
	</div>
    
    
    <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">Location<span style="color:red">*</span></label>
		<div><textarea style="color:#2d2a3b;" class="form-control" rows="1" id="location" cols="3" name="location" placeholder="Enter Location"></textarea></div>
      </div>
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">favourite Drinks</label>
      <div><textarea style="color:#2d2a3b;"class="form-control" rows="1" id="drinks" cols="3" name="drinks" placeholder="Enter favourite Drinks"></textarea></div>
      </div>
    </div>
    </div>
	
	<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">favourite Food</label>
      <div><textarea style="color:#2d2a3b;"class="form-control" rows="1" id="food" cols="3" name="food" placeholder="Enter favourite Food"></textarea></div>
      </div>
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">favourite Holiday/Place</label>
      <div><textarea style="color:#2d2a3b;"  class="form-control" rows="1" id="placeiseen" cols="3" name="placeiseen" placeholder="Enter favourite Holiday/Place"></textarea></div>
      </div>
    </div>
	</div>
    
	<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">Personal Achievements</label>
      <div><textarea style="color:#2d2a3b;" class="form-control" rows="1" id="projectdone" cols="3" name="projectdone" placeholder="Enter Personal Achievements"></textarea></div>
      </div>
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="form-group">
        <label for="Articlecontent">Personal Interests/hobbies</label>
      <div><textarea style="color:#2d2a3b;"class="form-control" rows="1" id="mypersonal" cols="3" name="mypersonal" placeholder="Enter Personal Interests/hobbies"></textarea></div>
      </div>
    </div>
    </div>
  
 
 

    <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js">

</script>
  <div class="form-group col-sm-12">
                                     
  
                                     <label for="exampleInputPassword1">Select Group</label>
                                      <div>
									  <div class="col-md-6">
                                        <input style="color:#2d2a3b;" type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                                        <label for="radio6">
                                         Select Groups
                                        </label>
                                      </div>
                                         <div class="col-md-6">
                                        <!--<input style="color:#2d2a3b;" type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                                        <label for="radio5">
                                          Send Post to All Groups
                                        </label>-->
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
      
     
                                    <textarea  id ="allids" style="display:none;" name="all_user"  height="660"></textarea>
                                     <textarea  id ="selectedids" style="display:none;" name="selected_user" ></textarea>
      </div>
    
      </div>


<!---------------------------------long news from End here--------------------------------->	

<div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
<div class="publication" style="margin-top:20px;">
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
    <label><input style="color:#2d2a3b;" type="checkbox" data-toggle="toggle" name="like" value="LIKE_YES" checked></label></div>
    
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
<center>
<div class="form-group col-md-12">	
<input style="color:#2d2a3b;" type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish" onclick="return ValidatePostonboard();" />
<!--<button id="show" class="btn btn-md btn-info preview_postBtn">Preview</button>-->
<!--<input style="color:#2d2a3b;" type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none;
    font-weight: normal;
    position: absolute;
    left: 280%;" value="Preview" />-->

</div>
</center>

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