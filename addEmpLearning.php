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
function ValidatePostlearning()
{
	var e = document.getElementById("trainingid");
                var learningname = e.options[e.selectedIndex].value;

                var strUser1 = e.options[e.selectedIndex].text;
                if(learningname==0)
                {
                    alert("Please Select Learning Name");
					e.focus();
                    return false;
                }
}
</script>
<?php
@session_start();
	require_once('Class_Library/class_training.php');
	$obj = new Training();
	$clientid = $_SESSION['client_id'];
	
//print_r($_SESSION);
?>
<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "reademployeeinfo.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
			
		}
		});
	});
});

function selectemployeeinfo(autoid,empname) {
$("#search-box").val(empname);
$("#s-box").val(autoid);
$("#suggesstion-box").hide();
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

//var heading = $("#trainingid").val();

var learningname = $("#trainingid option:selected").text();
var empname = $("#search-box").val();
var trainingdate = $("#trainingdate").val();
var remark = $("#remark").val();




$("#testpopup").css({"display":"block"});

$(".learningnamePost").html(learningname);
$(".empnamePost").html(empname);
$(".trainingdatePost").html(trainingdate);
$(".remarkPost").html(remark);



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
<?php
$username = $_SESSION['user_name'];
?>
<div id="meetop">	</div>
<div id="testpopup" style="height: 558px;margin-top:4px;top:7% ! important">

<p id="close_news_priview" ><button type="button"class="btn btn-gray">X</button></p><br><br>
<div id="iphone6">
<div id="inneriphone6">

<div class="iphoneSubParentDiv">
<div class="row mobile_articals"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i><font class="white_color">Article</font></div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 

<p class="author previewAuthor"><font style="color:#acacac;">Author:</font> <font style="font-size:10px;"><?php echo $username; ?></font> </p>
</div>
</div>
<!--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5"><i class="fa fa-signal white_color" aria-hidden="true"></i><i class="fa fa-pencil white_color" aria-hidden="true"></i></div>-->
</div>
<!--
<div class="row"><div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 "><font style="color:#e0e0e0;padding-left:8px;">Draft</font></div>
<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><a href="#"><font style="color:#e0e0e0">FirstName LastName</font></a></div>

</div>
-->
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<p class="learningnamePost previewContent"></p> 
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<p class="empnamePost previewContent"></p>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<p class="trainingdatePost previewContent"></p>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<p class="remarkPost previewContent"></p>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <img class="post_img img img-responsive imagePost previewImage" /></div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
<p class="date" style="margin-top:-30px;" >Date: <?php echo date("d/m/Y"); ?></p>
 </div>
</div>


<div class="row"style="margin:0px">
<div class="col-xs-12 col-md-12 col-sm-5 col-lg-5 "><font style="font-size:10px;">0 Likes</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><font style="font-size:10px;">Like</font></button> </div>
<div class="col-xs-12 col-md-12 col-sm-7 col-lg-7 "><font style="font-size:10px;"> 12 Comments</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-commenting-o" aria-hidden="true"></i><font style="font-size:10px;">Comments</font></button></div
<hr style="height:1px;background-color:gray;width:92%;">
</div>

</div>
</div>
</div>

</div>
 
  <div class="side-body padding-top" >
  <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
    
  <div class="bs-example">

  <div class="row " >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3><strong>Add Employee Certificate</strong></h3><hr>
    </div>

  </div>


<div class="row">

<!---------------------------------long news from start here--------------------------------->	

 <form name="form1" role="form" action="Link_Library/link_EmployeeTrainingDetails.php" method="post" onsubmit="return check()"> 
		<input type="hidden" name = "flag" value="14">
		<input type="hidden" name = "flagvalue" value="Learning : ">
		<input type="hidden" name = "device" value="d2">	
		<input type="hidden" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
		<input type="hidden" name="clientid" value="<?php echo $_SESSION['client_id']; ?>">
		<input type="hidden" name="googleapi" value="<?php echo $_SESSION['gpk']; ?>">
    
  <div ng-app="" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
         <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="TITLE">Certificate Name:</label>
        <select class="form-control" name="trainingid" id="trainingid" required>
		<option value="0" selected>-----Select Certificate---</option>
			<option><?php 
				$row = $obj->viewTraininglist($clientid);
				$id = json_decode($row, true);
				//echo "<pre>";
				//print_r($id);
				//$co = count($id);
				for($i=0; $i<count($id); $i++)
					{
						$trainingid =$id[$i]['trainingId'];
						$trainingName =$id[$i]['trainingName'];
						//echo "<input type='hidden' name = 'lerningname' value='".$trainingName."'>";
						echo  "<option value=".$trainingid.">".$trainingName."</option>";
					} 
					?></option>
        
			</select>  </div>
    </div>
  </div>
  <div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="Empname">Employee Name:</label>
        <input type="hidden" id="s-box" name="employee_id" />
			<input style="color:#2d2a3b;" type="text" id="search-box" required name="search-box" placeholder="Employee Name | Emplyee Code | Email ID" class="form-control">
			<div id="suggesstion-box"></div>
		</div>
    </div>
	</div>

	
	 <div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="learningdate">Certificate Date:</label>
        <input style="color:#2d2a3b;" type="date" class="form-control" required name="trainingdate" id="trainingdate" placeholder="Enter Certificate Date">
		</div>
    </div>
	</div>
	
	
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="form-group">
        <label for="remark">Remarks:</label>
        <textarea style="color:#2d2a3b;"class="form-control" rows="5" name="remark" id="remark"></textarea>
		</div>
    </div>
  </div>
  
  
  
  
    <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js">

</script>
  <div class="form-group col-sm-12">
                                     
  
                                     <label for="exampleInputPassword1">Select User</label>
                                      <div>
                                         <div class="col-md-6">
                                        <input style="color:#2d2a3b;" type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                                        <label for="radio5">
                                          Send Post to All Groups
                                        </label>
                                      </div>
                                      <div class="col-md-6">
                                        <input style="color:#2d2a3b;"type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                                        <label for="radio6">
                                         Send Post to Selected Groups
                                        </label>
                                      </div>
                                    </div>
                                
                                    </div>
  <!---------------------this script for show textbox on select radio button---------------------->                        
	


<!------------Abobe script for show textbox on select radio button---------------------->
           <div id ="everything" ng-show="content == 'Selected'">
            <input style="color:#2d2a3b;"type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
            <input style="color:#2d2a3b;" type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
			<input style="color:#2d2a3b;"type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			
		          <div class="form-group col-sm-5"id="alldatadiv" >
 <center><p class="groupalldataheading">All Group</p> </center>
           <div id="allitems" >
       </div>
      
      </div>
<div class="col-sm-1"></div>
      <div id="selecteditems1" class="form-group col-sm-6" style="border:1px solid #dddddd;" >
<center><p class="groupselecteddataheading">Selected Group</p> </center>  
 <p id="selecteditems"></i></p>
      
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
    <label><input style="color:#2d2a3b;" type="checkbox" data-toggle="toggle" name="comment" value="COMMENT_YES" checked></label>
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
    <label><input style="color:#2d2a3b;"type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>
    
  </div>
 
</div>
</div>

</div>

</div>

<br/>
<br/>
<center><div class="form-group col-md-12">	
<input style="color:#2d2a3b;" type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish" onclick="return ValidatePostlearning();" />
<!---<a href="#meetop"><input type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Priview" /></a>--->
<a href="#meetop"><input style="color:#2d2a3b;" type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none;
    font-weight: normal;
    position: absolute;
    left: 280%;" value="Preview" /></a>


<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" style="margin-bottom:8px;">
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
</div>

   <!--tooltip script end here-->  
    <?php include 'footer.php';?>
	