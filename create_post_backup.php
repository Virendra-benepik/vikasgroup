	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
		
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
   var count = 1;
   var allCities = [];
   var selectedItems = [];
function  removeItemAndRePopulateDiv(value,theDiv)
{

    var primaryArray = [];
    var secondryArray = [];

       var primaryDiv;
    var secondryDiv;
    if(theDiv == "#allitems")

    { 
      primaryDiv = "#allitems";
      secondryDiv = "#selecteditems";
      primaryArray  = allCities;
      secondryArray = selectedItems;
    }
       

       else
    
    { primaryDiv =  "#selecteditems";
      secondryDiv = "#allitems";
      primaryArray  = selectedItems;
      secondryArray = allCities;
    }
       secondryArray.push(value)

       var index = primaryArray.indexOf(value);
       if (index > -1) {    

         primaryArray.splice(index, 1);
        
    }

    addArrayToDiv(primaryArray,primaryDiv);
    
    addArrayToDiv(secondryArray,secondryDiv);



}


function addArrayToDiv(theArray,theDiv)
{
 $(theDiv).html("");
      for(i=0;i<theArray.length;i++)
 { 
      $(theDiv).append(' <a href=# style="text-decoration:none;" onclick="return removeItemAndRePopulateDiv(\'' + theArray[i]  +'\',\'' + theDiv + '\')"> ' + theArray[i] + ' </a> <br>');
      

 }
        
  
}


$(document).ready(function(){


$("#selecteduser").click(function(){  

                var cat= "sparshgr8@yahoo.com";                  
                $.ajax({
                       type:'POST',
                       url: 'http://admin.benepik.com/employee/virendra/benepik_client/Class_Library/api_getuser.php',
                       data: {
                       username: cat,
                       },
                       dataType: 'jsonp',
                       jsonp: 'mm',
                       jsonpCallback: 'locationCall',
                       success: function(){
                       }
                       });
                });
});
                
                function locationCall(data){
           
        if(count ==1)
        {    
                    var mesg= JSON.stringify(data);
                    var jsonData= JSON.parse(mesg);
                     for(i=0;i<jsonData.posts.length;i++)
                    {
                           allCities.push(jsonData.posts[i].firstName+" "+jsonData.posts[i].lastName);

             }
            addArrayToDiv(allCities,"#allitems",1);

        count++;    
        }
                    
                }
   $(document).ready(function(){
                
 $("#getData").click(function(){
 var cat = "hello";

    $.ajax({
    url: "http://admin.benepik.com/employee/virendra/benepik_client/Link_Library/link_post.php", 
    data: {
               username: cat,
                       },
    success: function(){
       window.location="http://admin.benepik.com/employee/virendra/benepik_client/Link_Library/link_post.php";
    }});
}); 
});
</script>

	<!-------------------------------SCRIPT END FROM HERE   --------->	
	
	<!-------------------------------SCRIPT END FROM HERE   --------->	
	
	<!-------------------------------SCRIPT END FROM HERE   --------->	
			<div class="container-fluid">
               
			   <div class="side-body padding-top">
				
			<div class="bs-example">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#longnewsdiv">News</a></li>
        <li><a data-toggle="tab" href="#shortnewsdiv">Message</a></li>
        <li><a data-toggle="tab" href="#uploadimagediv">Picture</a></li>
       
	  <!-- <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a data-toggle="tab" href="#dropdown1">Dropdown1</a></li>
                <li><a data-toggle="tab" href="#dropdown2">Dropdown2</a></li>
            </ul>
        </li>-->
		
    </ul>
    <div class="tab-content">
        <div id="longnewsdiv" class="tab-pane fade in active">
		
		<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		
	<!---------------------------------long news from start here--------------------------------->	
		
			<form role="form" action="Link_Library/link_post.php" method="post" enctype="multipart/form-data">
             <input type="hidden" name = "flag" value="1">			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="TITLE">TITLE</label>
						<input type="text" name="title" class="form-control" placeholder=" Choose a heading for this article...">
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
<input type="file" name="uploadimage" id="fi" onchange="showimagepreview1(this)" />
</div>

					
				</div>
				
				
				<div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
				<div class="form-group">
  <label for="comment">TEASER TEXT</label>
  <textarea class="form-control" rows="8" id="comment"cols="8" name="teasertext" placeholder="Short paragraph to draw attention to the article... "></textarea>
</div>
				</div>
				<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<label for="Articlecontent">ARTICAL CONTENT</label>
					<div><textarea cols="120" id="editor1" name="content" rows="10">	
	</textarea></div>
					</div>
				</div>
			</div>
			<script>
		CKEDITOR.replace( 'editor1' );  
	</script>   <!--- this is for ckeditor   ----->
			
		<div class="form-group col-md-6">	
<input type="submit" name="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Publish Now" /></div>
	<!--<div class="form-group col-md-6">	
<input type="submit" name="priview_post" class="btn btn-md btn-warning" style="text-shadow:none;font-weight:normal;" value="Save in Draft for Live Preview" /></div> -->
</form>
	</div>
	<!---------------------------------long news from End here--------------------------------->	
	
	<div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
		<div class="publication">
		<p id="publication_heading">PUBLICATION</p><hr>
		<p class="publication_subheading">PUBLICATION TIME</p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Immediately </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="longNewsPublicationDivShow">ON</button>
					<button class="btn btn-primary active btn-xs"id="longNewsPublicationDivHide">OFF</button>
				</div>
				
				<script type='text/javascript'>
        
        $(document).ready(function() {
        
            $('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
    	$(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
    	$(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
    	$(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');
       
});


        
        });
        
        </script>
        
			</div>
		</div>
		
		<script>
$(document).ready(function(){
    $("#longNewsPublicationDivHide").click(function(){
        $("#long_news_hidden_Publicationdiv").hide();
    });
    $("#longNewsPublicationDivShow").click(function(){
        $("#long_news_hidden_Publicationdiv").show();
    });
});
</script>
<div id="long_news_hidden_Publicationdiv" class="collapse">
				<input type="date"/>
				<input type="time"/>
				
				</div>
		
		
		<p class="publication_subheading">UNPUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Not Scheduled </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="longNewsUNPublicationDivShow">ON</button>
					<button class="btn btn-primary active btn-xs"id="longNewsUNPublicationDivHide">OFF</button>
					
				</div>
				
			</div>
		</div>
					
<script>
$(document).ready(function(){
    $("#longNewsUNPublicationDivHide").click(function(){
        $("#long_news_hidden_div").hide();
    });
    $("#longNewsUNPublicationDivShow").click(function(){
        $("#long_news_hidden_div").show();
    });
});
</script> <div id="long_news_hidden_div" class="collapse">
				<input type="date"/>
				<input type="time"/>
				
				</div>



		
		
		<p class="publication_subheading">NOTIFICATIONS</p>
			<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Push </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
<script>
$(document).ready(function(){
    $("#hide").click(function(){
        $("#demopush").hide();
    });
    $("#show").click(function(){
        $("#demopush").show();
    });
});
</script> 
<script>
$(document).ready(function(){
    $("#hidemail").click(function(){
        $("#demomail").hide();
    });
    $("#showmail").click(function(){
        $("#demomail").show();
    });
});
</script> 
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs" id="show">	ON</button>
					<button class="btn btn-primary active btn-xs" id="hide">OFF</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Email </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="showmail">ON</button>
					<button class="btn btn-primary active btn-xs"id="hidemail">OFF</button>
				</div>
			</div>
		</div>
		<!--<center><button type="button"class="btn btn-info">Publish now <p id="demopush">and notify users via push</p><p id="demomail">and email.</p></button></center> -->
		
		
		</div>
		<br>
		<div class="publication"><p id="publication_heading">Options</p><hr>
		
			<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Commenting </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs">ON</button>
					<button class="btn btn-primary active btn-xs">OFF</button>
				</div>
			</div>
			</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Linking </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs">ON</button>
					<button class="btn btn-primary active btn-xs">OFF</button>
				</div>
			</div>
		</div>
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
		
		
	</div>
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
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		
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
				
				<center><input type="submit" name="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Publish Now" /></center>
			</div>
			</form>
	<!----------------------------------- form picture post end here ------------------------------------------>		
			
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			
				<div class="publication">
		<p id="publication_heading">PUBLICATION</p><hr>
		<p class="publication_subheading">PUBLICATION TIME</p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Immediately </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="imagepublicationshow">ON</button>
					<button class="btn btn-primary active btn-xs"id="imagepublicationhide">OFF</button>
				</div>
				
				
			</div>
		</div>
		<script>
$(document).ready(function(){
    $("#imagepublicationhide").click(function(){
        $("#imagerightcontentdiv").hide();
    });
    $("#imagepublicationshow").click(function(){
        $("#imagerightcontentdiv").show();
    });
});
</script>
<div id="imagerightcontentdiv" >
				<input type="date"/>
				<input type="time"/>
				
		</div>
		
		<p class="publication_subheading">UNPUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Not Scheduled </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="imageUNpublicationshow">ON</button>
					<button class="btn btn-primary active btn-xs"id="imageUNpublicationhide">OFF</button>
					
				</div>
				
			</div>
		</div>
		<script>
$(document).ready(function(){
    $("#imageUNpublicationhide").click(function(){
        $("#imagerightUnpublishedcontentdiv").hide();
    });
    $("#imageUNpublicationshow").click(function(){
        $("#imagerightUnpublishedcontentdiv").show();
    });
});
</script>
<div id="imagerightUnpublishedcontentdiv" >
				<input type="date"/>
				<input type="time"/>
				
		</div>
		
		<p class="publication_subheading">NOTIFICATIONS</p>
			<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Push </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
<script>
$(document).ready(function(){
    $("#hideimagepushText").click(function(){
        $("#imagepushtext").hide();
    });
    $("#showimagepushText").click(function(){
        $("#imagepushtext").show();
    });
});
</script> 

				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="showimagepushText">	ON</button>
					<button class="btn btn-primary active btn-xs" id="hideimagepushText">OFF</button>
				</div>
			</div>
		</div>
		
		<script>
$(document).ready(function(){
    $("#HIDemailText").click(function(){
        $("#imageemailtext").hide();
    });
    $("#SHOwmailText").click(function(){
        $("#imageemailtext").show();
    });
});
</script> 
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Email </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="SHOwmailText">ON</button>
					<button class="btn btn-primary active btn-xs"id="HIDemailText">OFF</button>
				</div>
			</div>
		</div>
		<center><button type="button"class="btn btn-info">Publish now <p id="imagepushtext">and notify users via push</p><p id="imageemailtext">and email.</p></button></center>
		
		
		</div>
				
		
				<br>
		<div class="publication"><p id="publication_heading">Options</p><hr>
		
			<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Commenting </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs">ON</button>
					<button class="btn btn-primary active btn-xs">OFF</button>
				</div>
			</div>
			</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Linking </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs">ON</button>
					<button class="btn btn-primary active btn-xs">OFF</button>
				</div>
			</div>
		</div>
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
				
				
			</div>
			
			</div>
					
					
					
					
					
					
			</div>
        <!--<div id="dropdown1" class="tab-pane fade">
            <h3>Dropdown 1</h3>
            <p>WInteger convallis, nulla in sollicitudin placerat, ligula enim auctor lectus, in mollis diam dolor at lorem. Sed bibendum nibh sit amet dictum feugiat. Vivamus arcu sem, cursus a feugiat ut, iaculis at erat. Donec vehicula at ligula vitae venenatis. Sed nunc nulla, vehicula non porttitor in, pharetra et dolor. Fusce nec velit velit. Pellentesque consectetur eros.</p>
        </div>
        <div id="dropdown2" class="tab-pane fade">
            <h3>Dropdown 2</h3>
            <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis.</p>
        </div>-->
    </div>
</div>
                   
				</div>
            </div>
				<?php include 'footer.php';?>