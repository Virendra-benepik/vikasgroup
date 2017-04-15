	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
<!--<link rel="stylesheet" href="css/thought.css" />-->
<link rel="stylesheet" href="css/createNotice.css" />
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="angularjs/updateGroup1.js"></script>
<script src="js/validation/createPostValidation.js"></script>
<script src="js/display_group.js"></script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	
	<script>
function check() {
       if (confirm('Are You Sure, You want to publish this Announcement?')) {
           return true;
       } else {
           return false;
       }
    }
</script>
	
	
	
	<script>
$(document).ready(function(){
    $("#closeThoughtPopoUpBtn").click(function(){
        $("#createNoticeDiv").hide();
    });
    $("#createNoticePubliceBtn").click(function(){

var title = $("#titlenotice").val();
var content = CKEDITOR.instances.editor1.getData();

$(".noticecontent").html(content);
$(".noticetitle").html(title);

        $("#createNoticeDiv").show();
    });
});
</script>

<div id="createNoticeDiv">


	<div class="row">
	
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<!--<div class="nav nav-tabs Mynav">
				<p class="active"id="AndroidText"><a data-toggle="tab" href="#AndoidPriviewTab">Andoid</a><br></p>
				<p id="iphoneText"><a data-toggle="tab" href="#IphonePriviewTab">Iphone</a><br></p>
			</div>-->
			
		</div>
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
		<button type="button"class="btn btn-gray " id="closeThoughtPopoUpBtn" style="margin-top: -4px;margin-left:188px;">X</button><br><br>
			<div class="tab-content">
				<div id="AndoidPriviewTab" class="tab-pane fade in active">  
					<div class="background_Android_Image">
						<img src="images/mobile.jpg"class="img img-responsive androidImage"/>
					</div>
					<div class="androidContentTab" >
						<div class="wholeAndroidContentHolder"  style="height:345px;overflow-y:scroll;">
					
					<div class="noticetitle" style="font-weight:bold; margin-left:10px; margin-right:10px;"></div>
					
					
					<div class="noticecontent" style="text-align:justify; margin-left:10px; margin-right:10px;"></div>	
					
							
						</div>
					</div>
				</div>
				<div id="IphonePriviewTab" class="tab-pane fade">
					<div class="background_iphone_Image">
						<img src="images/i6.png"class="img img-responsive IphoneImage"/>
					</div>
					<div class="iphoneContentTab">
						<div class="wholeIOSContentHolder">
						
					<div class="noticetitle"></div>
					<div class="noticecontent"></div>
							
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
   
	
			<div class="row" >
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3><strong>Announcement</strong></h3><hr>
				<?php 
				if(isset($_SESSION['msg']))
				{
				echo $_SESSION['msg'];
				}
				?>
				
				</div>

			</div>
	
	<?php
	unset($_SESSION['msg']);
	?>
	
<!------------------------------------------message portal start from here------------------------------------------------>	
<form name="notice" role="form" method="post" action="Link_Library/link_notice.php" onsubmit="return check();">
 <div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			
			<input style="color:#2d2a3b;" type="hidden" name = "flag" value="7">
			<input style="color:#2d2a3b;" type="hidden" name="uniqueuserid" value="<?php echo $_SESSION['user_unique_id']; ?>"/>
			<input style="color:#2d2a3b;" type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Title</label>
						<input style="color:#2d2a3b;" type="text" name="noticetitle" id="titlenotice" class="form-control" required>
					</div>  
					
					
					<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
					   <div class="form-group">
						<label for="Articlecontent">Content</label>
						<div>
						<textarea cols="80" id="editor1" name="noticecontent" rows="10" required>	
	                    </textarea>
						</div>
					</div>
					<script>
		CKEDITOR.replace( 'editor1' );  
	</script>   <!--- this is for ckeditor   ----->
 
                                          <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select Group</label>
                                          <div>
                                             
                                          <div class="col-md-6">
                                            <input  type="radio" id="user" name="user3" ng-model="content" value="Selected">
                                            <label for="radio6">
                                             Select Groups
                                            </label>
                                          </div>
										  <div class="col-md-6">
                                            <!--<input type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true" >
                                            <label for="radio5">
                                             Send Notice to All Groups
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
                                  <div id="allitems" ></div>
      
                                  </div>
<div class="col-sm-1"></div>
      <div id="selecteditems1" class="form-group col-sm-6" style="border:1px solid #dddddd;" >
<center><p class="groupselecteddataheading">Selected Group</p> </center>  
 <p id="selecteditems"></p>
      
      </div> 
					
					<textarea id ="allids" name="all_user" style="display:none;" height="660"></textarea>
                                     <textarea id ="selectedids" style="display:none;" name="selected_user" ></textarea>
      
      </div>
					
					
				</div>
				
			</div>
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
		
		
		
<div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
<!--<div class="publication">
<!----------------------------------------------------------------------

        <div class="publication">
        <p id="publication_heading">PUBLICATION</p><hr>
        
        <p class="publication_subheading">PUBLICATION TIME </p>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                <p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Immediately ? </p>
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

<input style="color:#2d2a3b;" type="date" class="form-control" placeholder="YYYY-MM-DD"  name="publish_date1"/><br><br>

                <input style="color:#2d2a3b;"  type="time"class="form-control" style="width: 100% !important;" name="publish_time1"/>
                
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
                <input style="color:#2d2a3b;" type="date"class="form-control" style="width: 100% !important;" name="unpublish_date1"/><br><br>
                <input style="color:#2d2a3b;" type="time"class="form-control" style="width: 100% !important;" name="unpublish_time1"/>
                
        </div>
        </div>

</div>---->


		
<div class="publication" style="margin-top:20px;"><p id="publication_heading">Notification</p><hr>
		
			

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "id="rightpublicationdiv6 ">
    <p class="publication_leftcontent "data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>




  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
    <div class="checkbox"style="margin-top:-10px;">
    <label>
        <input style="color:#2d2a3b;" type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked>
    </label>
    </div>
    
  </div>
 
</div> 
		
		</div>
</div>

		
		<div class="form-group col-sm-12">
		<center>
<input style="color:#2d2a3b;"type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish" id="getData" onclick= "return ValidatePostNotice();" required/>
<!--<input style="color:#2d2a3b;" type="button"  class="btn btn-md btn-info publishnowBtn" id="createNoticePubliceBtn"style="text-shadow:none;font-weight:normal;" value="Preview" />
						-->
</center>
					</div>
		
		
		
		
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
   <!--tooltip script end here--> 
   </div>
				<?php include 'footer.php';?>