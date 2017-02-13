<!-----------
Created BY - Monika Gupta
Created Date - 26/10/2016
----------->	 
	 <?php include 'navigationbar.php';?>
	 <?php include 'leftSideSlide.php';?>
	
<link rel="stylesheet" href="css/thought.css" />
<link rel="stylesheet" href="css/createNotice.css" />
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="angularjs/updateGroup1.js"></script>
<script src="js/display_group.js"></script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	
<!------------------------------- script for search box using ajax --------------------->	
	
<!---<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script> -->
<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "readempinfo.php",
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
	
<!------------------------- end of script for search box using ajax -------------------->

	
	<script>
function check() {
       if (confirm('Are You Sure, You want to publish this?')) {
           return true;
       } else {
           return false;
       }
    }
</script>
	
	
	<script>
$(document).ready(function(){
    $(".closeThoughtPopoUpBtn").click(function(){
        $("#createNoticeDiv").hide();
    });
    $("#createNoticePubliceBtn").click(function(){

var employeename = $("#search-box").val();
var awardname = $("#awardNotice").val();
var title = $("#awarddate").val();
var content = CKEDITOR.instances.editor1.getData();

$(".awarddescription").html(content);
$(".dateaward").html(title);
$(".empname").html(employeename);
$(".nameaward").html(awardname);

        $("#createNoticeDiv").show();
    });
});
</script>
<script>
    
$(document).ready(function(){
    $("#close_news_priview").click(function(){
		
        $("#createNoticeDiv").hide();
    });
    
});
</script>

<div id="createNoticeDiv" style="margin-top:20px;">

<button id="close_news_priview" type="button" class="btn btn-gray closebtn">X</button>
	<div class="row">
		
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div class="tab-content mytabContent">
				<div id="AndoidPriviewTab" class="tab-pane fade in active">  
					<div class="">
						<img src="images/mobile.jpg"class="img img-responsive" style="width:221px;height:547px;margin-left:41px;margin-top:-72px;"/>
					</div>
					<div class="androidContentTab">
						<div class="wholeAndroidContentHolder">
					<div class="empname"></div>
					<div class="nameaward"></div>
					<div class="dateaward"></div>
					<div class="awarddescription"></div>		
							
						</div>
					</div>
				</div>
				<div id="IphonePriviewTab" class="tab-pane fade">
					<div class="background_iphone_Image">
						<img src="images/i6.png"class="img img-responsive IphoneImage"/>
					</div>
					<div class="iphoneContentTab">
						<div class="wholeIOSContentHolder">
					<div class="empname"></div>
					<div class="nameaward"></div>
					<div class="dateaward"></div>
					<div class="awarddescription"></div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



</div>

               
			   <div class="side-body padding-top">
				<div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:-5px;">
			<div class="bs-example">
   
	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
				<h3><strong>Create Employee Award</strong></h3><hr>
				<?php 
				/*if(isset($_SESSION['msg']))
				{
				echo $_SESSION['msg'];
				}*/
				?>
				
				</div>

			</div>
			
	<br>
	
	<?php
	//unset($_SESSION['msg']);
	?>
	
<!------------------------------------------message portal start from here------------------------------------------------>	
 <div class="row">
 <!---------------------------------- Add class and create object ------------------------------------------->


<?php
	@session_start();
        require_once('Class_Library/class_award.php');
	$object = new award();
	$clientid = $_SESSION['client_id'];
   
?>
 
 <form role="form" method="post" action="Link_Library/link_employee_award.php" >
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			
			<input style="color:#2d2a3b;"type="hidden" name = "flag" value="13">
			<input style="color:#2d2a3b;" type="hidden" name="uniqueuserid" value="<?php echo $_SESSION['user_unique_id']; ?>"/>
			<input style="color:#2d2a3b;"type="hidden" name = "flagvalue" value="Award : ">
			<input style="color:#2d2a3b;"type="hidden" name = "device" value="panel">	
			<input style="color:#2d2a3b;"type="hidden" name="clientid" value="<?php echo $clientid;?> ">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Employee Name</label>
						
						<input style="color:#2d2a3b;"type="hidden" id="s-box" name="employee_id" />
	<input style="color:#2d2a3b;" type="text" id="search-box" name="" placeholder="Employee Name | Emplyee Code | Email ID" class="form-control" required />
						<div id="suggesstion-box"></div>
						
					</div>
					
					<div class="form-group">
						<label for="Articlecontent">Award Name</label>
						<select name="award_id" id="awardNotice" class="form-control" required>
						<option selected>-----Select Award---</option>
							<?php 
							$row = $object->viewawards($clientid);
							$id = json_decode($row, true);
							echo $row;
							$count = count($id['Data']);
							for($i=0;$i<$count;$i++)
							{
						   $award_id = $id['Data'][$i]['awardId'];
						   $award_name = $id['Data'][$i]['awardName'];
						   echo  "<option value=".$award_id.">".$award_name."</option>";
							} 
							?>
						</select>
					</div>
                         <div class="form-group">
						<label for="Articlecontent">Select Date</label>
						<input style="color:#2d2a3b;"type="date" name="awarddate" id="awarddate" class="form-control" required>
					</div>

					<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
					   <div class="form-group">
						<label for="Articlecontent">Award Description</label>
						<div>
						<textarea cols="80" id="editor1" name="comment_description" rows="10" required>	
	                    </textarea>
						</div>
					</div>
					<script>
		CKEDITOR.replace( 'editor1' );  
	</script>   <!--- this is for ckeditor   ----->
 
                                          <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="col-md-4">
                                            <input style="color:#2d2a3b;"type="radio" id="user2" name="usertype" ng-model="content" value="All" ng-checked="true" >
                                            <label for="radio5">
                                             Send Notice to All Groups
                                            </label>
                                          </div>
                                          <div class="col-md-4">
                                            <input style="color:#2d2a3b;" type="radio" id="user" name="usertype" ng-model="content" value="Selected">
                                            <label for="radio6">
                                             Send Notice to Selected Groups
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button---------------------->                      
				
	  <!------------Abobe script for show textbox on select radio button---------------------->
	            <div id ="everything" ng-show="content == 'Selected'">
            <input style="color:#2d2a3b;"type='text' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
            <input style="color:#2d2a3b;"type='text' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
			<input style="color:#2d2a3b;"type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			
		               <div class="form-group col-sm-5"id="alldatadiv" >
                                     <center><p class="groupalldataheading">All Group</p> </center>
                                  <div id="allitems" ></div>
      
                                  </div>
<div class="col-sm-1"></div>
      <div id="selecteditems1" class="form-group col-sm-6" style="border:1px solid #dddddd;" >
<center><p class="groupselecteddataheading">Selected Group</p> </center>  
 <p id="selecteditems"></p>
      
      </div> 
					
					<textarea id ="allids" name="all_user"  height="660"></textarea>
                                     <textarea id ="selectedids"  name="selected_user" ></textarea>
      
      </div>
					
					
				</div>
				
			</div>
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
		
				
<div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
<div class="publication">
<!---------------------------------------------------------------------->

        <div class="publication">
        <p id="publication_heading">PUBLICATION</p><hr>
        
        <p class="publication_subheading">PUBLICATION TIME </p>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                <p class="publication_leftcontent">Immediately </p>
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

<input style="color:#2d2a3b;"type="date" class="form-control" placeholder="YYYY-MM-DD"  name="publish_date1"/><br><br>

                <input style="color:#2d2a3b;" type="time"class="form-control" style="width: 100% !important;" name="publish_time1"/>
                
        </div>
        
        <br>
        
        <p class="publication_subheading">UNPUBLICATION TIME </p>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                <p class="publication_leftcontent">Not Scheduled </p>
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
                <input type="date"class="form-control" style="width: 100% !important;" name="unpublish_date1"/><br><br>
                <input type="time"class="form-control" style="width: 100% !important;" name="unpublish_time1"/>
                
        </div>
        </div>

</div>


		
<div class="publication"><p id="publication_heading">Notification</p><hr>
		
			

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "id="rightpublicationdiv6 ">
    <p class="publication_leftcontent "data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>




  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>
    
  </div>
 
</div> 
		
		
		</div>
</div>

		
		<div class="form-group col-sm-12">
		<center>
						<input type="button"  class="btn btn-md btn-info publishnowBtn" id="createNoticePubliceBtn"style="text-shadow:none;font-weight:normal;" value="Preview" />
						<input type="submit" name ="employeeAddAward" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish Now" id="getData" onclick= "return check();" />
</center>
					</div>
		
		
		
		</form>
		</div>
					
	
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