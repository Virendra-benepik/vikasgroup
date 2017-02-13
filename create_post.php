	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
		
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="js/display_user.js"></script>

	<!-------------------------------SCRIPT END FROM HERE   --------->	
	
			<div class="container-fluid">
               
		 <div class="side-body padding-top">		
			<div class="bs-example">
			
          <ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#longnewsdiv">News</a></li>
			<li><a data-toggle="tab" href="#shortnewsdiv">Message</a></li>
			<li><a data-toggle="tab" href="#uploadimagediv">Picture</a></li>
         </ul>
	   
	   
           <div class="tab-content">
           <div id="longnewsdiv" class="tab-pane fade in active">
		
			<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		
	<!---------------------------------long news from start here--------------------------------->	
		
			<form role="form" action="Link_Library/link_post.php" method="post" enctype="multipart/form-data">
             <input type="hidden" name = "flag" value="1" id="flag">			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="TITLE">TITLE</label>
						<input type="text" name="title" id="title" class="form-control" placeholder=" Choose a heading for this article...">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
					
						<label for="Article image">ARTICAL IMAGE</label>
						
						<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>

<script type="text/javascript">
function showimagepreview1(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}
</script>
<img id="imgprvw" alt="uploaded image preview"/>
<div>
<input type="file" name="uploadimage" id="imagefile" onchange="showimagepreview1(this)" />
</div>

					
				</div>
				
				
				<div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
				<div class="form-group">
  <label for="comment">TEASER TEXT</label>
  <textarea class="form-control" rows="8" id="teasertext"cols="8" name="teasertext" placeholder="Short paragraph to draw attention to the article... "></textarea>
</div>
				</div>
				<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">ARTICAL CONTENT</label>
					<div><textarea cols="120" id="editor1" name="content" id="content" rows="10">	
	</textarea></div>
					</div>
				</div>
			</div>
			<script>
		CKEDITOR.replace( 'editor1' );  
	</script>   <!--- this is for ckeditor   ----->
		
          <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="radio3 radio-check radio-success radio-inline">
                                            <input type="radio" id="radio5" name="selecteduser" value="Male">
                                            <label for="radio5">
                                              Send Post to All Users
                                            </label>
                                          </div>
                                          <div class="radio3 radio-check radio-warning radio-inline">
                                            <input type="radio" id="radio6" name="selecteduser" value="Female">
                                            <label for="radio6">
                                             Send Post to Selected users
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button---------------------->                        
	<script type="text/javascript">
    $(function () {
     $("#show_textbox").hide();
        $("input[name='selecteduser']").click(function () {
            if ($("#radio6").is(":checked")) {
                $("#show_textbox").show();
            } else {
                $("#show_textbox").hide();
            }
        });
    });
</script>	
		
	  <!------------Abobe script for show textbox on select radio button---------------------->
              <div id ="show_textbox">
	    				<div class="form-group col-sm-6" >
					<input type="text" name ="selecteduser" id="selecteduser" class="form-control" placeholder=" Choose group" />					</div>
					
					<div id="selecteditems1" class="form-group col-sm-6" >
					<p id="selecteditems"></p>
					data is here.............
					
					</div> 
					
					<div id="allitems" class="form-group col-sm-12" >
					show all data here.......
					
					</div>
					<textarea id ="allids" style="display:none;" height="660"></textarea>
                                         <textarea id ="selectedids" name="selected_user" style="display:none;" ></textarea>
					</div>
        
        	
		<div class="form-group col-md-12">	
<input type="submit" name="news_post"  class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Publish Now" /></div>
	
</form>
	</div>
	<!---------------------------------long news from End here--------------------------------->	
	
	
	</div>
	
	 </div>
	 
<!------------------------------------------message portal start from here------------------------------------------------>	
 
        <div id="shortnewsdiv" class="tab-pane fade">
		
		<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			<form role="form" method="post" >
			<input type="hidden" name = "flag" value="2">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">Message</label>
						<div>
						<textarea cols="80" id="message" name="content" rows="10">	
	                    </textarea>
						</div>
					</div>
					
					   
                                         <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="radio3 radio-check radio-success radio-inline">
                                            <input type="radio" id="radio5" name="selecteduser" value="Male">
                                            <label for="radio5">
                                              Send Post to All Users
                                            </label>
                                          </div>
                                          <div class="radio3 radio-check radio-warning radio-inline">
                                            <input type="radio" id="radio6" name="selecteduser" value="Female">
                                            <label for="radio6">
                                             Send Post to Selected users
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button---------------------->                        
	<script type="text/javascript">
    $(function () {
     $("#show_textbox").hide();
        $("input[name='selecteduser']").click(function () {
            if ($("#radio6").is(":checked")) {
                $("#show_textbox").show();
            } else {
                $("#show_textbox").hide();
            }
        });
    });
</script>				
	  <!------------Abobe script for show textbox on select radio button---------------------->
	                               <div id ="show_textbox">
	    				<div class="form-group col-sm-6" >
					<input type="text" name ="selecteduser" id="selecteduser" class="form-control" placeholder=" Choose group" />					</div>
					
					<div id="selecteditems" class="form-group col-sm-6" >
					data is here.............
					
					</div>
					
					<div id="allitems" class="form-group col-sm-12" >
					show all data here.......
					</div>
					</div>
					<div class="form-group col-sm-12">
						<input type="submit" name ="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Publish Now" id="getData" />
					</div>
					
				</div>
				</form>
			</div>
		<!-----------------------------------message form end from here---------------------------------->		
				
		</div>
		
		</div>
	</div>
		<div id="uploadimagediv" class="tab-pane fade">
            
			
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			
	<!----------------------------------- form picture post staryt here ------------------------------------------>		
			<div class="row">
				<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
					<div class="form-group">
						<label for="Articlecontent">GALLERY IMAGE</label>
						
						
			<form role="form" action="Link_Library/link_post.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name = "flag" value="3">
<script type="text/javascript">
function showimagepreview(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw1').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}
</script>
<img id="imgprvw1" alt="uploaded image preview"/>
<div>
<input type="file" name="uploadimage" id="filUpload" onchange="showimagepreview(this)" />
</div>

					</div>
				</div>
			
				<div class="col-lg-7 col-sm-7 col-md-7 col-xs-7">
				<div class="form-group">
						<label for="Articlecontent">DESCRIPTION</label>
				<textarea class="form-control" name="content"  placeholder="Choose a caption for this image...">	</textarea>
				</div>
				</div>
				
                 <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="radio3 radio-check radio-success radio-inline">
                                            <input type="radio" id="radio5" name="selecteduser" value="Male">
                                            <label for="radio5">
                                              Send Post to All Users
                                            </label>
                                          </div>
                                          <div class="radio3 radio-check radio-warning radio-inline">
                                            <input type="radio" id="radio6" name="selecteduser" value="Female">
                                            <label for="radio6">
                                             Send Post to Selected users
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button---------------------->                        
	<script type="text/javascript">
    $(function () {
     $("#show_textbox").hide();
        $("input[name='selecteduser']").click(function () {
            if ($("#radio6").is(":checked")) {
                $("#show_textbox").show();
            } else {
                $("#show_textbox").hide();
            }
        });
    });
</script>				
	  <!------------Abobe script for show textbox on select radio button---------------------->
                  <div id ="show_textbox">
	    				<div class="form-group col-sm-6" >
					<input type="text" name ="selecteduser" id="selecteduser" class="form-control" placeholder=" Choose group" />					</div>
					
					<div id="selecteditems" class="form-group col-sm-6" >
					data is here.............
					
					</div>
					
					<div id="allitems" class="form-group col-sm-12" >
					show all data here.......
					<textarea name="selected_user"> co-1,co-2,co-3</textarea>
					</div>
					</div>    
			<div class="form-group col-sm-12">
						<input type="submit" name ="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Publish Now" id="getData" />
					</div>
			</div>
			</form>
	<!----------------------------------- form picture post end here ------------------------------------------>		
			
			</div>
			
			
			</div>
		
			</div>
       
    </div>
</div>
                   
				</div>
            </div>
				<?php include 'footer.php';?>