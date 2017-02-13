$(document).ready(function(){

$("#close_news_priview").click(function(){
        $("#testpopup").hide();
});

$("#preview_post").click(function(){

$("#preview_div").css({"display":"block"});
var content = CKEDITOR.instances.editor1.getData();
$(".preview_content").html(content);

});
    
});

function showimagepreview1(input) {
$("#img_preview").css({"display":"block"});
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw').attr('src', e.target.result);
//$('#imgprvw1').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}



$("#img_preview1").css({"display":"block"});
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw1').attr('src', e.target.result);

}
filerdr.readAsDataURL(input.files[0]);
}



}
