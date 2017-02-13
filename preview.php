<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .MyPriviewButton{width:100%;margin-bottom:10px;}
  .MyPriviewButton a{color:#fff;}


<!--******************************************faltu*******************************************-->

#rightoneIphone5{    width: 70%;   margin-top:-1%;   height: 527px;   position: absolute;    left: 30%; border-left: 1px dotted gray;background: white;}


#iphone{          background: url("images/i6.png");    background-size:42% 100%;  background-repeat: no-repeat; height: 530px;  background-position:30% 10%; border-left:1px dotted #dcdcdc;  }

#androidPhone{     background: url("images/sam3.png");    background-size:56% 100%;background-repeat: no-repeat; height: 513px;  background-position:30% 10%; border-left:1px dotted #dcdcdc;  }








  </style>
  
</head>
<body>

<div class="container">
  
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Content Preview </h4>
        </div>
        <div class="modal-body">
        
		  <div class="row">
		  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		
   <a data-toggle="pill" href="#home"><p class="btn btn-primary btn-md active MyPriviewButton"> iPhone Phone</p></a><br>
     <a data-toggle="pill" href="#menu1">   <p class="btn btn-primary btn-md MyPriviewButton">Android Phone</p></a>
    
  </div>
  <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     
      <div id="iphone"></div>
    </div>
    <div id="menu1" class="tab-pane fade">
     
<div id="androidPhone"></div>
    </div>
    
  
  </div>
  </div>
  
		  
		  
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>

