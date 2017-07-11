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
var content = CKEDITOR.instances.editor1.getData();
var teaser = $("#comment").val();
var leadername = $("#leadername").val();

$("#testpopup").css({"display":"block"});

$(".titlePost").html(heading);
$(".contentPost").html(content);
$(".leadernamePost").html(leadername);


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
<div id="testpopup" style="height: 558px;margin-top:-400px;">

    <p id="close_news_priview" ><button type="button"class="btn btn-gray">X</button></p><br><br>
    
    <div id="iphone6">
        <div id="inneriphone6">

            <div class="iphoneSubParentDiv">
                <div class="row mobile_articals"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i><font class="white_color">Article</font></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                            
                            <p class="previewAuth"><font style="color:#acacac;">Author:</font> <font style="font-size:10px;"><?php echo $username = $_SESSION['user_name']; ?></font> </p>
							<p class="titlePost" ></p> 
                        </div>
                    </div>
                   
                </div>
               


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <img class="post_img"></div>
                </div>
				<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                        <p class="CommanNamePost leadernamePost"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                        <p class="contentPost"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                        <p class="date">Date: <?php echo date("d/m/Y"); ?></p>
                    </div>
                </div>


                <div class="row"style="margin:0px">
                    <div class="col-xs-12 col-md-12 col-sm-5 col-lg-5 "><font style="font-size:10px;">0 Likes</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><font style="font-size:10px;">Like</font></button> </div>
                    <div class="col-xs-12 col-md-12 col-sm-7 col-lg-7 "><font style="font-size:10px;"> 0 Comments</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-commenting-o" aria-hidden="true"></i><font style="font-size:10px;">Comments</font></button></div
                    <hr style="height:1px;background-color:gray;width:92%;">
                </div>
               

            </div>
        </div>
    </div>



</div>
  
 
  <div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:25px;">
  <div class="bs-example">

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3><strong>Leadership Connect</strong></h3><hr>
    </div>

  </div>


<div class="row">

<!---------------------------------long news from start here--------------------------------->	

 <form name="form1" role="form" action="Link_Library/link_post_ceo_message.php" method="post" enctype="multipart/form-data"  onsubmit="return check()">
  <input type="hidden" name = "flag" value="9">			
<input type="hidden" name = "device" value="d2">			
<input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
<input type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			

  <div ng-app="" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
         <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="TITLE">TITLE</label>
        <input style="color:#2d2a3b;" type="text" name="title" id="title" class="form-control" placeholder=" Choose a heading for this article..." />
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;">
      
        <label for="Article image">UPLOAD IMAGE (Max Image Upload Size: 2MB, Image Resolution: 640X362)</label><br/>
        
        <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
		-->
<script type="text/javascript">
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
<input type="file" id="uploadimage" name="uploadimage" accept="image/*" onchange="showimagepreview1(this)" />
</div>

      
    </div> 
   
  </div>
  
  <div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="form-group">
<label for="comment">Leader Name</label>
<input style="color:#2d2a3b;" type="text" name="leadername" id="leadername" class="form-control" placeholder="Leader Name" />
</div>
    </div>
  </div>
  
  <div class="row">
    <script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Articlecontent">Message</label>
      <div><textarea style="color:#2d2a3b;"cols="120" id="editor1" name="content"  rows="10" >	
</textarea></div>
      </div>
    </div>
  </div>
  <script>
CKEDITOR.replace( 'editor1' );  
</script>   <!--- this is for ckeditor   ----->

    <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js">

</script>
  <div class="form-group col-sm-12">
                                     <label for="exampleInputPassword1">Select Group</label>
                                      <div>
									   <div class="col-md-6">
                                        <input type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                                        <label for="radio6">
                                         Select Groups
                                        </label>
                                      </div>
                                         <div class="col-md-6">
                                        <!--<input type="radio" id="user2" name="user3" ng-model="content" value="All"
                                        ng-checked="true">
                                        <label for="radio5">
                                          Send Post to All Groups
                                        </label>-->
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
<div class="publication" style="margin-top:20px;">
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
<input style="color:#2d2a3b;" type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish" onclick="return ValidatePostCeoMessage();" />

<!--<a href="#meetop"><input style="color:#2d2a3b;" type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none;
    font-weight: normal;
    position: absolute;
    left: 280%;" value="Preview" /></a>-->
<!--<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" style="margin-bottom:8px;"><center>

</center>
</div>-->
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