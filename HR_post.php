
	<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
			<div class="container-fluid">
               
			   <div class="side-body padding-top">
					
   
		
		<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		
	
	
	<h3>put pluggin here...</h3>
	
	
	
	
	
	
	
		
		
			
			
			<center><a href="#"><button type="button"class="btn btn-md btn-info"style="text-shadow:none;font-weight:normal;">Save draft</button></a></center>

	
	</div>
	
	
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

$('form').submit(function(){
	alert($(this["options"]).val());
    return false;
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
		<center><button type="button"class="btn btn-info">Publish now <p id="demopush">and notify users via push</p><p id="demomail">and email.</p></button></center>
		
		
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
		  
    </div>
</div>
                   
				</div>
            </div>
				<?php include 'footer.php';?>