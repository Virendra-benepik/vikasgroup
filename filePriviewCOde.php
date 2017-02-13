	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
	<!-------------------------------      SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>

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
<link rel="stylesheet"type="text/css"href="css/post_message.css"/>

<script>
$(document).ready(function(){

$("#preview_post").click(function(){

var mesg = $("#message").val();
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
<div class="imagePost"><img class="post_img" /></div>
<div class="contentPost"></div>
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
<div class="row">
<div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
<div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview">HR Name</p><p id="Date_newsPriview">Date</sub> </div>

</div>

<div class="imagePost"><img class="post_img" /></div>
<div class="titlePost"></div>
<div class="contentPost"></div>
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
               
	<div class="containerDiv">
	
	
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	<!--*****************************here all data will be put****************************************-->
	
	
	
	</div>
<!------------------------------------------message portal start from here------------------------------------------------>	
<br>
<br>
<br>
<br>
	<center><button type="button" class="btn btn-info btn-md preview_postBtn" id="preview_post" name="preview_post"> Preview</button>
						<input type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish Now" id="getData" onclick="return check();" /></center>
						
				<?php include 'footer.php';?>