<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
<!-------------------------------SCRIPT END FROM HERE   --------->	
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
function ValidateEvent()
{
    var posttitle = document.form1.posttitle;
    var venue = document.form1.venue;
    var event_date = document.form1.event_date;
	var todatdate = document.form1.today;
	var event_time = document.form1.event_time;
	var cost = document.form1.cost;
	var description = document.form1.description;
	
    if (posttitle.value == "")
    {
        window.alert("Please Enter Title.");
        posttitle.focus();
        return false;
    }
    if (venue.value == "")
    {
        window.alert("Please Enter Venue.");
        venue.focus();
        return false;
    }
	if (event_date.value == "")
    {
        window.alert("Please Select Date.");
        event_date.focus();
        return false;
    }
	if (event_date.value < todatdate.value)
    {
        window.alert("You Are Not Allowed To Select Past Date");
        event_date.focus();
        return false;
    }
	if (event_time.value == "")
    {
        window.alert("Please Select Time.");
        event_time.focus();
        return false;
    }
	if (cost.value == "")
    {
        window.alert("Please Enter Cost.");
        cost.focus();
        return false;
    }
	if (description.value == "")
    {
        window.alert("Please Enter Description.");
        description.focus();
        return false;
    }

    return true;
}
</script>
<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
        <div class="bs-example">


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
                    <h4><strong>Update Post</strong></h4><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                    }
                    ?>

                </div>

            </div>
            <br>

            <?php
            unset($_SESSION['msg']);
            ?>
            <?php
            require_once('Class_Library/class_event.php');
            $eventid = $_GET['eventid'];
            $clientid = $_GET['clientid'];
			$page = $_GET['page'];
            //echo $post;
			$flag = 6 ;
            $pageobj = new Event();
            $result1 = $pageobj->getsingleeventdetails($eventid,$clientid,$flag);
            $result = json_decode($result1, true);
			//echo "<pre>";
			//print_r($result);
            //echo "</pre>";
            $registration = $result['posts'][0]['registration'];
            ?>
            <!------------------------------------------message portal start from here------------------------------------------------>	
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!----------------------------------------message  start from here---------------------------------------->	
                    <div class="row">
                        <form role="form" name="form1" method="post" enctype="multipart/form-data" action="Link_Library/link_update_event.php" onsubmit="return check();">
                            <input type="hidden" name = "client" value="<?php echo $clientid; ?>">
                            <input type="hidden" name="postid" value="<?php echo $_GET['eventid']; ?>" />
                            <input type="hidden" name="page" value="<?php echo $page; ?>" />
                            
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							
							<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Articlecontent"> Title</label>
                                    <input type="text" name="posttitle" class="form-control" value="<?php echo $result['posts'][0]['post_title']; ?>">
                                </div>
                            </div>
							</div>
							
					      <div class="row">
						  <div class="form-group col-md-6">
							<label for="VENUE">Venue</label>
							<input  style="color:#2d2a3b;" type="text" name="venue" id="venue" class="form-control" value="<?php echo $result['posts'][0]['venue']; ?>" placeholder=" Choose a venue" />
						  </div>
						   <div class="form-group col-md-3">
							<label for="DATE">Date</label>
							<input style="color:#2d2a3b;"  type="date" name="event_date" id="event_date" class="form-control" placeholder="Choose a date" value="<?php echo $result['posts'][0]['edate']; ?>"/>
							<input type="hidden" name="today" value="<?php echo date("Y-m-d"); ?>">
						  </div>
						   <div class="form-group col-md-3">
							<label for="TIME">Time</label>
							<input style="color:#2d2a3b;" type="time" name="event_time" value ="<?php echo $result['posts'][0]['etime']; ?>" id="event_time" class="form-control" placeholder=" Choose a time" />
						  </div>
					     </div>
						 
							
						<div class="row">
						  <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
									<label for="exampleInputPassword1">Registration</label>
                                      <div>
                                         <div class="col-md-4">
                                        <input type="radio" id="user2" name="reg"  value="Yes" <?php echo ($registration=='Yes')?'checked':'' ?>>
                                        <label for="radio5">
                                          Yes
                                        </label>
                                      </div>
                                      <div class="col-md-4">
                                        <input type="radio" id="user2"   name="reg" value="No" <?php echo ($registration=='Yes')?'':'checked' ?>>
                                        <label for="radio6">
                                         No
                                        </label>
                                      </div>
                                    </div>
									
									<!--<input type="hidden" id="user2" name="reg"  value="No">-->
                          </div>
						  <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
						   <label for="TIME">Cost</label>
							<input style="color:#2d2a3b;" type="text" name="cost" id="cost" class="form-control" placeholder="Enter Cost" value="<?php echo $result['posts'][0]['eventCost']; ?>"/>
							</div>
							</div>
							
							<div class="row">
							<div class="form-group col-xs-4 col-sm-4 col-md-4 col-lg-4 myImageRight">
                                <label for="Articlecontent">Select Image</label>
                                <script type="text/javascript">
                                    function showimagepreview(input) {
                                        if (input.files && input.files[0]) {
                                            var filerdr = new FileReader();
                                            filerdr.onload = function (e) {
												var image = new Image();
                                            image.src = e.target.result;
                                            image.onload = function () {
                                                //alert($("#uploadimage")[0].files[0].size);
                                                var height = this.height;
                                                var width = this.width;
                                                var size = parseFloat($("#filUpload")[0].files[0].size / 1024).toFixed(2);
                                                if (size > 2000)
                                                {
                                                    alert("Sorry, your Image Size is too large , Max 2MB Size Are Allowed");
                                                    $('#imgprvw1').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#filUpload').val("");
                                                    return false;
                                                }

                                                else if (height > 1000 || width > 1000) {
                                                    alert("Width and Height must not exceed 1000 X 1000 px.");
                                                    $('#imgprvw1').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#filUpload').val("");
                                                    return false;
                                                }
                                                else
                                                {
                                                    $('#imgprvw1').attr('src', e.target.result);
                                                    $('.post_img').attr('src', e.target.result);
                                                }
                                            }
                                               // $('#imgprvw1').attr('src', e.target.result);
                                               // $('.post_img').attr('src', e.target.result);
                                            }
                                            filerdr.readAsDataURL(input.files[0]);
                                        }
                                    }
									
						
                                </script>
                                <img id="imgprvw1" alt="uploaded image preview" style="margin-bottom:5px; float:right; height:110px; width:200px;border:1px solid #f1f1f0;" 
                                     src='<?php echo $result['posts'][0]['post_img']; ?>' onerror='this.src="images/u.png"'/>
                                <div>
                                      <input type="hidden" name="himage" value ="<?php echo $result['posts'][0]['post_img']; ?>" />
                              <input type="file" name="uploadimage" id="filUpload" onchange="showimagepreview(this)" />
                                </div>
                            </div>
							
							
						  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    <label for="Articlecontent">Description</label>
                                    <textarea class="form-control" rows="5" name="description" id="description"><?php echo $result['posts'][0]['post_content']; ?></textarea>
                                </div>
                            </div>
							</div>
													
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
							
							
							<div class="form-group col-sm-12 col-sm-8 col-md-8 col-lg-8">
                                        <center><input type="submit" name ="news_post" class="btn btn-md btn-info commonColorSubmitBtn" style="text-shadow:none;font-weight:normal;" value="Save Now" id="getData" onclick="return ValidateEvent();" /></center>
                            </div>
							

                           </form>
                </div>
               
            </div>
            
        </div>
    </div>			

</div>

</div>
<?php include 'footer.php'; ?>