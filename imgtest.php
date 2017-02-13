 <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	

  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script>

  

  <style type="text/css">

<!--upload button -->

#files{width: 100%;height:75px; -webkit-appearance: none;}
#files{content: url('img/hr.jpg');display: block;}

#list .thumbParent img{border:1px solid #cdcdcd; margin-left: 32px;margin-bottom:2%;}
#server img, .thumb {height: 150px;}

    .thumb {width: 20%;margin: 0.2em -0.7em 0 0;}
.remove_thumb {  position: relative;top: -76px;right: 5px;background: black;color: white;border-radius: 50px;font-size: 1.5em;padding: 0 0.3em 0;
text-align: center;cursor: pointer;}
.remove_thumb:before {    content: "×";}

#server img{
  max-width:100%;
}
  </style>

    




<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
var $fileUpload = $("#files"),
    $list = $('#list'),
    thumbsArray = [],
    maxUpload = 5;

// READ FILE + CREATE IMAGE
function read( f ) {
  return function( e ) {
	var base64 =  e.target.result;
	var $img = $('<img/>', {
	  src: base64,
	  title: encodeURIComponent(f.name), //( escape() is deprecated! )
	  "class": "thumb"
    });
	var $thumbParent = $("<span/>",{html:$img, "class":"thumbParent"}).append('<span class="remove_thumb"/>');
	thumbsArray.push(base64); // Push base64 image into array or whatever.
    $list.append(  $thumbParent  );
  };
}

// HANDLE FILE/S UPLOAD
function handleFileSelect( e ) {
    e.preventDefault(); // Needed?
	var files = e.target.files;
    var len = files.length;
    if(len>maxUpload || thumbsArray.length >= maxUpload){
	  return alert("Sorry you can upload only 5 images");
	}
    for (var i=0; i<len; i++) { 
	    var f = files[i];
	    if (!f.type.match('image.*')) continue; // Only images allowed		
        var reader = new FileReader();
        reader.onload = read(f); // Call read() function
        reader.readAsDataURL(f);
    }
} 

$fileUpload.change(function( e ) {
    handleFileSelect(e);
});

$list.on('click', '.remove_thumb', function () {
    var $removeBtns = $('.remove_thumb'); // Get all of them in collection
    var idx = $removeBtns.index(this );   // Exact Index-from-collection
    $(this).closest('span.thumbParent').remove(); // Remove tumbnail parent
    thumbsArray.splice(idx, 1); // Remove from array
}); 


// that's it. //////////////////////////////
// Let's test //////////////////////////////

$('#upload').click(function(){
  var testImages = "";
  for(var i=0; i<thumbsArray.length; i++){
	testImages += "<div class='col-xs-6 col-sm-3 col-3 col-lg-3'><img src='"+thumbsArray[i]+"'></div>";
  }
  $('#server').empty().append(testImages);
});
});//]]> 

</script>

<div class="container" style="margin-left:10%;margin-top:5%;"><br>

<div class="row">
<div class="col-xs-12 col-sm-6 col-6 col-lg-6">
<div class="form-group">
  <label for="title">Album Title</label>
  <input type="text" class="form-control" id=""class="Album Title">
</div>
</div>

<div class="col-xs-12 col-sm-6 col-6 col-lg-6">
<div class="form-group">
  <label for="comment">Discription</label>
  <textarea class="form-control" rows="3" id=""placeholder="Discription..."></textarea>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-12 col-lg-12">
  <input type="file" id="files" name="image_file_arr[]" multiple>
</div>
</div>

<output id="list"></output>
  
  <br><br>
  <button id="upload">UPLOAD</button>  
  <div id="server">THIS, IS, SERVER!!! :-D</div>
	</div>
