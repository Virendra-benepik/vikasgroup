	  <?php  include 'navigationbar.php';?>
		<?php  include 'leftSideSlide.php';?>
	
	<!-------------------------------      SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	
	
               
			   <div class="side-body padding-top">
				
			<div class="bs-example">
   
	
			<div class="row" style="background-color:#dddddd;margin:1px !important;">
				<div class="col-xs-8 col-sm-8 col-md-9 col-lg-9"style="margin:1px !important;">
				<center><h3>create Admin</h3></center>
				</div>
<!--<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" ><center><br>
<a href="view_message.php"><button type="button"class="btn btn-info"style="margin-bottom:-13px;margin-top:0px;">View Message</button></a></center>
</div> -->
			</div>
	<br>
	
	
	
<!------------------------------------------message portal start from here------------------------------------------------>	
<script>
$(document).ready(function(){
$("#sub_admin").keyup(function(){

var string = $(this).val();
//$("#usersall").text(string);

        $.ajax({
            type:'POST',
            url: 'http://admin.benepik.com/employee/virendra/benepik_client/Link_Library/get_users1.php',
            data: {
                   textvalue: string,
                  },
            dataType: 'jsonp',
            jsonp: 'mm',
            jsonpCallback: 'jsonpCallback',
            success: function(data){
                
            }
        });
});
});

function jsonpCallback(data){
$("#usersall").append(data);
}
</script>
 <div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			<form role="form" method="post" action="Link_Library/link_create_subadmin.php" >
			<input type="hidden" name = "flag" value="2">
			 <input type="hidden" name = "device" id="device" value="d2">	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Email Id</label>
						<div>
						<input type="text" name="sub_admin" id="sub_admin" class="form-control" placeholder="write Email Id">
						<!--<textarea cols="80" id="message" name="content" rows="10" required>	
	                    </textarea>-->
						</div>
					</div>
					
					   
                                         <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="radio3 radio-check radio-success radio-inline">
                                            <input type="radio" id="radio5" name="user3" value="All">
                                            <label for="radio5">
                                               All Group
                                            </label>
                                          </div>
                                          <div class="radio3 radio-check radio-warning radio-inline">
                                            <input type="radio" id="radio6" name="user3" value="Selected">
                                            <label for="radio6">
                                              Selected Group
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button---------------------->                        
	<script type="text/javascript">
    $(function () {
     $("#everything").hide();
        $("input[name='user3']").click(function () {
            if ($("#radio6").is(":checked")) {
                $("#everything").show();
            } else {
                $("#everything").hide();
            }
        });
    });
</script>				
	  <!------------Abobe script for show textbox on select radio button---------------------->
	                               <div id ="everything">
	                                <input type='hidden' name="emailid" id="emailid" value="<?php echo $_SESSION['user_email']; ?>">
	    				<div class="form-group col-sm-6" >
					<input type="text" name ="selecteduser" id="selecteduser" class="form-control" placeholder=" Choose group" />					</div>
					
					<div id="selecteditems" class="form-group col-sm-6" >
					data is here.............
					
					</div>
					
					<div id="allitems" class="form-group col-sm-12" >
					show all data here.......
					</div>
					<textarea id ="allids" style="display:none;"  height="660"></textarea>
                                         <textarea id ="selectedids" style="display:none;" name="selected_user" ></textarea>
					</div>
					<div class="form-group col-sm-12">
						<input type="submit" name ="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Publish" id="getData" />
					</div>
					
				</div>
				</form>
			</div>

		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
	<!---	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		
		<div class="publication">
		<p id="publication_heading">PUBLICATION</p><hr>
		
		<p class="publication_subheading">PUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Immediately </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs" id="showshortcontent">ON</button>
					<button class="btn btn-primary active btn-xs"id="hideshortcontent">OFF</button>
					
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
				<input type="date"/>
				<input type="time"/>
				
		</div>
		
		<br>
		
		<p class="publication_subheading">UNPUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Not Scheduled </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="showshortcontent1">ON</button>
					<button class="btn btn-primary active btn-xs"id="hideshortcontent1">OFF</button>
					
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
				<input type="date"/>
				<input type="time"/>
				
		</div>
		</div>
		
		<br>
		
<div class="publication"><p id="publication_heading">Options</p><hr>
		
			

		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Acknowledging </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs">ON</button>
					<button class="btn btn-primary active btn-xs">OFF</button>
				</div>
			</div>
		</div>
		
		
		</div>
		

		</div>---->
		</div>
					
		
</div>
                   
            </div>
				<?php include 'footer.php';?>