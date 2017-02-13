<! doctype html>
	<html>
		<head>
			<title>
			</title>
			 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <script>
	$(document).ready(function(){
    $("#hide").click(function(){
        $("#MyDivIsHere").hide();
    });
    $("#show").click(function(){
        $("#MyDivIsHere").show();
    });
});
  </script>
  <style>
 #myphotodata2, #myphotodata, #MyDivIsHere{display: none ;}
 #photo, #myphoto2, #myphoto3, #myphoto4, #myphoto{height:60px; width:60px;}
 sup{color:red;} </style>
  
		</head>
		<body>
		<div class="container">
		
​
​
	 <form role="form">
    <label class="radio-inline">
      <input type="radio" name="optradio"id="show">Selected User
    </label>
    <label class="radio-inline">
      <input type="radio" name="optradio"id="hide">All
    </label>
  
  </form>
   <!--*******************this is the output after selected from dropdown******************************-->
   <script>
	$(document).ready(function(){
    $("#myphotohide").click(function(){
        $("#myphotodata").hide();
    });
    $("#myphoto").click(function(){
        $("#myphotodata").show();
    });
});
  </script>
   <script>
	$(document).ready(function(){
    $("#myphotohide2").click(function(){
        $("#myphotodata2").hide();
    });
    $("#myphoto2").click(function(){
        $("#myphotodata2").show();
    });
});
  </script>
  <div class="row">
  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
  <div id="myphotodata"> <img src="icon.png"id="photo"/> Veeru &nbsp;&nbsp; <sup id="myphotohide">close</sup></div>
  </div>
  
  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
  <div id="myphotodata2"> <img src="icon.png"id="photo"/> Hello <sup id="myphotohide2">close</sup></div>
  </div>
  </div>
  <!--**************************************************-->
  <!--*********************this code will be hide the selected item from the dropdown and after close button it will be show in dropdown also*****************************-->
 <script>
	$(document).ready(function(){
    $("#myphoto").click(function(){
        $("#listmyphoto1").hide();
    });
    $("#myphotohide").click(function(){
       $("#listmyphoto1").show();
    });
});
  </script>    
​
	<script>
	$(document).ready(function(){
    $("#myphoto2").click(function(){
        $("#listmyphoto2").hide();
    });
    $("#myphotohide2").click(function(){
       $("#listmyphoto2").show();
    });
});
  </script>
  <div id="MyDivIsHere">
   <form role="form">
    <div class="btn-group" style="margin:10px;">    <!-- CURRENCY, BOOTSTRAP DROPDOWN -->
                <!--<a class="btn btn-primary" href="javascript:void(0);">Currency</a>-->                    
                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Select User From Here...<span class="caret"></span></a>
                <ul class="dropdown-menu">
				
                    <li id="listmyphoto1"><a href="javascript:void(0);">
                        <img src="icon.png"id="myphoto"/> Veeru </a>
                    </li>
				
                    <li id="listmyphoto2"><a href="javascript:void(0);">
                        <img src="icon.png"id="myphoto2"/>Hello</a>
                    </li>
                   
                   
                </ul>
            </div>
​
<script>
/* BOOTSTRAP DROPDOWN MENU - Update selected item text and image */
$(".dropdown-menu li a").click(function () {
    var selText = $(this).text();
    var imgSource = $(this).find('img').attr('src');
    var img = '<img src="' + imgSource + '"style="width:100px;height:100px;"/>';        
    $(this).parents('.btn-group').find('.dropdown-toggle').html(img + ' ' + selText + ' <span class="caret"></span>');
});
</script>
​
  </form>
  </div>
  
  
 
 
</div>
​
		</body>
</html>