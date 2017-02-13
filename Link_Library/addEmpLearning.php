<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             

<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="angularjs/updateGroup1.js"></script>
<script src="js/display_group.js"></script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	
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


<div class="container" style="margin-top:80px;border:1px solid #cdcdcd;">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h3><strong>Add Employee Learning</strong></h3><hr>
		</div>
	</div>
	<form action="Link_Library/link_EmployeeTrainingDetails.php" method="post">
		<input type="hidden" name = "flag" value="14">
		<input type="hidden" name = "flagvalue" value="Learning : ">
		<input type="hidden" name = "device" value="d2">	
		<input type="hidden" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
		<input type="hidden" name="clientid" value="<?php echo $_SESSION['client_id']; ?>">
		<input type="hidden" name="googleapi" value="<?php echo $_SESSION['gpk']; ?>">
		<div class="row">
		<Div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		<div class="form-group">
			<label for="trainingid">Learning Name:</label>
			<select class="form-control" name="trainingid" required>
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
        
			</select>
      
		</div>
		<div class="form-group">
			<label for="empName">Employee Name:</label>
			<input type="hidden" id="s-box" name="employee_id" />
			<input style="color:#2d2a3b;" type="text" id="search-box" required name="" placeholder="Employee Name | Emplyee Code | Email ID" class="form-control">
			<div id="suggesstion-box"></div>
		</div>
		<div class="form-group">
			<label for="learningDate">Learning Date:</label>
			<input style="color:#2d2a3b;" type="date" class="form-control" required name="trainingdate" placeholder="Enter Learning Date">
		</div>
		<div class="form-group">
			<label for="remarks">Remarks:</label>
			<textarea style="color:#2d2a3b;"class="form-control" rows="5" required name="remark"></textarea>
		</div>
		
		</div>
		
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		<!---------------------------------long news from End here--------------------------------->	

<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12"id="rightpublicationdiv">
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
</div>
		
		
		
		</div>
		
		
		
   
		<div class="form-group col-sm-12">
            <label for="exampleInputPassword1">Select User</label>
                <div>
                    <div class="col-md-6">
                        <input type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                        <label for="radio5">Send Post to All Groups</label>
                    </div>
                    <div class="col-md-6">
                        <input type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                        <label for="radio6">Send Post to Selected Groups</label>
                    </div>
                </div>
                                
        </div>
			
		<!------------Abobe script for show textbox on select radio button start-------------------------------------------->
        <div id ="everything" ng-show="content == 'Selected'">
            <input style="color:#2d2a3b;"type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
            <input style="color:#2d2a3b;" type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
			<input style="color:#2d2a3b;"type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			
		              		
		<div class="form-group col-sm-5"id="alldatadiv" ><center><p class="groupalldataheading">All Group</p> </center>
				<div id="allitems" ></div>
			</div>
			<div class="col-sm-1"></div>
			<div id="selecteditems1" class="form-group col-sm-6" style="border:1px solid #dddddd;" >
			<center><p class="groupselecteddataheading">Selected Group</p> </center>  
			<p id="selecteditems"></i></p>
      
			</div> 
			<textarea id ="allids" style="display:none;" name="all_user"  height="660"></textarea>
            <textarea id ="selectedids" style="display:none;" name="selected_user" ></textarea>
      </div>
  
	
	<!------------Abobe script for show textbox on select radio button  end---------------------->
	
	<!--
	<button type="submit" value="Save" name="addemptraining" class="btn btn-primary" style="margin-bottom:30px;margin-left:600px;">Publish Now</button>						
	<div id="show" class="btn btn-md btn-primary " style="margin-bottom:30px;margin-left:710px;margin-top:-83px;;">Preview</div>
	-->
	<center><div class="form-group col-md-12">	
<input style="color:#2d2a3b;" type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish Now" />
<!--
<a href="#meetop"><input style="color:#2d2a3b;" type="button" name="preview_post"  id="show" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none;
    font-weight: normal;
    position: absolute;
    left: 280%;" value="Preview" /></a>
-->
<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" style="margin-bottom:8px;">
</div>
</div></center>
	
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
		
			<div class="sony" >
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-md-12" style="margin-top:-500px;background-color:#fff;margin-left:400px;box-shadow: -1px 1px 5px 2px #888888;height:565px;width:310px;position: absolute;z-index: 200;">
						<button id="hide" class="btn btn-gray" style="margin-left:257px;">X</button>

<!--this div for mobile image-->
<div class="" style="background-image:url('images/mobile.jpg');height: 564px; width: 261px;background-size:100% 100%;    padding-top: 101px;    margin-top: -43px;
    padding-left: 24px">
	
	
<!--this div for  data-->
	<div style="height:360px;width:213px;background-color:#fff"> 
	<div class="row" style="background-color: #5cb85c;
    height: 32px;
    margin-left: 0px;
    margin-right: 0px;
    border: 1px solid #5cb85c;"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i>&nbsp;&nbsp;&nbsp;<font style="color:#fff;">Article</font></div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
<p class="titlePost NewsPriviewtitle" style="margin-top:-13px ! important;"></p> 
<p class="author previewAuthor"><font style="color:#acacac;padding-left:10px;">Author:</font> <font style="font-size:10px;">Virendra</font></p>

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
	
	
	
  </form>
		

  </div>

 <?php include 'footer.php';?>
